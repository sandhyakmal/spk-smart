<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Periode;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternatifController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();

        $periodeAktif = null;
        $alternatifs = collect();

        $kriterias = Kriteria::orderBy('kode_kriteria')->get();

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

        return view('alternatif.index', compact(
            'periodes',
            'periodeAktif',
            'kriterias',
            'alternatifs'
        ));
    }

    public function create()
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();

        $kriterias = Kriteria::with(['subKriterias' => function ($query) {
            $query->orderBy('id');
        }])
            ->orderBy('kode_kriteria')
            ->get();

        return view('alternatif.create', compact(
            'periodes',
            'kriterias'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'nama_alternatif' => 'required|string|max:255',
            'sub_kriteria_id' => 'required|array',
            'sub_kriteria_id.*' => 'nullable|exists:sub_kriterias,id',
        ]);

        DB::transaction(function () use ($validated) {
            $alternatif = Alternatif::create([
                'nama_alternatif' => $validated['nama_alternatif'],
            ]);

            foreach ($validated['sub_kriteria_id'] as $kriteriaId => $subKriteriaId) {
                if (!$subKriteriaId) {
                    continue;
                }

                $subKriteria = SubKriteria::where('id', $subKriteriaId)
                    ->where('kriteria_id', $kriteriaId)
                    ->firstOrFail();

                Nilai::updateOrCreate(
                    [
                        'periode_id' => $validated['periode_id'],
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'sub_kriteria_id' => $subKriteria->id,
                        'nilai' => $subKriteria->nilai,
                    ]
                );
            }
        });

        return redirect()
            ->route('alternatif.index', ['periode_id' => $validated['periode_id']])
            ->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function edit(Request $request, Alternatif $alternatif)
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();

        $periodeAktif = Periode::where('id', $request->periode_id)->first();

        if (!$periodeAktif) {
            $periodeAktif = Periode::orderBy('tahun', 'desc')->first();
        }

        $kriterias = Kriteria::with(['subKriterias' => function ($query) {
            $query->orderBy('id');
        }])
            ->orderBy('kode_kriteria')
            ->get();

        $alternatif->load([
            'nilais' => function ($query) use ($periodeAktif) {
                if ($periodeAktif) {
                    $query->where('periode_id', $periodeAktif->id);
                }
            },
            'nilais.subKriteria',
            'nilais.kriteria',
        ]);

        return view('alternatif.edit', compact(
            'alternatif',
            'periodes',
            'periodeAktif',
            'kriterias'
        ));
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'nama_alternatif' => 'required|string|max:255',
            'sub_kriteria_id' => 'required|array',
            'sub_kriteria_id.*' => 'nullable|exists:sub_kriterias,id',
        ]);

        DB::transaction(function () use ($validated, $alternatif) {
            $alternatif->update([
                'nama_alternatif' => $validated['nama_alternatif'],
            ]);

            foreach ($validated['sub_kriteria_id'] as $kriteriaId => $subKriteriaId) {
                if (!$subKriteriaId) {
                    continue;
                }

                $subKriteria = SubKriteria::where('id', $subKriteriaId)
                    ->where('kriteria_id', $kriteriaId)
                    ->firstOrFail();

                Nilai::updateOrCreate(
                    [
                        'periode_id' => $validated['periode_id'],
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'sub_kriteria_id' => $subKriteria->id,
                        'nilai' => $subKriteria->nilai,
                    ]
                );
            }
        });

        return redirect()
            ->route('alternatif.index', ['periode_id' => $validated['periode_id']])
            ->with('success', 'Alternatif berhasil diperbarui.');
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();

        return redirect()
            ->route('alternatif.index')
            ->with('success', 'Alternatif berhasil dihapus.');
    }
}