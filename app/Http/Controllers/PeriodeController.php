<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();
        return view('periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun'        => 'required|digits:4|integer|min:2000|max:2099',
        ]);

        Periode::create($request->all());

        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit(Periode $periode)
    {
        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun'        => 'required|digits:4|integer|min:2000|max:2099',
        ]);


        $periode->update($request->all());

        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil diupdate.');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();
        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil dihapus.');
    }
}