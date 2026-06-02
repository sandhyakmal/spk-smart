<?php

namespace App\Http\Controllers;

use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use App\Models\Periode;
use Illuminate\Http\Request;

class HasilPerhitunganController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();

        $periodeAktif = null;
        $hasilPerhitungans = collect();

        if ($request->filled('periode_id')) {
            $periodeAktif = Periode::find($request->periode_id);

            if ($periodeAktif) {
                $hasilPerhitungans = HasilPerhitungan::with([
                    'periode',
                    'alternatif',
                ])
                    ->where('periode_id', $periodeAktif->id)
                    ->orderBy('ranking', 'asc')
                    ->get();
            }
        }

        return view('hasil-perhitungan.index', compact(
            'periodes',
            'kriterias',
            'periodeAktif',
            'hasilPerhitungans'
        ));
    }
}