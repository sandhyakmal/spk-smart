@extends('layouts.app')

@section('title', 'Alternatif')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs mb-3 p-0 m-0 border-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('alternatif.index') }}">Alternatif</a>
                    </li>
                </ul>
            </div>

            <div class="mt-3">
                @include('dashboard.message')
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Pilih Periode</h4>
                            </div>
                        </div>

                        <div class="card-body">

                            {{-- Form Pilih Periode --}}
                            <form action="{{ route('alternatif.index') }}" method="GET" class="mb-4">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        {{-- <label for="periode_id" class="form-label">Pilih Periode</label> --}}
                                        <select name="periode_id" id="periode_id" class="form-control" required>
                                            <option value="">-- Pilih Periode --</option>

                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id }}"
                                                    {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                                                    {{ $periode->tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if (request()->filled('periode_id') && $periodeAktif)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Alternatif</h4>

                            </div>
                        </div>

                        <div class="card-body">

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>

                                                @foreach ($kriterias as $kriteria)
                                                    <th class="text-center">
                                                        {{ $kriteria->kode_kriteria }}
                                                    </th>
                                                @endforeach

                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>Alternatif</th>

                                                @foreach ($kriterias as $kriteria)
                                                    <th class="text-center">
                                                        {{ $kriteria->kode_kriteria }}
                                                    </th>
                                                @endforeach

                                                <th>Action</th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                            @forelse ($alternatifs as $alternatif)
                                                <tr>
                                                    <td>{{ $alternatif->nama_alternatif }}</td>

                                                    @foreach ($kriterias as $kriteria)
                                                        @php
                                                            $nilai = $alternatif->nilais
                                                                ->firstWhere('kriteria_id', $kriteria->id);
                                                        @endphp

                                                        <td class="text-center">
                                                            @if ($nilai && $nilai->subKriteria)
                                                                {{ $nilai->subKriteria->nama_sub_kriteria }}
                                                                <br>
                                                                <small class="text-muted">
                                                                    Nilai:
                                                                    {{ number_format($nilai->subKriteria->nilai, 2) }}
                                                                </small>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    @endforeach

                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('alternatif.edit', $alternatif->id) }}">
                                                                <button type="button"
                                                                    class="btn btn-link btn-primary btn-lg p-0 pe-4"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </a>

                                                            <form action="{{ route('alternatif.destroy', $alternatif->id) }}"
                                                                method="POST"
                                                                style="display:inline;"
                                                                class="delete-form">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="button"
                                                                    class="btn btn-link btn-danger p-0 btn-delete"
                                                                    data-name="{{ $alternatif->nama_alternatif }}">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="{{ $kriterias->count() + 2 }}"
                                                        class="text-center text-muted py-4">
                                                        No data found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>


                        </div>

                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center text-muted py-4">
                                Silakan pilih periode terlebih dahulu, lalu klik Search.
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            @endif   
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();

        let button = $(this);
        let form = button.closest('form');
        let kriteriaName = button.data('name');

        swal({
            title: 'Are you sure?',
            text: 'Data kriteria ' + kriteriaName + ' akan dihapus!',
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Yes, delete it!',
                    className: 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    text: 'Cancel',
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                form.submit();
            } else {
                swal.close();
            }
        });
    });
</script>
@endpush