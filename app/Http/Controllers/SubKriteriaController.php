<?php

namespace App\Http\Controllers;

use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subKriterias = SubKriteria::with('kriteria')
            ->orderBy('kriteria_id')
            ->orderBy('id')
            ->get();

        return view('sub-kriteria.index', compact('subKriterias'));
    }

    public function create()
    {
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();

        return view('sub-kriteria.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        SubKriteria::create($validated);

        return redirect()
            ->route('kriteria-sub.index')
            ->with('success', 'Sub kriteria berhasil ditambahkan.');
    }

    public function edit(SubKriteria $subKriteria)
    {
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        return view('sub-kriteria.edit', compact('subKriteria', 'kriterias'));
    }

    public function update(Request $request, SubKriteria $subKriteria)
    {
        $request->validate([
            'kriteria_id'       => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai'             => 'required|numeric|min:0|max:100',
        ]);

        $subKriteria->update($request->only([
            'kriteria_id',
            'nama_sub_kriteria',
            'nilai',
        ]));

        return redirect()->route('kriteria-sub.index')
                         ->with('success', 'Sub Kriteria berhasil diupdate.');
    }

    public function destroy(SubKriteria $subKriteria)
    {
        $subKriteria->delete();

        return redirect()->route('kriteria-sub.index')
                         ->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}