<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Periode;
use App\Models\Nilai;
use App\Models\SubKriteria;
use App\Models\HasilPerhitungan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $alternatifPerPeriode = Nilai::select(
                'periode_id',
                DB::raw('COUNT(DISTINCT alternatif_id) as total_alternatif')
            )
            ->with('periode')
            ->groupBy('periode_id')
            ->orderBy('periode_id', 'desc')
            ->get();

        $data = [
            'total_kriteria'          => Kriteria::count(),
            'total_sub_kriteria'      => SubKriteria::count(),
            'total_alternatif'        => Alternatif::count(),
            'total_periode'           => Periode::count(),
            'total_nilai'             => Nilai::count(),
            'alternatif_per_periode'  => $alternatifPerPeriode,
        ];

        return view('dashboard.index', $data);
    }
}