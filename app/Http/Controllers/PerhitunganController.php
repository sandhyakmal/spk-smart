<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();

        $periodeAktif = null;
        $alternatifs = collect();

        $hasilSmart = collect();
        $matrix = [];
        $utilities = [];
        $normalisasiBobot = [];
        $minMaxKriteria = [];

        if ($request->filled('periode_id')) {
            $periodeAktif = Periode::find($request->periode_id);

            if ($periodeAktif) {
                $alternatifs = Alternatif::with([
                    'nilais' => function ($query) use ($periodeAktif) {
                        $query->where('periode_id', $periodeAktif->id);
                    },
                    'nilais.kriteria',
                    'nilais.subKriteria',
                ])
                    ->whereHas('nilais', function ($query) use ($periodeAktif) {
                        $query->where('periode_id', $periodeAktif->id);
                    })
                    ->orderBy('id')
                    ->get();
            }
        }

        if (
            $request->filled('periode_id') &&
            $request->filled('hitung') &&
            $periodeAktif &&
            $alternatifs->isNotEmpty()
        ) {
            $sudahAdaHasil = HasilPerhitungan::where('periode_id', $periodeAktif->id)->exists();

            if ($sudahAdaHasil) {
                return redirect()
                    ->route('perhitungan.index', [
                        'periode_id' => $periodeAktif->id,
                    ])
                    ->with('error', 'Hasil perhitungan untuk periode ' . $periodeAktif->tahun . ' sudah ada.');
            }

            foreach ($kriterias as $kriteria) {
                $bobot = (float) $kriteria->bobot;

                if ($bobot > 1) {
                    $bobot = $bobot / 100;
                }

                $normalisasiBobot[$kriteria->id] = $bobot;
            }

            foreach ($kriterias as $kriteria) {
                $nilaiSubKriteria = SubKriteria::where('kriteria_id', $kriteria->id)
                    ->pluck('nilai')
                    ->map(function ($nilai) {
                        return (float) $nilai;
                    });

                $minMaxKriteria[$kriteria->id] = [
                    'min' => $nilaiSubKriteria->isNotEmpty() ? $nilaiSubKriteria->min() : 0,
                    'max' => $nilaiSubKriteria->isNotEmpty() ? $nilaiSubKriteria->max() : 0,
                ];
            }

            foreach ($alternatifs as $alternatif) {
                foreach ($kriterias as $kriteria) {
                    $nilai = $alternatif->nilais
                        ->firstWhere('kriteria_id', $kriteria->id);

                    $matrix[$alternatif->id][$kriteria->id] = $nilai && $nilai->subKriteria
                        ? (float) $nilai->subKriteria->nilai
                        : 0;
                }
            }

            foreach ($kriterias as $kriteria) {
                $min = $minMaxKriteria[$kriteria->id]['min'] ?? 0;
                $max = $minMaxKriteria[$kriteria->id]['max'] ?? 0;

                foreach ($alternatifs as $alternatif) {
                    $nilai = $matrix[$alternatif->id][$kriteria->id] ?? 0;

                    if ($max == $min) {
                        $utility = 0;
                    } else {
                        $jenis = strtolower($kriteria->jenis ?? 'benefit');

                        if ($jenis === 'cost') {
                            $utility = (($max - $nilai) / ($max - $min)) * 100;
                        } else {
                            $utility = (($nilai - $min) / ($max - $min)) * 100;
                        }
                    }

                    $utilities[$alternatif->id][$kriteria->id] = round($utility, 2);
                }
            }

            $ranking = [];

            foreach ($alternatifs as $alternatif) {
                $nilaiAkhir = 0;

                foreach ($kriterias as $kriteria) {
                    $nilaiAkhir +=
                        ($utilities[$alternatif->id][$kriteria->id] ?? 0)
                        *
                        ($normalisasiBobot[$kriteria->id] ?? 0);
                }

                $ranking[] = [
                    'alternatif'   => $alternatif,
                    'nilai_akhir' => round($nilaiAkhir, 4),
                ];
            }

            $hasilSmart = collect($ranking)
                ->sortByDesc('nilai_akhir')
                ->values()
                ->map(function ($item, $index) {
                    $item['ranking'] = $index + 1;
                    return $item;
                });

            DB::transaction(function () use ($periodeAktif, $hasilSmart, $kriterias, $utilities) {
                foreach ($hasilSmart as $hasil) {
                    $alternatif = $hasil['alternatif'];

                    $nilaiUtility = [];

                    foreach ($kriterias as $kriteria) {
                        $nilaiUtility[$kriteria->kode_kriteria] = round(
                            $utilities[$alternatif->id][$kriteria->id] ?? 0,
                            2
                        );
                    }

                    HasilPerhitungan::create([
                        'periode_id'    => $periodeAktif->id,
                        'alternatif_id' => $alternatif->id,
                        'nilai_utility' => $nilaiUtility,
                        'nilai_akhir'   => round($hasil['nilai_akhir'], 4),
                        'ranking'       => $hasil['ranking'],
                    ]);
                }
            });

            session()->flash('success', 'Hasil perhitungan SMART berhasil disimpan.');
        }

        return view('perhitungan.index', compact(
            'periodes',
            'kriterias',
            'periodeAktif',
            'alternatifs',
            'hasilSmart',
            'matrix',
            'utilities',
            'normalisasiBobot',
            'minMaxKriteria'
        ));
    }
}