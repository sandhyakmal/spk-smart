<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo text-decoration-none w-100 text-center">
                <span class="fw-bold text-white" style="font-size: 22px; letter-spacing: 1px;">
                    SPK SMART
                </span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar" style="height: 40px;">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <li class="nav-item {{ isActive(['dashboard']) }}">
                    <a href="{{ route('dashboard') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>   

                <li class="nav-item {{ isActive(['periode.*']) }}">
                    <a href="{{ route('periode.index') }}" class="collapsed">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Periode</p>
                    </a>
                </li>   

                {{-- <li class="nav-item {{ isActive(['kriteria.*']) }}">
                    <a href="{{ route('kriteria.index') }}" class="collapsed">
                        <i class="fas fa-archive"></i>
                        <p>Kriteria</p>
                    </a>
                </li>   --}}
                
                <li class="nav-item {{ isActive(['kriteria.*', 'kriteria-sub.*']) }}">
                    <a data-bs-toggle="collapse" href="#kriteria">
                        <i class="fas fa-layer-group"></i>
                        <p>Kriteria</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse {{ isOpen(['kriteria.*', 'kriteria-sub.*']) }}" id="kriteria">
                        <ul class="nav nav-collapse">
                            <li class="{{ isActive(['kriteria.*']) }}">
                                <a href="{{ route('kriteria.index') }}">
                                    <span class="sub-item">Kriteria</span>
                                </a>
                            </li>

                            <li class="{{ isActive(['kriteria-sub.*']) }}">
                                <a href="{{ route('kriteria-sub.index') }}">
                                    <span class="sub-item">Sub Kriteria</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ isActive(['alternatif.*']) }}">
                    <a data-bs-toggle="collapse" href="#alternatif">
                        <i class="fas fa-stream"></i>
                        <p>Alternatif</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse {{ isOpen(['alternatif.*']) }}" id="alternatif">
                        <ul class="nav nav-collapse">
                            <li class="{{ isActive(['alternatif.*']) }}">
                                <a href="{{ route('alternatif.index') }}">
                                    <span class="sub-item">Data Alternatif</span>
                                </a>
                            </li>

                            <li class="{{ isActive(['alternatif.create']) }}">
                                <a href="{{ route('alternatif.create') }}">
                                    <span class="sub-item">Tambah Alternatif</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>   

                <li class="nav-item {{ isActive(['perhitungan.*']) }}">
                    <a href="{{ route('perhitungan.index') }}" class="collapsed">
                        <i class="fas fa-ruler"></i>
                        <p>Perhitungan</p>
                    </a>
                </li> 

                <li class="nav-item {{ isActive(['hasil-perhitungan.*']) }}">
                    <a href="{{ route('hasil-perhitungan.index') }}" class="collapsed">
                        <i class="fas fa-save"></i>
                        <p>Hasil Perhitungan</p>
                    </a>
                </li>   

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
