@extends('layouts.app')
@section('title', 'Edit Periode')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs mb-3 p-0 m-0 border-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('periode.index') }}">Periode</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a>Edit Periode</a></li>
                </ul>
            </div>

            <div class="col-12">
                @include('dashboard.message') {{-- ini akan nampilin session success --}}
            </div>

            <form action="{{ route('periode.update', $periode->id) }}" method="post" enctype="multipart/form-data"
                novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Edit Periode</div>
                            </div>

                            <div class="card-body px-4 px-md-5 py-4">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="title">Nama Periode</label>
                                        <input type="text" class="form-control @error('nama_periode') is-invalid @enderror"
                                            name="nama_periode" id="title" value="{{ old('nama_periode', $periode->nama_periode) }}"
                                            placeholder="Nama Periode" />
                                        @error('nama_periode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="tahun">Tahun</label>
                                        <input type="number" class="form-control @error('tahun') is-invalid 
                                        @enderror" 
                                            name="tahun" id="tahun" value="{{ old('tahun', $periode->tahun) }}" placeholder="Tahun" min="1900" max="{{ date('Y') + 10 }}" />
                                        @error('tahun')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('periode.index') }}" class="btn btn-black">
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