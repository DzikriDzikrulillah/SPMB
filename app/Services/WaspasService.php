<?php

namespace App\Services;

use App\Models\BobotKriteria;
use App\Models\HasilWaspas;
use App\Models\Jalur;
use App\Models\Pendaftar;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WaspasService
{
    public function calculate(): Collection
    {
        $participants = Pendaftar::query()
            ->approved()
            ->whereNotNull('jalur')
            ->orderBy('id')
            ->get();

        if ($participants->isEmpty()) {
            HasilWaspas::query()->delete();

            return new Collection();
        }

        $weights = BobotKriteria::query()
            ->with('jalur')
            ->get()
            ->filter(fn($item) => $item->jalur !== null)
            ->values();

        $rows = collect();

        foreach ($participants->groupBy('jalur') as $jalurName => $group) {
            $weight = $this->resolveWeightForJalur($weights, $jalurName);

            if ($weight === null) {
                continue;
            }

            $preparedGroup = $group->map(function (Pendaftar $pendaftar) {
                $pendaftar->syncDerivedAttributes();

                if ($pendaftar->isDirty(['akhir', 'penghasilan_orangtua'])) {
                    $pendaftar->saveQuietly();
                }

                return $pendaftar;
            })->values();

            $minJarak = max((float) $preparedGroup->min('jarak_km'), 0.000001);
            $minPenghasilanPositif = $this->resolveMinPositiveCostValue($preparedGroup->pluck('penghasilan_orangtua'));
            $maxNilai = max((float) $preparedGroup->max('akhir'), 0.000001);
            $maxUS = max((float) $preparedGroup->max('us'), 0.000001);

            $jalurRows = $preparedGroup
                ->map(function (Pendaftar $pendaftar) use ($jalurName, $weight, $minJarak, $minPenghasilanPositif, $maxNilai, $maxUS) {
                    $jarak = max((float) $pendaftar->jarak_km, 0.000001);
                    $penghasilan = (float) $pendaftar->penghasilan_orangtua;
                    $nilaiAkhir = max((float) $pendaftar->akhir, 0.000001);
                    $us = max((float) $pendaftar->us, 0.000001);

                    $normalisasiJarak = $minJarak / $jarak;
                    $normalisasiPenghasilan = $this->normalizeCostIncomeForCalculation($penghasilan, $minPenghasilanPositif);
                    $normalisasiNilai = $nilaiAkhir / $maxNilai;
                    $normalisasiUs = $us / $maxUS;

                    $wsm =
                        ($normalisasiJarak * $weight->bobot_jarak) +
                        ($normalisasiPenghasilan * $weight->bobot_penghasilan_orangtua) +
                        ($normalisasiNilai * $weight->bobot_nilai_akhir) +
                        ($normalisasiUs * $weight->bobot_us);

                    $wpm =
                        pow($normalisasiJarak, $weight->bobot_jarak) *
                        pow($normalisasiPenghasilan, $weight->bobot_penghasilan_orangtua) *
                        pow($normalisasiNilai, $weight->bobot_nilai_akhir) *
                        pow($normalisasiUs, $weight->bobot_us);

                    return [
                        'pendaftar_id' => $pendaftar->id,
                        'jalur' => trim((string) $jalurName),
                        'jarak' => round((float) $pendaftar->jarak_km, 4),
                        'penghasilan_orangtua' => round((float) $pendaftar->penghasilan_orangtua, 4),
                        'nilai_akhir' => round((float) $pendaftar->akhir, 4),
                        'us' => round($us, 4),
                        'normalisasi_jarak' => round($normalisasiJarak, 4),
                        'normalisasi_penghasilan_orangtua' => round($normalisasiPenghasilan, 4),
                        'normalisasi_nilai_akhir' => round($normalisasiNilai, 4),
                        'normalisasi_us' => round($normalisasiUs, 4),
                        'wsm' => round($wsm, 4),
                        'wpm' => round($wpm, 4),
                        'qi' => round((0.5 * $wsm) + (0.5 * $wpm), 4),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->sortByDesc('qi')
                ->values()
                ->map(function (array $row, int $index) {
                    $row['ranking_jalur'] = $index + 1;

                    return $row;
                });

            $rows = $rows->concat($jalurRows);
        }

        // rows already contains per-jalur ranking in 'ranking_jalur'
        $rowsToInsert = $rows->values();

        DB::transaction(function () use ($rowsToInsert) {
            HasilWaspas::query()->delete();

            if ($rowsToInsert->isNotEmpty()) {
                HasilWaspas::query()->insert($rowsToInsert->all());
            }

            // $rankMap = $rowsToInsert->keyBy('pendaftar_id');

            // Pendaftar::query()->approved()->get()->each(function (Pendaftar $pendaftar) use ($rankMap) {
            //     $result = $rankMap->get($pendaftar->id);

            //     $pendaftar->forceFill([
            //         'nilai_preferensi' => $result['qi'] ?? null,
            //         // set global ranking equal to per-jalur ranking to avoid cross-jalur comparison
            //         'ranking' => $result['ranking_jalur'] ?? null,
            //     ])->saveQuietly();
            // });
        });

        return $this->getResults();
    }

    /**
     * Apply automatic selection using `kuota` defined per `jalur`.
     * If a jalur has kuota 0 it will not accept anyone.
     */
    public function autoSelectPerJalur(): void
    {
        $results = $this->getResults();

        if ($results->isEmpty()) {
            $results = $this->calculate();
        }

        $jalurRecords = Jalur::query()->get()->keyBy(function ($item) {
            return $this->normalizeJalurName($item->jalur);
        });

        $acceptedIds = collect();

        $results->groupBy('jalur')->each(function ($group, $jalurName) use ($acceptedIds, $jalurRecords) {
            $normalizedJalur = $this->normalizeJalurName($jalurName);
            $jalurRecord = $jalurRecords->get($normalizedJalur);

            $kuota = (int) optional($jalurRecord)->kuota;

            if ($kuota <= 0) {
                return;
            }

            $top = $group->sortBy('ranking_jalur')->take($kuota)->pluck('pendaftar_id');

            $acceptedIds->push(...$top->all());
        });

        $acceptedIds = $acceptedIds->unique()->values()->all();

        $resultMap = $results->keyBy('pendaftar_id');

        DB::transaction(function () use ($acceptedIds, $resultMap) {
            // Update pendaftar status seleksi
            Pendaftar::query()->approved()->get()->each(function (Pendaftar $pendaftar) use ($acceptedIds, $resultMap) {
                $result = $resultMap->get($pendaftar->id);

                if ($result === null) {
                    $pendaftar->forceFill([
                        'status_seleksi' => 'ditolak',
                    ])->saveQuietly();

                    return;
                }

                if (in_array($pendaftar->id, $acceptedIds, true)) {
                    $pendaftar->forceFill([
                        'status_seleksi' => 'diterima',
                    ])->saveQuietly();

                    return;
                }

                $pendaftar->forceFill([
                    'status_seleksi' => 'ditolak',
                ])->saveQuietly();
            });
        });
    }
    public function getCalculationInfo(): array
    {
        $approvedJalurs = Pendaftar::query()
            ->approved()
            ->whereNotNull('jalur')
            ->select('jalur')
            ->distinct()
            ->pluck('jalur')
            ->filter()
            ->values();

        $weights = BobotKriteria::query()->with('jalur')->get()->filter(fn($item) => $item->jalur !== null)->values();

        $missingWeights = $approvedJalurs
            ->filter(fn($jalurName) => $this->resolveWeightForJalur($weights, $jalurName) === null)
            ->values();

        return [
            'approved_count' => Pendaftar::query()->approved()->count(),
            'approved_jalurs' => $approvedJalurs->all(),
            'configured_weight_count' => $weights->count(),
            'missing_weights' => $missingWeights->all(),
        ];
    }

    public function getCriteriaExtremesForJalur(?string $jalur): array
    {
        if (empty($jalur)) {
            return [];
        }

        $query = Pendaftar::query()
            ->approved()
            ->where('jalur', $jalur);

        if (! $query->exists()) {
            return [];
        }

        return [
            'max_nilai_akhir' => (float) $query->max('akhir'),
            'min_nilai_akhir' => (float) $query->min('akhir'),
            'max_us' => (float) $query->max('us'),
            'min_us' => (float) $query->min('us'),
            'max_jarak' => (float) $query->max('jarak_km'),
            'min_jarak' => (float) $query->min('jarak_km'),
            'max_penghasilan_orangtua' => (float) $query->max('penghasilan_orangtua'),
            'min_penghasilan_orangtua' => (float) $query->min('penghasilan_orangtua'),
        ];
    }

    public function getResults(): Collection
    {
        return HasilWaspas::query()
            ->with('pendaftar')
            ->orderBy('jalur')
            ->orderBy('ranking_jalur')
            ->get();
    }

    public function getWaspasResults(?string $jalur = null, int $perPage = 10): LengthAwarePaginator
    {
        return HasilWaspas::query()
            ->with('pendaftar')
            ->when($jalur, fn($query) => $query->where('jalur', $jalur))
            ->orderBy('jalur')
            ->orderBy('ranking_jalur')
            ->paginate($perPage);
    }

    public function applyWaspasResultFilters(?string $jalur = null, ?string $gelombang = null, ?string $jurusan = null, ?string $sortBy = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = HasilWaspas::query()->with('pendaftar');

        // Filter by jalur with normalization
        if ($jalur) {
            $normalizedJalur = $this->normalizeJalurName($jalur);
            $query->where(function ($q) use ($jalur, $normalizedJalur) {
                $q->where('jalur', $jalur)
                    ->orWhere('jalur', 'like', '%' . $jalur . '%')
                    ->orWhereRaw('LOWER(jalur) = ?', [strtolower($normalizedJalur)]);
            });
        }

        // Filter by gelombang (from pendaftar relationship)
        if ($gelombang) {
            $query->whereHas('pendaftar', fn($q) => $q->where('gelombang', $gelombang));
        }

        // Filter by jurusan (from pendaftar relationship)
        if ($jurusan) {
            $query->whereHas('pendaftar', fn($q) => $q->where('jurusan', $jurusan));
        }

        // Sorting
        if ($sortBy === 'qi') {
            $query->orderByDesc('qi');
        } elseif ($sortBy === 'nama') {
            $query->join('pendaftar as p', 'hasil_waspas.pendaftar_id', '=', 'p.id')
                ->orderBy('p.nama_siswa');
        } elseif ($sortBy === 'jarak') {
            $query->orderBy('jarak');
        } elseif ($sortBy === 'nilai') {
            $query->orderByDesc('nilai_akhir');
        } else {
            $query->orderBy('jalur')->orderBy('ranking_jalur');
        }

        return $query->paginate($perPage);
    }

    public function autoSelect(int $quota): void
    {
        $results = $this->getResults();

        if ($results->isEmpty()) {
            $results = $this->calculate();
        }

        $acceptedIds = $results
            ->groupBy('jalur')
            ->flatMap(function ($group) use ($quota) {
                return $group
                    ->sortBy('ranking')
                    ->take($quota)
                    ->pluck('pendaftar_id');
            })
            ->all();

        $resultMap = $results->keyBy('pendaftar_id');

        DB::transaction(function () use ($acceptedIds, $resultMap) {
            Pendaftar::query()->approved()->get()->each(function (Pendaftar $pendaftar) use ($acceptedIds, $resultMap) {
                $result = $resultMap->get($pendaftar->id);

                if ($result === null) {
                    $pendaftar->forceFill([
                        'status_seleksi' => 'ditolak',
                    ])->saveQuietly();

                    return;
                }

                if (in_array($pendaftar->id, $acceptedIds, true)) {
                    $pendaftar->forceFill([
                        'status_seleksi' => 'diterima',
                    ])->saveQuietly();

                    return;
                }

                $pendaftar->forceFill([
                    'status_seleksi' => 'ditolak',
                ])->saveQuietly();
            });
        });
    }

    public function setManualSelection(Pendaftar $pendaftar, string $status): void
    {
        if ((int) $pendaftar->acc !== 1) {
            abort(422, 'murid belum ACC berkas dan belum dapat diproses seleksi.');
        }

        $pendaftar->forceFill([
            'status_seleksi' => $status === 'diterima' ? 'DITERIMA' : 'TIDAK',
        ])->saveQuietly();
    }

    public function getSummary(): array
    {
        $results = $this->getResults();
        $jalurRecords = Jalur::query()->get();

        $summaryMap = $jalurRecords->reduce(function ($carry, $jalur) {
            $normalized = $this->normalizeJalurName($jalur->jalur);

            if (! $carry->has($normalized)) {
                $carry->put($normalized, [
                    'jalur' => $jalur->jalur,
                    'kuota' => (int) $jalur->kuota,
                    'total_pendaftar' => 0,
                    'total_acc' => 0,
                    'diterima' => 0,
                    'ditolak' => 0,
                    'pending' => 0,
                    'sisa_kuota' => (int) $jalur->kuota,
                ]);
            }

            return $carry;
        }, collect());

        $pendaftarCounts = Pendaftar::query()
            ->whereNotNull('jalur')
            ->select('jalur', DB::raw('count(*) as total_pendaftar'))
            ->groupBy('jalur')
            ->get();

        foreach ($pendaftarCounts as $count) {
            $normalized = $this->normalizeJalurName($count->jalur);

            if (! $summaryMap->has($normalized)) {
                $summaryMap->put($normalized, [
                    'jalur' => $count->jalur,
                    'kuota' => 0,
                    'total_pendaftar' => (int) $count->total_pendaftar,
                    'total_acc' => 0,
                    'diterima' => 0,
                    'ditolak' => 0,
                    'pending' => 0,
                    'sisa_kuota' => 0,
                ]);
            } else {
                $row = $summaryMap->get($normalized);
                $row['total_pendaftar'] = (int) $count->total_pendaftar;
                $summaryMap->put($normalized, $row);
            }
        }

        foreach ($results as $item) {
            $normalized = $this->normalizeJalurName($item->jalur);

            if (! $summaryMap->has($normalized)) {
                $summaryMap->put($normalized, [
                    'jalur' => $item->jalur,
                    'kuota' => 0,
                    'total_pendaftar' => 0,
                    'total_acc' => 0,
                    'diterima' => 0,
                    'ditolak' => 0,
                    'pending' => 0,
                    'sisa_kuota' => 0,
                ]);
            }

            $row = $summaryMap->get($normalized);
            $row['total_acc']++;

            if ($item->pendaftar->status_seleksi === 'diterima') {
                $row['diterima']++;
            } elseif ($item->pendaftar->status_seleksi === 'ditolak') {
                $row['ditolak']++;
            } else {
                $row['pending']++;
            }

            $row['sisa_kuota'] = max(0, $row['kuota'] - $row['diterima']);
            $summaryMap->put($normalized, $row);
        }

        $jalurSummary = $summaryMap->values()->sortBy('jalur')->values()->all();

        return [
            'total_pendaftar' => Pendaftar::query()->whereNotNull('jalur')->count(),
            'acc' => Pendaftar::query()->where('acc', 1)->count(),
            'tidak_acc' => Pendaftar::query()->where('acc', 0)->count(),
            'diterima' => Pendaftar::query()->where('status_seleksi', 'diterima')->count(),
            'ditolak' => Pendaftar::query()->where('status_seleksi', 'ditolak')->count(),
            'jalur_summary' => $jalurSummary,
        ];
    }

    public function applyParticipantFilters($query, array $filters = [])
    {
        $selectedJalur = $filters['jalur'] ?? null;
        $sortBy = $filters['sort_by'] ?? null;
        $selectedGelombang = $filters['gelombang'] ?? null;
        $selectedJurusan = $filters['jurusan'] ?? null;

        // Filter by jalur with normalization
        $query->when($selectedJalur, function ($builder) use ($selectedJalur) {
            $normalizedJalur = $this->normalizeJalurName($selectedJalur);
            $builder->where(function ($query) use ($selectedJalur, $normalizedJalur) {
                $query->where('jalur', $selectedJalur)
                    ->orWhere('jalur', 'like', '%' . $selectedJalur . '%')
                    ->orWhereRaw('LOWER(jalur) = ?', [strtolower($normalizedJalur)]);
            });
        });

        // Filter by gelombang
        $query->when($selectedGelombang, fn($builder) => $builder->where('gelombang', $selectedGelombang));

        // Filter by jurusan
        $query->when($selectedJurusan, fn($builder) => $builder->where('jurusan', $selectedJurusan));

        // Sorting
        if ($sortBy === 'nilai') {
            $query->orderByDesc('akhir');
        } elseif ($sortBy === 'jarak_km' || $sortBy === 'jarak') {
            $query->orderBy('jarak_km');
        } elseif ($sortBy === 'nama') {
            $query->orderBy('nama_siswa');
        } elseif ($sortBy === 'terbaru') {
            $query->orderByDesc('created_at');
        } else {
            $query->orderByDesc('id');
        }

        return $query;
    }

    protected function resolveWeightForJalur(Collection $weights, ?string $jalurName): ?BobotKriteria
    {
        if ($jalurName === null || trim($jalurName) === '') {
            return null;
        }

        $normalizedTarget = $this->normalizeJalurName($jalurName);

        return $weights->first(function (BobotKriteria $weight) use ($jalurName, $normalizedTarget) {
            $jalur = $weight->jalur?->jalur;

            if ($jalur === null) {
                return false;
            }

            if ((string) $weight->jalur_id === (string) $jalurName) {
                return true;
            }

            return $this->normalizeJalurName($jalur) === $normalizedTarget;
        });
    }

    protected function resolveMinPositiveCostValue(\Illuminate\Support\Collection $values): ?float
    {
        $positiveValues = $values
            ->map(fn($value) => (float) $value)
            ->filter(fn(float $value) => $value > 0)
            ->values();

        if ($positiveValues->isEmpty()) {
            return null;
        }

        return (float) $positiveValues->min();
    }

    protected function normalizeCostIncomeForCalculation(float $value, ?float $minPositive): float
    {
        if ($minPositive === null || ! is_finite($minPositive) || $minPositive <= 0) {
            return 0.0;
        }

        if ($value < 0) {
            // \Log::warning('WASPAS: nilai penghasilan negatif ditemukan dan diabaikan pada normalisasi COST.', [
            //     'value' => $value,
            // ]);

            return 0.0;
        }

        $effectiveValue = $value;
        if ($value === 0.0) {
            $effectiveValue = $minPositive;
        }

        return (float) ($minPositive / $effectiveValue);
    }

    protected function normalizeJalurName(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/^jalur\s+/i', '', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }
}
