@extends('layouts.app')
@section('title', 'Create Sub Kriteria')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs mb-3 p-0 m-0 border-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('kriteria-sub.index') }}">Sub Kriteria</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a>Create Sub Kriteria</a></li>
                </ul>
            </div>

            <div class="col-12">
                @include('dashboard.message')
            </div>

            <form action="{{ route('kriteria-sub.store') }}" method="POST" novalidate>
                @csrf

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Create Sub Kriteria</div>
                            </div>

                            <div class="card-body px-4 px-md-5 py-4">
                                <div class="row">

                                    {{-- KRITERIA --}}
                                    <div class="form-group col-md-12">
                                        <label for="kriteria_id">Nama Kriteria</label>
                                        <select name="kriteria_id" id="kriteria_id"
                                            class="form-control @error('kriteria_id') is-invalid @enderror">
                                            <option value="">-- Pilih Kriteria --</option>

                                            @foreach ($kriterias as $kriteria)
                                                <option value="{{ $kriteria->id }}"
                                                    {{ old('kriteria_id') == $kriteria->id ? 'selected' : '' }}>
                                                    {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('kriteria_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NAMA SUB KRITERIA --}}
                                    <div class="form-group col-md-12">
                                        <label for="nama_sub_kriteria">Nama Sub Kriteria</label>
                                        <input type="text"
                                            class="form-control @error('nama_sub_kriteria') is-invalid @enderror"
                                            name="nama_sub_kriteria"
                                            id="nama_sub_kriteria"
                                            value="{{ old('nama_sub_kriteria') }}"
                                            placeholder="Nama Sub Kriteria" />

                                        @error('nama_sub_kriteria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NILAI --}}
                                    <div class="form-group col-md-12">
                                        <label for="nilai">Nilai</label>
                                        <input type="number"
                                            class="form-control @error('nilai') is-invalid @enderror"
                                            name="nilai"
                                            id="nilai"
                                            value="{{ old('nilai') }}"
                                            placeholder="Nilai"
                                            min="0"
                                            max="100"
                                            step="0.01" />

                                        @error('nilai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('kriteria-sub.index') }}" class="btn btn-black">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection