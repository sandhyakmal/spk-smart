@extends('layouts.app')
@section('title', 'Edit Kriteria')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs mb-3 p-0 m-0 border-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('kriteria.index') }}">Kriteria</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a>Edit Kriteria</a></li>
                </ul>
            </div>

            <div class="col-12">
                @include('dashboard.message')
            </div>

            {{-- SUBMIT NORMAL --}}
            <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Edit Kriteria</div>
                            </div>

                            <div class="card-body px-4 px-md-5 py-4">
                                <div class="row">

                                    {{-- TITLE --}}

                                    <div class="form-group col-md-12">
                                        <label for="kode_kriteria">Kode Kriteria</label>
                                        <input type="text" class="form-control @error('kode_kriteria') is-invalid @enderror"
                                            name="kode_kriteria" id="kode_kriteria" value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}"
                                            placeholder="Kode Kriteria" />
                                        @error('kode_kriteria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="nama_kriteria">Nama Kriteria</label>
                                        <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror"
                                            name="nama_kriteria" id="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}"
                                            placeholder="Nama Kriteria" />
                                        @error('nama_kriteria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="tipe">Tipe</label>
                                        <select class="form-control @error('tipe') is-invalid @enderror" name="tipe" id="tipe">
                                            <option value="">Pilih Tipe</option>
                                            <option value="benefit" {{ old('tipe', $kriteria->tipe) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                            <option value="cost" {{ old('tipe', $kriteria->tipe) == 'cost' ? 'selected' : '' }}>Cost</option>
                                        </select>
                                        @error('tipe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="bobot">Bobot %</label>
                                        <input type="number" class="form-control @error('bobot') is-invalid @enderror"
                                            name="bobot" id="bobot" value="{{ old('bobot', $kriteria->bobot) }}"
                                            placeholder="Bobot" min="0" max="100" />
                                        @error('bobot')
                                             <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('kriteria.index') }}" class="btn btn-black">
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
