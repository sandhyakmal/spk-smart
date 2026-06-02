@extends('layouts.app')

@section('title', 'Kriteria')

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
                                <h4 class="card-title">Data Kriteria</h4>
                                 <button class="btn btn-primary btn-round btn-round ms-auto" data-bs-toggle="tooltip" title="" data-original-title="Add Kriteria"
                                    onclick='window.location.href="{{ route('kriteria.create') }}"'>
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </button>
                            </div>
                        </div>



                        <div class="card-body">


                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Kriteria</th>
                                            <th>Nama Kriteria</th>
                                            <th>Tipe</th>
                                            <th>Bobot</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Kriteria</th>
                                            <th>Nama Kriteria</th>
                                            <th>Tipe</th>
                                            <th>Bobot</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($kriterias as $kriteria)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $kriteria->kode_kriteria }}</td>
                                                <td>{{ $kriteria->nama_kriteria }}</td>
                                                <td>{{ $kriteria->tipe }}</td>
                                                <td>{{ $kriteria->bobot }}</td>

                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('kriteria.edit', $kriteria->id) }}">
                                                            <button type="button"
                                                                class="btn btn-link btn-primary btn-lg p-0 pe-4">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </a>

                                                        <form action="{{ route('kriteria.destroy', $kriteria->id) }}"
                                                            method="POST"
                                                            style="display:inline;"
                                                            class="delete-form">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="button"
                                                                class="btn btn-link btn-danger p-0 btn-delete"
                                                                data-name="{{ $kriteria->nama_kriteria }}">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
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