<?php

namespace Tests\Unit;

use App\Models\Pendaftar;
use PHPUnit\Framework\TestCase;

class PendaftarDerivedAttributesTest extends TestCase
{
    public function test_sync_derived_attributes_averages_only_provided_semester_scores(): void
    {
        $pendaftar = new Pendaftar([
            'smt1' => 80,
            'smt2' => 90,
            'us' => 85,
            'penghasilan_ayah' => 1000000,
            'penghasilan_ibu' => 500000,
        ]);

        $pendaftar->syncDerivedAttributes();

        $this->assertSame(85.0, $pendaftar->akhir);
        $this->assertSame(85.0, $pendaftar->us);
        $this->assertSame(1500000.0, $pendaftar->penghasilan_orangtua);
    }
}
