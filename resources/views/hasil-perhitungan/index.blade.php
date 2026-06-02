@extends('layouts.app')

@section('title', 'Hasil Perhitungan')

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
                        <a href="{{ route('hasil-perhitungan.index') }}">Hasil Perhitungan</a>
                    </li>
                </ul>
            </div>

            <div class="mt-3">
                @include('dashboard.message')
            </div>

            {{-- Card Pilih Periode --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Pilih Periode</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('hasil-perhitungan.index') }}" method="GET" class="mb-4">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
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

            {{-- Card Hasil Perhitungan --}}
            @if (request()->filled('periode_id') && $periodeAktif && $hasilPerhitungans->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">
                                        Hasil Perhitungan SMART Periode {{ $periodeAktif->tahun }}
                                    </h4>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Ranking</th>
                                                <th>Alternatif</th>

                                                @foreach ($kriterias as $kriteria)
                                                    @php
                                                        $bobot = (float) $kriteria->bobot;
                                                        $bobotPersen = $bobot <= 1 ? $bobot * 100 : $bobot;
                                                    @endphp

                                                    <th class="text-center">
                                                        {{ $kriteria->kode_kriteria }}
                                                        <br>
                                                        <small>
                                                            Bobot:
                                                            {{ number_format($bobotPersen, 2) }}%
                                                        </small>
                                                    </th>
                                                @endforeach

                                                <th class="text-center">Nilai Akhir</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th class="text-center">Ranking</th>
                                                <th>Alternatif</th>

                                                @foreach ($kriterias as $kriteria)
                                                    <th class="text-center">
                                                        {{ $kriteria->kode_kriteria }}
                                                    </th>
                                                @endforeach

                                                <th class="text-center">Nilai Akhir</th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                            @foreach ($hasilPerhitungans as $hasil)
                                                @php
                                                    $nilaiUtility = $hasil->nilai_utility ?? [];

                                                    $nilaiAkhir = (float) $hasil->nilai_akhir;
                                                    $nilaiAkhirPersen = $nilaiAkhir <= 1 ? $nilaiAkhir * 100 : $nilaiAkhir;
                                                @endphp

                                                <tr>
                                                    <td class="text-center">
                                                        <strong>{{ $hasil->ranking }}</strong>
                                                    </td>

                                                    <td>
                                                        {{ $hasil->alternatif->nama_alternatif ?? '-' }}
                                                    </td>

                                                    @foreach ($kriterias as $kriteria)
                                                        @php
                                                            $kodeKriteria = $kriteria->kode_kriteria;
                                                            $utility = $nilaiUtility[$kodeKriteria] ?? 0;
                                                        @endphp

                                                        <td class="text-center">
                                                            Utility:
                                                            {{ number_format((float) $utility, 2) }}
                                                        </td>
                                                    @endforeach

                                                    <td class="text-center">
                                                        <strong>
                                                            {{ number_format($nilaiAkhirPersen, 2) }}%
                                                        </strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- <div class="alert alert-success mt-3">
                                    Alternatif terbaik adalah
                                    <strong>
                                        {{ $hasilPerhitungans->first()->alternatif->nama_alternatif ?? '-' }}
                                    </strong>
                                    dengan nilai akhir
                                    <strong>
                                        @php
                                            $nilaiTerbaik = (float) $hasilPerhitungans->first()->nilai_akhir;
                                            $nilaiTerbaikPersen = $nilaiTerbaik <= 1 ? $nilaiTerbaik * 100 : $nilaiTerbaik;
                                        @endphp

                                        {{ number_format($nilaiTerbaikPersen, 2) }}%
                                    </strong>.
                                </div> --}}
                            </div>

                        </div>
                    </div>
                </div>
            @elseif (request()->filled('periode_id') && $periodeAktif)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center text-muted py-4">
                                    Data hasil perhitungan pada periode
                                    <strong>{{ $periodeAktif->tahun }}</strong>
                                    tidak ditemukan.
                                    <br>
                                    Silakan lakukan proses perhitungan SMART terlebih dahulu.
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