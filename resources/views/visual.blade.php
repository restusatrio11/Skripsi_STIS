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

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p id="realtime-clock" class="mb-0 text-gray-600"></p>
        </div>

        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration bg-white" role="alert">
            <div class="inner">
                <div class="app-card-body p-3 p-lg-4">
                    <div class="row gx-5 gy-3">
                        <div class="col-12 col-lg-9">
                            <h3 class="mb-3">Welcome, {{ Auth::user()->name }}!</h3>
                            <p>
                                "Simanja" adalah kependekan dari "Sistem Manajemen Kinerja." Ini adalah sistem atau platform
                                yang dirancang untuk membantu BPS Kabupaten Klaten dalam mengelola dan mengoptimalkan
                                kinerja karyawan atau anggota tim. Simanja biasanya berfungsi sebagai alat yang membantu
                                dalam mengukur, mengelola, dan meningkatkan kinerja individu dan tim di dalam organisasi.
                            </p>
                        </div><!--//col-->
                        <div class="col-12 col-lg-3">
                            <img src="/images/dashboard.png" alt="Dashboard" class="img-fluid">
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
                                                aria-valuemin="0" aria-valuemax="100">
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mostActiveEmployee->nama }}</div>
                                <p class="mb-0"><span
                                        class="text-dark me-2">{{ $mostActiveEmployee->total_realisasi }}</span>
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


        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body bg-white">
                    <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h4 class="card-title" style="color: white">Jumlah Kegiatan Pegawai</h4>
                    </div>
                    <div id="chart-container">
                        <canvas id="counttChart" class="visual"></canvas>
                    </div>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" id="prevPage" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" id="nextPage" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body bg-white">
                    <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h4 class="card-title" style="color: white">Rata-Rata Nilai Pegawai</h4>
                    </div>
                    <div id="chart-container">
                        <canvas id="AvgChart" class="visual"></canvas>
                    </div>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" id="prevPageAVG" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" id="nextPageAVG" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        {{-- </div> --}}
        <br>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body bg-white">
                    <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h4 class="card-title" style="color: white">Jumlah Bobot Pekerjaan Pegawai</h4>
                    </div>
                    <br>
                    <div>
                        <label for="filterBobot">Filter Bobot:</label>
                        <select id="filterBobot" onchange="filterData()">
                            <option value="all">Semua</option>
                            <option value="below25">Dibawah 25%</option>
                            <option value="25to50">25%-50%</option>
                            <option value="above50">Diatas 50%</option>
                        </select>
                    </div>

                    <canvas id="bobotChart" class="visual"></canvas>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-white">
                    <div class="card-body">
                        <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                            <h5 class="card-title" style="color: white">Jumlah Tugas Selesai</h5>
                        </div>

                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white">
                    <div class="card-body">
                        <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                            <h5 class="card-title" style="color: white">Performa Tugas</h5>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <canvas id="taskChart"></canvas>
                            </div>
                            <div class="text-start ms-3">
                                <p><i class="bi bi-info-circle"></i> Belum Dikerjakan: {{ $notStartedPercentage }}%</p>
                                <p><i class="bi bi-check-circle"></i> Selesai: {{ $completedPercentage }}%</p>
                                <p><i class="bi bi-arrow-right-circle"></i> Progress: {{ $progressPercentage }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <br>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body bg-white">
                        <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                            <h4 class="card-title" style="color: white">Tabel Kinerja Pegawai BPS Kabupaten Klaten</h4>
                        </div>
                        <br>
                        {{-- <canvas id="myChart" class="visual"></canvas> --}}
                        <div class="table-responsive-xl">
                            <table id="dtBasicExample" class="stripe row-border order-column nowrap">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Pegawai</th>
                                    {{-- <th class="text-center">ID Pegawai</th> --}}
                                    <th class="text-center">Tugas</th>
                                    <th class="text-center">Bobot</th>
                                    <th class="text-center">Asal</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Deadline</th>
                                    <th class="text-center">Tgl Realisasi</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Keterangan</th>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $key => $task)
                                        <tr>
                                            <input id="id{{ $key }}" type="hidden"
                                                value="{{ $task->task_id }}">
                                            <input id="pegawai_id{{ $key }}" type="hidden"
                                                value="{{ $task->pegawai_id }}">
                                            <input id="file{{ $key }}" type="hidden"
                                                value="{{ $task->file }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center" id="Pegawai{{ $key }}">{{ $task->name }}
                                            </td>
                                            {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                                            <td class="text-center" id="Nama{{ $key }}">{{ $task->nama }}
                                            </td>
                                            <td class="text-center">
                                                @if ($task->bobot == 'Besar')
                                                    <span class="badge  rounded-pill text-bg-danger text-white"
                                                        id="Bobot{{ $key }}">Besar</span>
                                                @elseif ($task->bobot == 'Sedang')
                                                    <span class="badge  rounded-pill text-bg-warning text-white"
                                                        id="Bobot{{ $key }}">Sedang</span>
                                                @elseif ($task->bobot == 'Kecil')
                                                    <span class="badge rounded-pill text-bg-success text-white"
                                                        id="Bobot{{ $key }}">Kecil</span>
                                                @else
                                                    {{ $task->bobot }}
                                                @endif
                                            </td>
                                            <td class="text-center" id="Asal{{ $key }}">{{ $task->asal }}
                                            </td>
                                            <td class="text-center" id="Target{{ $key }}">{{ $task->target }}
                                            </td>
                                            <td class="text-center" id="Realisasi{{ $key }}">
                                                <div class="progress">
                                                    <div class="progress-bar
                                                        @if (($task->realisasi / $task->target) * 100 <= 20) bg-danger
                                                        @elseif (($task->realisasi / $task->target) * 100 <= 50)
                                                            bg-warning
                                                        @else
                                                            bg-success @endif"
                                                        role="progressbar"
                                                        style="width: {{ ($task->realisasi / $task->target) * 100 }}%;"
                                                        aria-valuenow="{{ $task->realisasi }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $task->target }}">
                                                        {{ $task->realisasi }} / {{ $task->target }}
                                                    </div>
                                                </div>{{ round(($task->realisasi / $task->target) * 100, 0) }}%
                                            </td>
                                            <td class="text-center" id="Satuan{{ $key }}">{{ $task->satuan }}
                                            </td>
                                            <td class="text-center tgd" id="Deadline{{ $key }}"
                                                data-value="{{ $task->deadline }}">
                                                {{ date('d M Y', strtotime($task->deadline)) }}</td>
                                            @if ($task->tgl_realisasi != null)
                                                <td class="text-center tgr">
                                                    {{ date('d M Y', strtotime($task->tgl_realisasi)) }}</td>
                                            @else
                                                <td class="text-center tgr"></td>
                                            @endif
                                            <td class="text-center">{{ $task->nilai }}</td>
                                            @if ($task->keterangan == 'Telah dikonfirmasi')
                                                <td><span
                                                        class="badge rounded-pill text-bg-success text-white">{{ $task->keterangan }}</span>
                                                </td>
                                            @elseif ($task->keterangan == 'Belum dikerjakan')
                                                <td class="text-center">
                                                    <span
                                                        class="badge  rounded-pill text-bg-warning text-white">{{ $task->keterangan }}</span>
                                                </td>
                                            @elseif ($task->keterangan == 'Tunggu Konfirmasi')
                                                <td class="text-center">
                                                    <span
                                                        class="badge rounded-pill text-bg-info text-white">{{ $task->keterangan }}</span>
                                                </td>
                                            @endif
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);
            clockElement.textContent = formattedDate;
        }

        // Panggil fungsi updateClock setiap detik
        setInterval(updateClock, 1000);

        // Panggil updateClock untuk menampilkan waktu awal
        updateClock();

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
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna border
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1 // Langkah sumbu y
                    }
                }
            }
        });

        console.log(myChart);
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
                        'rgba(75, 192, 192, 0.6)', // Warna untuk "Selesai"
                        'rgba(255, 205, 86, 0.6)', // Warna untuk "Progress"
                        'rgba(255, 99, 132, 0.6)' // Warna untuk "Belum Dikerjakan"
                    ]
                }]
            },
            options: {
                responsive: false // Nonaktifkan responsif untuk ukuran tetap
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('bobotChart').getContext('2d');
        var labels = @json(array_keys($totalBobot));
        var data = @json(array_values($totalBobot));

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Bobot',
                    data: data,
                    backgroundColor: "#FFFDA1",
                    borderColor: "#FFFA4A",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Total Bobot Kegiatan Pegawai",
                        font: {
                            size: 20,
                        },
                        padding: 30
                    },
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        // formatter: Math.round,
                    }
                },
                // barThickness: 20, // Atur lebar batang (sesuaikan dengan kebutuhan Anda)
                // categoryPercentage: 0.8, // Atur jarak antar batang (sesuaikan dengan kebutuhan Anda)
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
            myChart.update();
        }
    </script>

    <script>
        // Ambil data dari controller Laravel
        const countData = {!! json_encode($datacount) !!};

        // Ekstrak label dan data dari hasil query
        const labelss = countData.map(item => item.name);
        const countValues = countData.map(item => item.kegiatan);

        // Tentukan berapa pegawai per halaman
        const pegawaiPerHalaman = 10; // Ganti sesuai kebutuhan

        // Hitung jumlah halaman
        const jumlahHalaman = Math.ceil(labelss.length / pegawaiPerHalaman);
        let halamanAktif = 1;

        // Fungsi untuk mengganti data pegawai yang ditampilkan
        function tampilkanDataPegawai() {
            const mulai = (halamanAktif - 1) * pegawaiPerHalaman;
            const akhir = mulai + pegawaiPerHalaman;

            const dataLabels = labelss.slice(mulai, akhir);
            const dataCount = countValues.slice(mulai, akhir);

            // Gunakan data yang telah dipotong untuk mengganti data grafik
            countChart.data.labels = dataLabels;
            countChart.data.datasets[0].data = dataCount;

            // Perbarui grafik
            countChart.update();
        }

        // Inisialisasi grafik
        const ctxx = document.getElementById("counttChart").getContext("2d");
        const countChart = new Chart(ctxx, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "Jumlah Kegiatan",
                    data: [],
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Tampilkan data pegawai saat halaman dimuat
        tampilkanDataPegawai();

        // Event listener untuk tombol Previous
        document.getElementById("prevPage").addEventListener("click", function() {
            if (halamanAktif > 1) {
                halamanAktif--;
                tampilkanDataPegawai();
            }
        });

        // Event listener untuk tombol Next
        document.getElementById("nextPage").addEventListener("click", function() {
            if (halamanAktif < jumlahHalaman) {
                halamanAktif++;
                tampilkanDataPegawai();
            }
        });
    </script>

    <script>
        // Ambil data dari controller Laravel
        const avgData = {!! json_encode($dataavg) !!};

        // Ekstrak label dan data dari hasil query
        const labelsss = avgData.map(item => item.name);
        const avgValuess = avgData.map(item => item.nilai);

        // Tentukan berapa pegawai per halaman
        const pegawaiPerHalamann = 10; // Ganti sesuai kebutuhan

        // Hitung jumlah halaman
        const jumlahHalamann = Math.ceil(labelsss.length / pegawaiPerHalamann);
        let halamanAktiff = 1;

        // Fungsi untuk mengganti data pegawai yang ditampilkan
        function tampilkanDataAvgPegawai() {
            const mulaii = (halamanAktiff - 1) * pegawaiPerHalamann;
            const akhirr = mulaii + pegawaiPerHalamann;

            const dataLabelss = labelsss.slice(mulaii, akhirr);
            const dataAvgg = avgValuess.slice(mulaii, akhirr);

            // Gunakan data yang telah dipotong untuk mengganti data grafik
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
                    label: "Rata-rata Nilai",
                    data: [],
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Tampilkan data pegawai saat halaman dimuat
        tampilkanDataAvgPegawai();

        // Event listener untuk tombol Previous
        document.getElementById("prevPageAVG").addEventListener("click", function() {
            if (halamanAktiff > 1) {
                halamanAktiff--;
                tampilkanDataAvgPegawai();
            }
        });

        // Event listener untuk tombol Next
        document.getElementById("nextPageAVG").addEventListener("click", function() {
            if (halamanAktiff < jumlahHalamann) {
                halamanAktiff++;
                tampilkanDataAvgPegawai();
            }
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>

    <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
@endsection
