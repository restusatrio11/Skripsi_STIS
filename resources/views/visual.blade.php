{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-10">
            <div class="col-xl">
                <canvas id="avgChart" class="visual"></canvas>
                <br>
                <canvas id="countChart" class="visual"></canvas>
            </div>
        </div>
        <div class="row mb-3">

            <div class="col-sm-6 mx-auto">
                <canvas id="myChart" class=""></canvas>
            </div>

        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <div class="row">
            <div class="col-12 text-center mt-4">
                <h2 class="display-4 fw-bold text-primary">Selamat Datang di Sistem Manajemen Kinerja</h2>
                <p class="lead text-muted">BPS Kabupaten Klaten</p>
            </div>
        </div> --}}

        @php
            $selectedYear = request('year', null);
            $selectedMonth = request('month', null);
        @endphp

        <div class="row">
            <div class="col-sm-auto align-self-center">
                <h5>Dashboard</h5>
            </div>
            <div class="col align-self-center border-top border-primary d-none d-sm-block"></div>
            <div class="col-sm-auto align-self-center ml-auto">

                <form method="post" action="{{ url('/simanja/dashboard') }}" class="form-inline">
                    @csrf
                    <div class="row">
                        <div class="form-group col px-1">
                            <select name="month" id="month" class="form-control" aria-label="bulan" required>
                                <option value="" {{ $selectedMonth === null ? 'selected' : '' }}>Bulan
                                </option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col px-0">
                            <select name="year" id="year" class="form-control" aria-label="tahun" required>
                                <option value="" {{ $selectedYear === null ? 'selected' : '' }}>Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $endYear = $currentYear + 5;
                                @endphp
                                @for ($i = $endYear; $i >= $currentYear; $i--)
                                    <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col px-1">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <br>
        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration bg-white" role="alert">
            <div class="inner">
                <div class="app-card-body p-3 p-lg-4">
                    <div class="row gx-5 gy-3">
                        <div class="col-12 col-lg-9">
                            <h3 class="mb-3">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="text-justify" style="text-align: justify">
                                "Simanja" adalah kependekan dari "Sistem Manajemen Kinerja." Ini adalah sistem atau platform
                                yang dirancang untuk membantu BPS Kabupaten Klaten dalam mengelola dan mengoptimalkan
                                kinerja karyawan atau anggota tim. Simanja biasanya berfungsi sebagai alat yang membantu
                                dalam mengukur, mengelola, dan meningkatkan kinerja individu dan tim di dalam organisasi.
                            </p>
                        </div><!--//col-->
                        <div class="col-12 col-lg-3">
                            <img src="/images/visual.png" alt="Dashboard" class="img-fluid">
                        </div><!--//col-->
                    </div><!--//row-->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div><!--//app-card-body-->
            </div><!--//inner-->
        </div>




        <div class="row">

            <!-- Project Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-orange-pro shadow h-100 py-2 bg-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Project</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTasks }}</div>
                                <p class="mb-0"><span class="text-dark me-2">{{ $totalCompletedTasks }}</span> Completed
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300 icon-color-clipboard"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-orange-T shadow h-100 py-2 bg-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Team</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAsalTeam }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-group fa-2x text-gray-300 icon-color-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produktivitas Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-orange-P shadow h-100 py-2 bg-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Produktivitas
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $productivity }}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $productivity }}%" aria-valuenow="{{ $productivity }}"
                                                aria-valuemin="0" aria-valuemax="100" aria-label="progress">
                                            </div>

                                        </div>
                                    </div>
                                    <p class="mb-0"><span class="text-dark me-2">{{ $productivityCompleted }}%</span>
                                        Completed
                                    </p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-pie fa-2x text-gray-300 icon-color-pie"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Confirm Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-orange-MA shadow h-100 py-2 bg-white">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Most Active</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ optional($mostActiveEmployee)->nama }}</div>
                                <p class="mb-0">
                                    <span class="text-dark me-2">
                                        @php
                                            $total_realisasi = optional($mostActiveEmployee)->total_realisasi;
                                            // Cek apakah nilai desimal adalah 0
                                            if ($total_realisasi == intval($total_realisasi)) {
                                                // Jika desimalnya 0, gunakan number_format tanpa desimal
                                                echo number_format($total_realisasi, 0);
                                            } else {
                                                // Jika desimalnya tidak 0, gunakan number_format dengan 2 desimal
                                                echo number_format($total_realisasi, 2);
                                            }
                                        @endphp
                                    </span>
                                    Completed
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300 icon-color-comments"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- <div class="row mt-5">
            <div class="mt-6 col-xl-3 col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-shadow">
                        <div class="card-body bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Projects</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">

                                </div>
                            </div>
                            <div>
                                <h1 class="fw-bold">{{ $totalTasks }}</h1>
                                <p class="mb-0"><span class="text-dark me-2">{{ $totalCompletedTasks }}</span> Completed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 col-xl-3 col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-shadow">
                        <div class="card-body bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Team</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">

                                </div>
                            </div>
                            <div>
                                <h1 class="fw-bold">{{ $totalAsalTeam }}</h1>
                                <p class="mb-0"><span class="text-dark me-2">28</span> Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 col-xl-3 col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-shadow">
                        <div class="card-body bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Produktivitas</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">

                                </div>
                            </div>
                            <div>
                                <h1 class="fw-bold">{{ $productivity }}%</h1>
                                <p class="mb-0"><span class="text-dark me-2">{{ $productivityCompleted }}%</span>
                                    Completed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 col-xl-3 col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-shadow">
                        <div class="card-body bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">MostActive</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">

                                </div>
                            </div>
                            <div>
                                <h2 class="fw-bold">{{ $mostActiveEmployee->nama }}</h2>
                                <p class="mb-0"><span
                                        class="text-dark me-2">{{ $mostActiveEmployee->total_realisasi }}</span>
                                    Completed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="row mt-5"> --}}
        {{-- <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body bg-white">
                    <h4 class="card-title">Rata-Rata Nilai Kinerja Pegawai</h4>
                    <canvas id="avgChart" class="visual"></canvas>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body bg-white">
                    <h4 class="card-title">Jumlah Kegiatan Pegawai</h4>
                    <div id="chartContainer" style="overflow-x: auto;">
                        <canvas id="countChart" class="visual"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}


        <div class="container mt-3">

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs justify-content-center" id="myTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="kegiatan-tab" data-toggle="tab" href="#kegiatan">Jumlah Kegiatan
                        Pegawai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="bobot-tab" data-toggle="tab" href="#bobot">Jumlah Bobot Pekerjaan
                        Pegawai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="kinerja-tab" data-toggle="tab" href="#kinerja">Nilai Kinerja Pegawai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tugas-tab" data-toggle="tab" href="#tugas">Presentase Tugas Selesai Tim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="performa-tab" data-toggle="tab" href="#performa">Performa Tugas</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-2">
                <!-- Tab Kegiatan -->
                <div class="tab-pane fade show active" id="kegiatan">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body bg-white">
                                <div class="card-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                    <h4 class="card-title" style="color: white">Jumlah Kegiatan Pegawai
                                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</h4>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <button id="exportButtonCounttChart" class="btn btn-custom mt-3 ml-auto">
                                            <i class="fas fa-download mr-1"></i> Export Chart
                                        </button>
                                        <a href="{{ route('export_excel_kp', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
                                            id="exportButtonCounttTable" class="btn btn-custom mt-3 ml-auto"
                                            style="display: none;" target="_blank">
                                            <i class="bi bi-box-arrow-right"></i> Export Tabel
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-dark dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih Tampilan
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonn">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="switchToChartCountt()">Grafik</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="switchToTableCountt()">Tabel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div style="position: relative; height:1000px;">
                                    <canvas id="counttChart" class="visual"></canvas>

                                    <div id="tableContainerCountt" style="display:none;">
                                        <table class="table" id="tableCountt">
                                            <thead>
                                                <tr>
                                                    <th>Nama Pegawai</th>
                                                    <th class="text-center">Jumlah Kegiatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datacount as $kegiatan)
                                                    <tr>
                                                        <td>{{ $kegiatan['name'] }}</td>
                                                        <td class="text-center">{{ $kegiatan['kegiatan'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    function switchToChartCountt() {
                        document.getElementById("counttChart").style.display = "block";
                        document.getElementById("exportButtonCounttChart").style.display = "block";
                        document.getElementById("tableContainerCountt").style.display = "none";
                        document.getElementById("exportButtonCounttTable").style.display = "none";
                    }

                    function switchToTableCountt() {
                        document.getElementById("counttChart").style.display = "none";
                        document.getElementById("exportButtonCounttChart").style.display = "none";
                        document.getElementById("tableContainerCountt").style.display = "block";
                        document.getElementById("exportButtonCounttTable").style.display = "block";
                    }
                </script>

                <!-- Tab Bobot -->
                <div class="tab-pane fade" id="bobot">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body bg-white">
                                <div class="card-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                    <h4 class="card-title" style="color: white">Jumlah Bobot Pekerjaan Pegawai
                                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</h4>
                                </div>
                                <br>
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <button id="exportButtonBobotChart" class="btn btn-custom mt-3">
                                            <i class="fas fa-download mr-1"></i> Export Chart
                                        </button>
                                        <a href="{{ route('export_excel_totalbobot', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
                                            id="exportButtonBobotTable" class="btn btn-custom mt-3 ml-auto"
                                            style="display: none;" target="_blank">
                                            <i class="bi bi-box-arrow-right"></i> Export Tabel
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn light btn-dark dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih Tampilan
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="switchToChartBobot()">Grafik</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="switchToTableBobot()">Tabel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div style="position: relative; height:1000px;">
                                    <canvas id="bobotChart" class="visual"></canvas>
                                    <div id="tableContainerBobot" style="display:none;">
                                        <!-- Tambahkan tabel di sini -->
                                        <table class="table" id="tableBobot">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th class="text-center">Total Bobot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($totalBobot as $bobot)
                                                    <tr>
                                                        <td>{{ $bobot['nama'] }}</td>
                                                        <td class="text-center">{{ $bobot['total_bobot'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function switchToChartBobot() {
                        document.getElementById("bobotChart").style.display = "block";
                        document.getElementById("tableContainerBobot").style.display = "none";
                        document.getElementById("exportButtonBobotChart").style.display = "block";
                        document.getElementById("exportButtonBobotTable").style.display = "none";
                    }

                    function switchToTableBobot() {
                        document.getElementById("bobotChart").style.display = "none";
                        document.getElementById("tableContainerBobot").style.display = "block";
                        document.getElementById("exportButtonBobotChart").style.display = "none";
                        document.getElementById("exportButtonBobotTable").style.display = "block";
                    }
                </script>

                <!-- Tab Kinerja -->
                <div class="tab-pane fade" id="kinerja">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body bg-white">
                                <div class="card-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                    <h4 class="card-title" style="color: white">Nilai Kinerja Pegawai
                                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</h4>
                                </div>
                                <br>
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <div class="btn-group" role="group">
                                            <button id="exportButtonChartNA" class="btn btn-custom">
                                                <i class="fas fa-download mr-1"></i> Export Chart
                                            </button>
                                            <a href="{{ route('export_excel_namanilaiakhir', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
                                                id="exportButtonMyTableNA" class="btn btn-custom mt-3 ml-auto"
                                                style="display: none;" target="_blank">
                                                <i class="bi bi-box-arrow-right"></i> Export Tabel
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-dark dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih Tampilan
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="showChartNA()">Grafik</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="showTableNA()">Tabel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div style="position: relative; height:1000px;">
                                    <canvas id="AvgChart" class="visual"></canvas>
                                    <div id="tableContainerNA" style="display: none;">
                                        <!-- Tambahkan tabel di sini -->
                                        <table class="table" id="namanilaiakhir">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th class="text-center">Nilai Akhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataavg as $avg)
                                                    <tr>
                                                        <td>{{ $avg['nama'] }}</td>
                                                        <td class="text-center">{{ $avg['nilai_akhir'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function showChartNA() {
                        document.getElementById("AvgChart").style.display = "block";
                        document.getElementById("tableContainerNA").style.display = "none";
                        document.getElementById("exportButtonChartNA").style.display = "block";
                        document.getElementById("exportButtonMyTableNA").style.display = "none";
                    }

                    function showTableNA() {
                        document.getElementById("AvgChart").style.display = "none";
                        document.getElementById("tableContainerNA").style.display = "block";
                        document.getElementById("exportButtonChartNA").style.display = "none";
                        document.getElementById("exportButtonMyTableNA").style.display = "block";
                    }
                </script>


                <!-- Tab Tugas -->
                {{-- <div class="tab-pane fade" id="tugas">
                    <div class="col-md-12">
                        <div class="card bg-white">
                            <div class="card-body">
                                <div class="card-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                    <h5 class="card-title" style="color: white">Jumlah Tugas Selesai
                                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}
                                    </h5>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <button id="exportButtonMyChart" class="btn btn-primary mt-3 ml-auto">
                                            <i class="fas fa-download mr-1"></i> Export Chart
                                        </button>
                                    </div>
                                </div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="tab-pane fade" id="tugas">
                    <div class="col-md-12">
                        <div class="card bg-white">
                            <div class="card-body">
                                <div class="card-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                    <h5 class="card-title" style="color: white">Presentase Tugas Selesai Tim
                                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}
                                    </h5>
                                </div>
                                <br>
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <button id="exportButtonMyChart" class="btn btn-custom mt-3">
                                            <i class="bi bi-box-arrow-right"></i> Export Chart
                                        </button>
                                        <a href="{{ route('export_excel_ctba', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
                                            id="exportButtonMyTable" class="btn btn-custom mt-3 ml-auto"
                                            style="display: none;" target="_blank">
                                            <i class="bi bi-box-arrow-right"></i> Export Tabel
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn light btn-dark dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih Tampilan
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="switchToChart()">Grafik</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="switchToTable()">Tabel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div id="chartContainer">
                                    <canvas id="myChart"></canvas>
                                </div>

                                <div id="tableContainer" style="display:none;">
                                    <!-- Tambahkan tabel di sini -->
                                    <table class="table" id="tablectba">
                                        <thead>
                                            <tr>
                                                <th>Tim</th>
                                                <th class="text-center">Presentase Tugas Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($completedTasksByAsal as $ctba)
                                                <tr>
                                                    <td>{{ $ctba['asal'] }}</td>
                                                    <td class="text-center">{{ round($ctba['total_completed'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Performa -->
                <div class="tab-pane fade" id="performa">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-white">
                                    <div class="card-body">
                                        <div class="card-header"
                                            style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                            <h5 class="card-title" style="color: white">Performa Tugas
                                                {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</h5>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-auto">
                                                <button id="exportButtonTaskChart" class="btn btn-custom mt-3 ml-auto">
                                                    <i class="bi bi-box-arrow-right"></i> Export Chart
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-md-6">
                                                <canvas id="taskChart"></canvas>
                                            </div>
                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <div class="text-start ms-md-3">
                                                    <p><i class="bi bi-info-circle"></i> Belum Dikerjakan:
                                                        {{ $notStartedPercentage }}%</p>
                                                    <p><i class="bi bi-check-circle"></i> Selesai:
                                                        {{ $completedPercentage }}%</p>
                                                    <p><i class="bi bi-arrow-right-circle"></i> Progress:
                                                        {{ $progressPercentage }}%</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <!-- Bootstrap JS, Popper.js, jQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        {{-- </div> --}}

        {{-- </div> --}}


        <br>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        // Data yang telah diambil dari database
        var data = <?php echo json_encode($completedTasksByAsal); ?>;

        var asalLabels = data.map(function(item) {
            return item.asal;
        });

        var completedTasks = data.map(function(item) {
            return item.total_completed;
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: asalLabels,
                datasets: [{
                    label: 'Jumlah Tugas Selesai',
                    data: completedTasks,
                    backgroundColor: 'rgba(75, 192, 192, 0.8)', // Warna latar belakang
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna border
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0, // Nilai minimum pada sumbu Y
                        max: 20, // Nilai maksimum pada sumbu Y
                        stepSize: 1 // Langkah kelipatan pada sumbu Y
                    }
                },
                responsive: true,
                aspectRatio: 1 // Rasio aspek grafik, misalnya 1 untuk membuatnya menjadi kotak
            }
        });
    </script> --}}
    <script>
        function switchToChart() {
            document.getElementById('chartContainer').style.display = 'block';
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('exportButtonMyChart').style.display = 'inline-block';
            document.getElementById('exportButtonMyTable').style.display = 'none';
        }

        function switchToTable() {
            document.getElementById('chartContainer').style.display = 'none';
            document.getElementById('tableContainer').style.display = 'block';
            document.getElementById('exportButtonMyChart').style.display = 'none';
            document.getElementById('exportButtonMyTable').style.display = 'inline-block';
        }

        // Data yang telah diambil dari database
        var data = <?php echo json_encode($completedTasksByAsal); ?>;

        var asalLabels = data.map(function(item) {
            return item.asal;
        });

        var completedTasks = data.map(function(item) {
            return item.total_completed;
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: asalLabels,
                datasets: [{
                    label: 'Presentase Tugas Selesai',
                    data: completedTasks,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna border
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
            options: {
                legend: {
                    position: 'left' // Menempatkan legenda di sebelah kiri grafik
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0, // Nilai minimum pada sumbu Y,
                        max: 1,
                        stepSize: 1 // Langkah kelipatan pada sumbu Y

                    }
                },

                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1 // Rasio aspek grafik, misalnya 1 untuk membuatnya menjadi kotak

            }
        });
    </script>

    <script>
        // Data yang Anda kirimkan dari Laravel dapat disimpan dalam variabel JavaScript
        var data = {!! json_encode($data) !!};

        // Mendapatkan elemen canvas dari ID
        var ctx = document.getElementById('taskChart').getContext('2d');

        // Membuat grafik lingkaran
        var taskChart = new Chart(ctx, {
            type: 'doughnut', // Jenis grafik adalah lingkaran
            data: {
                labels: Object.keys(data), // Label grafik
                datasets: [{
                    data: Object.values(data), // Data untuk setiap label
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)', // Warna untuk "Selesai"
                        'rgba(255, 205, 86, 0.8)', // Warna untuk "Progress"
                        'rgba(255, 99, 132, 0.8)' // Warna untuk "Belum Dikerjakan"
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true // Nonaktifkan responsif untuk ukuran tetap
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('bobotChart').getContext('2d');

        // Data yang telah diambil dari database
        var databobot = <?php echo json_encode($totalBobot); ?>;

        var namaLabels = databobot.map(function(item) {
            return item.nama;
        });

        var bobotTasks = databobot.map(function(item) {
            return item.total_bobot;
        });

        // Fungsi untuk menampilkan semua data pada chart
        function tampilkanDataBobotPegawai() {
            // Lakukan pengurutan data berdasarkan nama (label) secara alfabetis
            const sortedData = databobot.sort((a, b) => a.nama.localeCompare(b.nama));

            // Ekstrak label dan data setelah pengurutan
            const dataLabelsss = sortedData.map(item => item.nama);
            const databobott = sortedData.map(item => item.total_bobot);

            // Gunakan data yang telah diurutkan untuk mengganti data grafik
            myChart.data.labels = dataLabelsss;
            myChart.data.datasets[0].data = databobott;

            // Perbarui grafik
            myChart.update();
        }

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: namaLabels,
                datasets: [{
                    label: 'Total Bobot',
                    data: bobotTasks,
                    backgroundColor: "#FFFDA1",
                    borderColor: "#FFFA4A",
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        min: 0, // Nilai minimum pada sumbu x
                        stepSize: 1 // Langkah kelipatan pada sumbu x
                    },
                },
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                },
            },
        });

        function filterData() {
            var selectedFilter = document.getElementById('filterBobot').value;
            var filteredData = [];
            var filteredLabels = [];

            // Filter data berdasarkan kriteria yang dipilih
            for (var i = 0; i < data.length; i++) {
                if (selectedFilter === 'below25' && data[i] < 0.25 * Math.max(...data)) {
                    filteredData.push(data[i]);
                    filteredLabels.push(labels[i]); // Menambahkan label yang sesuai
                } else if (selectedFilter === '25to50' && data[i] >= 0.25 * Math.max(...data) && data[i] <= 0.5 * Math.max(
                        ...data)) {
                    filteredData.push(data[i]);
                    filteredLabels.push(labels[i]); // Menambahkan label yang sesuai
                } else if (selectedFilter === 'above50' && data[i] > 0.5 * Math.max(...data)) {
                    filteredData.push(data[i]);
                    filteredLabels.push(labels[i]); // Menambahkan label yang sesuai
                } else if (selectedFilter === 'all') {
                    filteredData.push(data[i]);
                    filteredLabels.push(labels[i]); // Menambahkan label yang sesuai
                }
            }

            // Perbarui grafik dengan data dan label yang sudah difilter
            myChart.data.labels = filteredLabels; // Perbarui label sumbu x
            myChart.data.datasets[0].data = filteredData;

        }
        tampilkanDataBobotPegawai()
    </script>

    <script>
        var countData = <?php echo json_encode($datacount); ?>;

        console.log(countData);

        var labelss = countData.map(function(item) {
            return item.name;
        });

        var countValues = countData.map(function(item) {
            return item.kegiatan;
        });

        // Fungsi untuk menampilkan semua data pada chart
        function tampilkanDataKegiatanPegawai() {
            // Lakukan pengurutan data berdasarkan nama (label) secara alfabetis
            const sortedData = countData.sort((a, b) => a.name.localeCompare(b.name));

            // Ekstrak label dan data setelah pengurutan
            const dataLabelss = sortedData.map(item => item.name);
            const datakegiatan = sortedData.map(item => item.kegiatan);

            // Gunakan data yang telah diurutkan untuk mengganti data grafik
            countChart.data.labels = dataLabelss;
            countChart.data.datasets[0].data = datakegiatan;

            // Perbarui grafik
            countChart.update();
        }

        // Inisialisasi grafik Jumlah Kegiatan Pegawai
        const ctxx = document.getElementById("counttChart").getContext("2d");
        const countChart = new Chart(ctxx, {
            type: "bar",
            data: {
                labels: labelss,
                datasets: [{
                    label: "Jumlah Kegiatan",
                    data: countValues,
                    backgroundColor: "rgba(255, 99, 132, 0.8)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        min: 0, // Nilai minimum pada sumbu x
                        max: 50,
                        stepSize: 1 // Langkah kelipatan pada sumbu x
                    }
                },
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                },

            }
        });


        // Tampilkan data pegawai saat halaman dimuat
        tampilkanDataKegiatanPegawai()
    </script>

    <script>
        // Ambil data dari controller Laravel
        const avgData = {!! json_encode($dataavg) !!};

        // Ekstrak label dan data dari hasil query
        const labelsss = avgData.map(item => item.nama);
        const avgValuess = avgData.map(item => item.nilai_akhir);

        // Fungsi untuk menampilkan semua data pada chart
        function tampilkanDataAvgPegawai() {
            // Lakukan pengurutan data berdasarkan nama (label) secara alfabetis
            const sortedData = avgData.sort((a, b) => a.nama.localeCompare(b.nama));

            // Ekstrak label dan data setelah pengurutan
            const dataLabelss = sortedData.map(item => item.nama);
            const dataAvgg = sortedData.map(item => item.nilai_akhir);

            // Gunakan data yang telah diurutkan untuk mengganti data grafik
            countChartt.data.labels = dataLabelss;
            countChartt.data.datasets[0].data = dataAvgg;

            // Perbarui grafik
            countChartt.update();
        }

        // Inisialisasi grafik
        const ctxxx = document.getElementById("AvgChart").getContext("2d");
        const countChartt = new Chart(ctxxx, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "Nilai Pegawai",
                    data: [],
                    backgroundColor: "rgba(75, 192, 192, 0.8)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        min: 0, // Nilai minimum pada sumbu x
                        stepSize: 1 // Langkah kelipatan pada sumbu x
                    }
                },
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                },
            }
        });

        // Tampilkan data pegawai saat halaman dimuat
        tampilkanDataAvgPegawai();
    </script>

    <script>
        document.getElementById("exportButtonChartNA").addEventListener("click", function() {
            // Menggunakan html2canvas untuk mengekspor grafik
            html2canvas(document.getElementById("AvgChart")).then(function(canvas) {
                // Mengonversi gambar dari canvas ke format PNG
                const imgData = canvas.toDataURL("image/png");

                // Membuat tautan untuk mengunduh gambar
                const link = document.createElement("a");
                link.href = imgData;
                link.download = "chart_export.png";

                // Simulasikan klik pada tautan untuk memicu unduhan
                link.click();
            });
        });
    </script>

    <script>
        document.getElementById("exportButtonCounttChart").addEventListener("click", function() {
            // Menggunakan html2canvas untuk mengekspor grafik
            html2canvas(document.getElementById("counttChart")).then(function(canvas) {
                // Mengonversi gambar dari canvas ke format PNG
                const imgData = canvas.toDataURL("image/png");

                // Membuat tautan untuk mengunduh gambar
                const link = document.createElement("a");
                link.href = imgData;
                link.download = "chart_export.png";

                // Simulasikan klik pada tautan untuk memicu unduhan
                link.click();
            });
        });
    </script>

    <script>
        document.getElementById("exportButtonBobotChart").addEventListener("click", function() {
            // Menggunakan html2canvas untuk mengekspor grafik
            html2canvas(document.getElementById("bobotChart")).then(function(canvas) {
                // Mengonversi gambar dari canvas ke format PNG
                const imgData = canvas.toDataURL("image/png");

                // Membuat tautan untuk mengunduh gambar
                const link = document.createElement("a");
                link.href = imgData;
                link.download = "chart_export.png";

                // Simulasikan klik pada tautan untuk memicu unduhan
                link.click();
            });
        });
    </script>

    <script>
        document.getElementById("exportButtonMyChart").addEventListener("click", function() {
            // Menggunakan html2canvas untuk mengekspor grafik
            html2canvas(document.getElementById("myChart")).then(function(canvas) {
                // Mengonversi gambar dari canvas ke format PNG
                const imgData = canvas.toDataURL("image/png");

                // Membuat tautan untuk mengunduh gambar
                const link = document.createElement("a");
                link.href = imgData;
                link.download = "chart_export.png";

                // Simulasikan klik pada tautan untuk memicu unduhan
                link.click();
            });
        });
    </script>

    <script>
        document.getElementById("exportButtonTaskChart").addEventListener("click", function() {
            // Menggunakan html2canvas untuk mengekspor grafik
            html2canvas(document.getElementById("taskChart")).then(function(canvas) {
                // Mengonversi gambar dari canvas ke format PNG
                const imgData = canvas.toDataURL("image/png");

                // Membuat tautan un3tuk mengunduh gambar
                const link = document.createElement("a");
                link.href = imgData;
                link.download = "chart_export.png";

                // Simulasikan klik pada tautan untuk memicu unduhan
                link.click();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tablectba').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#namanilaiakhir').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                "pageLength": 20,
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tableBobot').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                "pageLength": 20,
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tableCountt').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                "pageLength": 20,
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>




    <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
@endsection
