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
    <style>
        /* Ensure that the demo table scrolls */

        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }
    </style>
    <div class="container-fluid">
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
                <h5>Tim Klaten</h5>
            </div>
            <div class="col align-self-center border-top border-primary d-none d-sm-block"></div>
            <div class="col-sm-auto align-self-center ml-auto">

                <form method="post" action="{{ url('/simanja/Tim_Klaten') }}" class="form-inline">
                    @csrf
                    <div class="row">
                        <div class="form-group col px-1">
                            <select name="month" id="month" class="form-control" required>
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
                            <select name="year" id="year" class="form-control" required>
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body bg-white">
                        <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                            <h4 class="card-title" style="color: white">Tabel Kinerja Pegawai BPS Kabupaten Klaten
                                {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</h4>
                        </div>
                        <br>
                        {{-- <canvas id="myChart" class="visual"></canvas> --}}
                        <div class="table-responsive-xl">
                            <table id="dtBasicExampleVisual" class="stripe row-border order-column" style="width: 100%;">
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
                                    <th class="text-center">Nilai Kualitas</th>
                                    <th class="text-center">Nilai Kuantitas</th>
                                    <th class="text-center">Keterangan</th>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $key => $task)
                                        <tr>

                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td id="Pegawai{{ $key }}">{{ $task->name }}
                                            </td>
                                            {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                                            <td class="text-left" id="Nama{{ $key }}">{{ $task->tugas }}
                                            </td>
                                            <script>
                                                // Mendapatkan elemen dengan id 'Nama{{ $key }}'
                                                var element = document.getElementById('Nama{{ $key }}');

                                                // Mendapatkan teks dari elemen
                                                var text = element.innerText;

                                                // Memecah teks menjadi array kata-kata
                                                var words = text.split(' ');

                                                // Inisialisasi variabel untuk menyimpan teks yang telah dimodifikasi
                                                var newText = '';

                                                // Menghitung jumlah kata
                                                var wordCount = words.length;

                                                // Menyisipkan tag <br> setelah setiap tiga kata
                                                for (var i = 0; i < wordCount; i++) {
                                                    // Menambahkan kata ke teks baru
                                                    newText += words[i] + ' ';

                                                    // Jika sudah tiga kata, tambahkan tag <br>
                                                    if ((i + 1) % 3 === 0) {
                                                        newText += '<br>';
                                                    }
                                                }

                                                // Memasukkan teks baru ke dalam elemen
                                                element.innerHTML = newText;
                                            </script>
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
                                            <td class="text-center" id="Asal{{ $key }}">{{ $task->tim }}
                                            </td>
                                            <script>
                                                // Mendapatkan elemen dengan id 'Nama{{ $key }}'
                                                var element = document.getElementById('Asal{{ $key }}');

                                                // Mendapatkan teks dari elemen
                                                var text = element.innerText;

                                                // Memecah teks menjadi array kata-kata
                                                var words = text.split(' ');

                                                // Inisialisasi variabel untuk menyimpan teks yang telah dimodifikasi
                                                var newText = '';

                                                // Menghitung jumlah kata
                                                var wordCount = words.length;

                                                // Menyisipkan tag <br> setelah setiap tiga kata
                                                for (var i = 0; i < wordCount; i++) {
                                                    // Menambahkan kata ke teks baru
                                                    newText += words[i] + ' ';

                                                    // Jika sudah tiga kata, tambahkan tag <br>
                                                    if ((i + 1) % 3 === 0) {
                                                        newText += '<br>';
                                                    }
                                                }

                                                // Memasukkan teks baru ke dalam elemen
                                                element.innerHTML = newText;
                                            </script>
                                            <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                                            <input id="pegawai_id{{ $key }}" type="hidden"
                                                value="{{ $task->pegawai_id }}">
                                            <input id="file{{ $key }}" type="hidden"
                                                value="{{ $task->link_file }}">
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
                                            <td class="text-center">{{ $task->nilai_kualitas }}</td>
                                            <td class="text-center">{{ $task->nilai_kuantitas }}</td>
                                            @if ($task->keterangan == 'Telah dikonfirmasi')
                                                <td><span class="badge light badge-success">{{ $task->keterangan }}</span>
                                                </td>
                                            @elseif ($task->keterangan == 'Belum dikerjakan')
                                                <td class="text-center">
                                                    <span class="badge  light badge-dark">{{ $task->keterangan }}</span>
                                                </td>
                                            @elseif ($task->keterangan == 'Tunggu Konfirmasi')
                                                <td class="text-center">
                                                    <span class="badge light badge-warning">{{ $task->keterangan }}</span>
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
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body bg-white">
                        <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                            <h4 class="card-title" style="color: white">Tabel Nilai Akhir Pegawai
                                {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</h4>
                        </div>
                        <br>
                        @if (Auth::user()->role == 'admin')
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                                <a href="{{ route('export_excel_NA', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
                                    class="btn btn-custom" target="_blank"><i class="bi bi-box-arrow-right"></i>
                                    Export</a>

                            </div>
                        @endif
                        <br>
                        {{-- <canvas id="myChart" class="visual"></canvas> --}}
                        <div class="table-responsive-xl">
                            <table id="dtBasicnilaiakhir" class="stripe row-border order-column nowrap">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Pegawai</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Kategori Bobot</th>
                                    <th class="text-center">Total Bobot</th>
                                    <th class="text-center">Nilai Akhir</th>
                                </thead>
                                <tbody>
                                    @foreach ($hasil as $key => $output)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $output->nama }}</td>
                                            <td class="text-center">{{ $output->pegawai_id }}</td>
                                            <td class="text-center">
                                                @if ($output->kategori_bobot == 'besar')
                                                    <span class="badge  light badge-danger">Besar</span>
                                                @elseif ($output->kategori_bobot == 'sedang')
                                                    <span class="badge  light badge-warning">Sedang</span>
                                                @elseif ($output->kategori_bobot == 'kecil')
                                                    <span class="badge light badge-success">Kecil</span>
                                                @else
                                                    {{ $output->kategori_bobot }}
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $output->total_bobot }}</td>
                                            <td class="text-center">{{ $output->nilai_akhir }}</td>
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




    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/fixedColumns.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">

    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
@endsection
