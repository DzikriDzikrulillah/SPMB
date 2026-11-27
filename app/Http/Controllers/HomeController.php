<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hasSelectionStatus = Pendaftar::hasSelectionStatusColumn();
        $data_pendaftar = Pendaftar::orderBy('created_at', 'DESC')->limit(5, 0)->get();

        $data_lelaki = Pendaftar::where('jenis_kelamin', 'Laki Laki')->count();
        $data_perempuan = Pendaftar::where('jenis_kelamin', 'Perempuan')->count();

        // Get unique gelombang from database
        $gelombangList = Pendaftar::select('gelombang')
            ->whereNotNull('gelombang')
            ->where('gelombang', '!=', '')
            ->distinct()
            ->orderBy('gelombang')
            ->pluck('gelombang')
            ->toArray();

        // Count per gelombang dynamically
        $gelombangCounts = [];
        foreach ($gelombangList as $gelombang) {
            $gelombangCounts[$gelombang] = Pendaftar::where('gelombang', $gelombang)->count();
        }

        // Statistics based on selection status
        $total_pendaftar = Pendaftar::count();
        $sudah_acc = Pendaftar::where('acc', 1)->count();
        $belum_acc = Pendaftar::where('acc', 0)->count();

        if ($hasSelectionStatus) {
            $diterima = Pendaftar::where('status_seleksi', 'diterima')->count();
            $ditolak = Pendaftar::where('status_seleksi', 'ditolak')->count();
            $pending = Pendaftar::where('status_seleksi', 'pending')->orWhereNull('status_seleksi')->count();
        } else {
            // Fallback for old system without status_seleksi
            $diterima = 0;
            $ditolak = 0;
            $pending = Pendaftar::where('acc', 1)->count();
        }

        $page = "dashboard";

        // Chart showing selection status distribution
        $chart = LarapexChart::pieChart()
            ->addData([$diterima, $ditolak, $pending])
            ->setLabels(['Diterima', 'Ditolak', 'Pending']);

        return view('Admin/index', compact(
            'page',
            'chart',
            'data_pendaftar',
            'data_lelaki',
            'data_perempuan',
            'total_pendaftar',
            'sudah_acc',
            'belum_acc',
            'diterima',
            'ditolak',
            'pending',
            'gelombangCounts',
            'gelombangList'
        ));
    }
}
