<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias   = Kriteria::orderBy('kode_kriteria')->get();
        $total_bobot = $kriterias->sum('bobot');
        return view('kriteria.index', compact('kriterias', 'total_bobot'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required|string|max:255',
            'tipe'          => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:100',
        ]);

        Kriteria::create([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'tipe'          => $request->tipe,
            'bobot'         => $request->bobot,
            'bobot_desimal' => $request->bobot / 100,
        ]);

        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|unique:kriterias,kode_kriteria,' . $kriteria->id,
            'nama_kriteria' => 'required|string|max:255',
            'tipe'          => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:100',
        ]);

        $kriteria->update([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'tipe'          => $request->tipe,
            'bobot'         => $request->bobot,
            'bobot_desimal' => $request->bobot / 100,
        ]);

        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil diupdate.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil dihapus.');
    }
}