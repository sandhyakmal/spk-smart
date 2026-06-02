@extends('layouts.app')
@section('title', 'Edit Alternatif')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs mb-3 p-0 m-0 border-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('alternatif.index') }}">Alternatif</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a>Edit Alternatif</a></li>
                </ul>
            </div>

            <div class="col-12">
                @include('dashboard.message')
            </div>

            <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Edit Alternatif</div>
                            </div>

                            <div class="card-body px-4 px-md-5 py-4">
                                <div class="row">

                                    {{-- PERIODE --}}
                                    <div class="form-group col-md-12">
                                        <label for="periode_id">Periode</label>
                                        <select name="periode_id" id="periode_id"
                                            class="form-control @error('periode_id') is-invalid @enderror">
                                            <option value="">-- Pilih Periode --</option>

                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id }}"
                                                    {{ old('periode_id', $periodeAktif?->id) == $periode->id ? 'selected' : '' }}>
                                                    {{ $periode->nama_periode }} - {{ $periode->tahun }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('periode_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NAMA ALTERNATIF --}}
                                    <div class="form-group col-md-12">
                                        <label for="nama_alternatif">Nama Alternatif</label>
                                        <input type="text"
                                            class="form-control @error('nama_alternatif') is-invalid @enderror"
                                            name="nama_alternatif"
                                            id="nama_alternatif"
                                            value="{{ old('nama_alternatif', $alternatif->nama_alternatif) }}"
                                            placeholder="Nama Alternatif" />

                                        @error('nama_alternatif')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NILAI PER KRITERIA --}}
                                    <div class="col-md-12 mt-3">
                                        <h5>Nilai Alternatif</h5>
                                    </div>

                                    @foreach ($kriterias as $kriteria)
                                        @php
                                            $nilaiAlternatif = $alternatif->nilais
                                                ->firstWhere('kriteria_id', $kriteria->id);

                                            $selectedSubKriteriaId = old(
                                                'sub_kriteria_id.' . $kriteria->id,
                                                $nilaiAlternatif?->sub_kriteria_id
                                            );
                                        @endphp

                                        <div class="form-group col-md-12">
                                            <label for="sub_kriteria_id_{{ $kriteria->id }}">
                                                {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}
                                            </label>

                                            <select
                                                name="sub_kriteria_id[{{ $kriteria->id }}]"
                                                id="sub_kriteria_id_{{ $kriteria->id }}"
                                                class="form-control @error('sub_kriteria_id.' . $kriteria->id) is-invalid @enderror">
                                                <option value="">-- Pilih Sub Kriteria --</option>

                                                @foreach ($kriteria->subKriterias as $subKriteria)
                                                    <option value="{{ $subKriteria->id }}"
                                                        {{ $selectedSubKriteriaId == $subKriteria->id ? 'selected' : '' }}>
                                                        {{ $subKriteria->nama_sub_kriteria }} - Nilai: {{ number_format($subKriteria->nilai, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('sub_kriteria_id.' . $kriteria->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('alternatif.index', ['periode_id' => $periodeAktif?->id]) }}"
                                class="btn btn-black">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection