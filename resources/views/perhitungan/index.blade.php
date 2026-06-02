@extends('layouts.app')

@section('title', 'Perhitungan SMART')

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
                        <a href="{{ route('perhitungan.index') }}">Perhitungan SMART</a>
                    </li>
                </ul>
            </div>

            <div class="mt-3">
                @include('dashboard.message')
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Pilih Periode</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('perhitungan.index') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="periode_id" class="form-label">Pilih Periode</label>
                                <select name="periode_id" id="periode_id" class="form-control" required>
                                    <option value="">--Pilih Periode--</option>

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

            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Data Alternatif</h4>

                        @if (request()->filled('periode_id') && $periodeAktif && $alternatifs->isNotEmpty())
                            <a href="{{ route('perhitungan.index', [
                                'periode_id' => request('periode_id'),
                                'hitung' => 1,
                            ]) }}"
                                class="btn btn-success btn-round ms-auto">
                                <i class="fa fa-calculator"></i>
                                Hitung SMART
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if (request()->filled('periode_id') && $periodeAktif && $alternatifs->isNotEmpty())

                        <div class="table-responsive">
                            <table id="table-alternatif" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>

                                        @foreach ($kriterias as $kriteria)
                                            <th class="text-center">
                                                {{ $kriteria->kode_kriteria }}
                                            </th>
                                        @endforeach
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
                                    </tr>
                                </tfoot>

                                <tbody>
                                    @foreach ($alternatifs as $alternatif)
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @elseif (request()->filled('periode_id') && $periodeAktif)

                        <div class="text-center text-muted py-5">
                            Data alternatif pada periode
                            <strong>{{ $periodeAktif->tahun }}</strong>
                            tidak ditemukan.
                        </div>

                    @else

                        <div class="text-center text-muted py-5">
                            Silakan pilih periode terlebih dahulu, lalu klik Search.
                        </div>

                    @endif
                </div>
            </div>

            @if (request()->filled('hitung') && $hasilSmart->isNotEmpty())
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">
                            Hasil Perhitungan SMART Periode {{ $periodeAktif->tahun }}
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-smart" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ranking</th>
                                        <th>Alternatif</th>

                                        @foreach ($kriterias as $kriteria)
                                            <th class="text-center">
                                                {{ $kriteria->kode_kriteria }}
                                                <br>
                                                <small>
                                                    Bobot:
                                                    {{ number_format(($normalisasiBobot[$kriteria->id] ?? 0) , 2) }}%
                                                </small>
                                            </th>
                                        @endforeach

                                        <th class="text-center">Nilai Akhir</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($hasilSmart as $hasil)
                                        @php
                                            $alternatif = $hasil['alternatif'];
                                        @endphp

                                        <tr>
                                            <td class="text-center">
                                                <strong>{{ $hasil['ranking'] }}</strong>
                                            </td>

                                            <td>{{ $alternatif->nama_alternatif }}</td>

                                            @foreach ($kriterias as $kriteria)
                                                <td class="text-center">
                                                    {{-- <small>
                                                        Nilai:
                                                        {{ number_format($matrix[$alternatif->id][$kriteria->id] ?? 0, 2) }}
                                                    </small>
                                                    <br> --}}
                                                    <small>
                                                        Utility:
                                                        {{ number_format($utilities[$alternatif->id][$kriteria->id] ?? 0, 2) }}
                                                    </small>
                                                </td>
                                            @endforeach

                                            <td class="text-center">
                                                <strong>
                                                    {{ number_format($hasil['nilai_akhir'], 2) }} %
                                                </strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="alert alert-success mt-3">
                            Alternatif terbaik adalah
                            <strong>{{ $hasilSmart->first()['alternatif']->nama_alternatif }}</strong>
                            dengan nilai akhir
                            <strong>{{ number_format($hasilSmart->first()['nilai_akhir'], 4) }}</strong>.
                        </div> --}}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection