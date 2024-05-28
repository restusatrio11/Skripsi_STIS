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

        {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Progress {{ Auth::user()->tim }}</h1>
            <p id="realtime-clock" class="mb-0 text-gray-600"></p>
        </div> --}}

        <!-- resources/views/tasks/index.blade.php -->

        @php
            $selectedYear = request('year', null);
            $selectedMonth = request('month', null);
        @endphp

        <div class="row">
            @if (Auth::user()->TimAnggota !== null)
                <div class="col-sm-auto align-self-center">
                    <h5>Progress {{ Auth::user()->TimAnggota->tim }}</h5>
                </div>
            @else
                <div class="col-sm-auto align-self-center">
                    <h5>Progress</h5>
                </div>
            @endif

            <div class="col align-self-center border-top border-primary d-none d-sm-block"></div>
            <div class="col-sm-auto align-self-center ml-auto">

                <form method="post" action="{{ url('/simanja/progress') }}" class="form-inline">
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
        <div class="card-body bg-white">
            @if (Auth::user()->TimAnggota !== null)
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Kinerja Pegawai {{ Auth::user()->TimAnggota->tim }}
                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}
                    </h4>
                </div>
            @else
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Kinerja Pegawai
                        {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}
                    </h4>
                </div>
            @endif

            <br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                @if ($admin->tim === 'Subbag Umum')
                    <a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#tambahkerja"
                        style="color: #ffffff"><i class="bi bi-pencil-square"></i>Tambah Pekerjaan</a>

                    <a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#ckpkerja"
                        id="cetak" style="color: #ffffff"><button type="button" class="btn btn-primary btn-floating"><i
                                class="fas fa-download"> CKP</i></button></a>

                    <a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#import"
                        id="cetak" style="color: #ffffff"><button type="button" class="btn btn-primary btn-floating"><i
                                class="fas fa-file-import"> Import</i></button></a>

                    <a href="/export_excel" class="nav-item nav-link" target="_blank"><button type="button"
                            class="btn btn-primary btn-floating"><i class="fas fa-file-export"> Export</i></button></a>
                @else
                    <a class="btn btn-custom" href="#" data-bs-toggle="modal" data-bs-target="#tambahkerja"><i
                            class="bi bi-pencil-square"></i> Tambah Pekerjaan</a>

                    <a class="btn btn-custom" href="#" data-bs-toggle="modal" data-bs-target="#import"
                        id="cetak"><i class="bi bi-box-arrow-in-right"></i> Import</a>

                    <a href="{{ route('export_excel', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
                        class="btn btn-custom" target="_blank"><i class="bi bi-box-arrow-right"></i> Export</a>
                @endif


            </div>
            <br>

        </div>


        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="table-responsive-xl">
                    <table id="dtBasicExample" class="stripe row-border order-column nowrap">
                        <thead>
                            <th class="text-center fixed-column">No</th>
                            <th class="text-center fixed-column">Pegawai</th>
                            {{-- <th class="text-center">ID Pegawai</th> --}}
                            <th class="text-center">Tugas</th>
                            <th class="text-center">Bobot</th>
                            <th class="text-center">Asal</th>
                            <th class="text-center">Target</th>
                            <th class="text-center">Realisasi</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Deadline</th>
                            <th class="text-center">Tgl Realisasi</th>
                            {{-- <th class="text-center">Nilai Akhir</th> --}}
                            <th class="text-center">Nilai Kualitas</th>
                            <th class="text-center">Nilai Kuantitas</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Catatan</th>
                            <th class="text-center">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr id="table-admin">

                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td id="Pegawai{{ $key }}">{{ $task->name }}</td>
                                    {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                                    <td class="text-left" id="Nama{{ $key }}">{{ $task->tugas }}</td>
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
                                    {{-- @if ($task->bobot == 'Besar')
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
                                        @endif --}}
                                    <td class="text-center" id="Bobot{{ $key }}">{{ $task->bobot }}
                                    </td>
                                    <td class="text-left" id="Asal{{ $key }}">{{ $task->tim }}</td>
                                    {{-- <script>
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
                                    </script> --}}
                                    <td class="text-center" id="Target{{ $key }}">{{ $task->target }}</td>
                                    <td class="text-center">
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
                                        <div id="Realisasi{{ $key }}" hidden>{{ $task->realisasi }}</div>
                                    </td>
                                    <td class="text-center" id="Satuan{{ $key }}">{{ $task->satuan }}</td>
                                    <td class="text-center tgd"
                                        id="Deadline{{ $key }}"data-value="{{ $task->deadline }}"
                                        style="white-space: nowrap;">{{ date('d M Y', strtotime($task->deadline)) }}
                                    </td>
                                    {{-- <td style="text-align: center">{{ date('d M Y', strtotime($task->deadline)) }}</td> --}}
                                    @if ($task->tgl_realisasi != null)
                                        <td id="Tgl_Realisasi{{ $key }}"
                                            style="text-align: center;
                                            white-space:nowrap;
                                            color:black;"
                                            class="text-center">{{ date('d M Y', strtotime($task->tgl_realisasi)) }}
                                        </td>
                                    @else
                                        <td class="text-center tgr" id="Tgl_Realisasi{{ $key }}"></td>
                                    @endif
                                    {{-- <td class="text-center">{{ $task->nilai }}</td> --}}
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
                                    {{-- <td class="text-center" id="Catatan{{ $key }}">{{ $task->catatan }}</td> --}}


                                    <td class="text-justify">
                                        <!-- Tombol "Lihat" hanya muncul jika ada catatan -->
                                        @if ($task->catatan)
                                            <button class="btn btn-custom" data-bs-toggle="modal"
                                                data-bs-target="#modalCatatan{{ $key }}"><i
                                                    class="bi bi-eye"></i> Lihat</button>
                                        @endif
                                    </td>


                                    <td class="text-center">

                                        <a href="#" class="edit" data-bs-toggle="modal"><i
                                                class="fas fa-square-pen" data-bs-toggle="modal" title="Edit"
                                                style="color: orange; font-size: 20px;" data-bs-target="#updatekerja"
                                                data="{{ $key }}" data-id="{{ $task->task_id }}"
                                                role="button"></i>
                                        </a>
                                        {{-- <form class="delete-form" action="{{ route('delete') }}" method="POST"> --}}

                                        <a href="#" class="delete" data-bs-toggle="modal"><i
                                                class="fas fa-trash hapus" title="Delete"
                                                style="color: red; font-size: 20px;" data-id="{{ $task->task_id }}"
                                                data-bs-target="#deletekerja" data="{{ $key }}"
                                                data-bs-toggle="modal"></i></a>
                                        {{-- </form> --}}
                                        @if ($task->keterangan == 'Tunggu Konfirmasi' || $task->keterangan == 'Telah dikonfirmasi')
                                            <a href="#" class="lihat-dokumen-btn" data-bs-toggle="modal"
                                                data-bs-target="#penilaiankerja"
                                                data-task='@json(['link_file' => $task->link_file, 'files' => $task->files])'><i class="fas fa-check-circle"
                                                    data-bs-toggle="modal" title="Edit"
                                                    style="color: green; font-size: 20px;"
                                                    data-bs-target="#penilaiankerja" data="{{ $key }}"
                                                    data-id="{{ $task->task_id }}" role="button"></i></a>
                                        @endif
                                    </td>
                                    <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                                    <input id="tugas_id{{ $key }}" type="hidden"
                                        value="{{ $task->task_id }}">
                                    {{-- <input id="file_idd{{ $key }}" type="hidden"
                                        value="{{ $task->files->file_id }}"> --}}
                                    <input id="pegawai_id{{ $key }}" type="hidden"
                                        value="{{ $task->pegawai_id }}">
                                    <input id="jenistask_id{{ $key }}" type="hidden"
                                        value="{{ $task->jenistask_id }}">
                                    {{-- <input id="file{{ $key }}" type="hidden" value="{{ $task->task_id }}"> --}}
                                    <input id="file{{ $key }}" type="hidden" value="{{ $task->link_file }}">
                                </tr>
                                <!-- Modal -->
                                @if ($task->catatan)
                                    <div class="modal fade" id="modalCatatan{{ $key }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalCatatanLabel{{ $key }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background: linear-gradient(to right, #4c96db, #194d7e);">
                                                    <h5 class="modal-title" id="modalCatatanLabel{{ $key }}">
                                                        Catatan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body text-justify">
                                                    {{ $task->catatan }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn light btn-bahaya"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body bg-white">
                        <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                            <h4 class="card-title" style="color: white">Tabel Monitoring Pekerjaan
                                {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}
                            </h4>
                        </div>
                        <br>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                            {{-- <a href="/export_excelNA" class="nav-item nav-link" target="_blank"><button type="button"
                                    class="btn btn-primary btn-floating"><i class="fas fa-file-export">
                                        Export</i></button></a> --}}


                        </div>
                        <br>
                        {{-- <canvas id="myChart" class="visual"></canvas> --}}
                        <div class="table-responsive-xl">
                            <table id="dtBasicExamplejp" class="stripe row-border order-column nowrap">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Pekerjaan</th>
                                    <th class="text-center">Total Target</th>
                                    <th class="text-center">Total Realisasi</th>
                                </thead>
                                <tbody>
                                    @foreach ($jenisPekerjaan as $key => $jp)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $jp->tugas }}</td>
                                            <td class="text-center">{{ $jp->total_target }}</td>
                                            <td class="text-center">
                                                <div class="progress">
                                                    <div class="progress-bar
                                                @if (($jp->total_realisasi / $jp->total_target) * 100 <= 20) bg-danger
                                                @elseif (($jp->total_realisasi / $jp->total_target) * 100 <= 50)
                                                    bg-warning
                                                @else
                                                    bg-success @endif"
                                                        role="progressbar"
                                                        style="width: {{ ($jp->total_realisasi / $jp->total_target) * 100 }}%;"
                                                        aria-valuenow="{{ $jp->total_realisasi }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $jp->total_target }}">
                                                        {{ $jp->total_realisasi }} / {{ $jp->total_target }}
                                                    </div>
                                                </div>{{ round(($jp->total_realisasi / $jp->total_target) * 100, 0) }}%
                                                <div id="total_realisasi{{ $key }}" hidden>
                                                    {{ $jp->total_realisasi }}</div>
                                            </td>
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

    </div>


    <!-- Modal Insert -->
    <div class="modal fade" id="tambahkerja" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Buat Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form id="myForm" action="{{ Route('store') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputIdD" name="task_id">
                                    </div>

                                </div>
                            </div>



                            <div class="row">
                                <div class="form-group col">

                                    <label>Pilih Tugas<span class="text-danger">*</span></label>
                                    <select name="jenistask_id" id="inputTaskk"
                                        class="selectpicker form-control select2">
                                        <option>Pilih Tugas</option>
                                        @foreach ($jenis_tasks as $jenis)
                                            <option value="{{ $jenis->no }}" data-satuan="{{ $jenis->satuan }}"
                                                data-bobot="{{ $jenis->bobot }}">
                                                {{ $jenis->tugas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="inputAsal">Tim Pemberi Tugas<span class="text-danger">*</span></label>
                                    <div>

                                        <select class="selectpicker form-control" data-live-search="true"
                                            id="inputAsall">
                                            <option value=" " disabled>Pilih Tim</option>
                                            @foreach ($jenis_tim as $jtim)
                                                <option value="{{ $jtim->tim }}">
                                                    {{ $jtim->tim }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">


                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group">
                                    <label for="inputBobot">Bobot<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputBobot"
                                        placeholder="Bobot Pekerjaan" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="inputSatuan">Satuan<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputSatuan"
                                        placeholder="Satuan Pekerjaan" readonly>
                                </div>

                                <div class="col-md-2">
                                    {{-- <label for="inputRealisasi">Realisasi</label> --}}
                                    <input type="hidden" class="form-control" id="inputRealisasii" name="realisasi"
                                        value="0" readonly>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputDeadline">Deadline<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="deadlinee" name="deadline"
                                    placeholder="DD/MM/YYYY" required />
                            </div>
                            <input type="hidden" class="form-control" name="keterangan" />
                            <br>
                            <div class="container">
                                <label class="font-weight-bold" style="font-weight: bold">Pilih Pegawai dan Isi
                                    Target<span class="text-danger">*</span></label>
                                <br>
                                <table class="table" id="tableinsertpegawaitarget">
                                    <thead>
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Target</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pegawai as $pegawaibps)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="pegawai_id[]" value="{{ $pegawaibps->id }}"
                                                            id="pegawai_{{ $pegawaibps->id }}">
                                                        <label class="form-check-label"
                                                            for="pegawai_{{ $pegawaibps->id }}">{{ $pegawaibps->name }}</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control target-input"
                                                            id="inputTarget_{{ $pegawaibps->id }}"
                                                            name="target[{{ $pegawaibps->id }}]">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>

                            <input type="hidden" name="selectedTargets" id="selectedTargets">

                            <script>
                                var selectedTargets = {};

                                $(".form-check-input").change(function() {
                                    // Validasi hanya mengirim input target untuk pegawai yang dipilih
                                    var targetInputs = document.querySelectorAll('.target-input');

                                    targetInputs.forEach(function(input) {
                                        var checkboxId = input.id.replace('inputTarget_', 'pegawai_');
                                        var checkbox = document.getElementById(checkboxId);

                                        if (checkbox) {
                                            if (checkbox.checked) {
                                                // Jika checkbox dipilih, berikan kembali atribut 'name'
                                                input.setAttribute('name', 'target[' + checkbox.value + ']');
                                                selectedTargets[checkbox.value] = input.value;
                                            } else {
                                                input.removeAttribute('name');
                                                if (selectedTargets[checkbox.value])
                                                    delete selectedTargets[checkbox.value];
                                            }
                                        }
                                    });
                                    // Convert objek selectedTargets menjadi string JSON dan masukkan ke input tersembunyi
                                    document.getElementById('selectedTargets').value = JSON.stringify(selectedTargets);
                                });

                                $(".target-input").change(function() {
                                    // Validasi hanya mengirim input target untuk pegawai yang dipilih
                                    var targetInputs = document.querySelectorAll('.target-input');

                                    targetInputs.forEach(function(input) {
                                        var checkboxId = input.id.replace('inputTarget_', 'pegawai_');
                                        var checkbox = document.getElementById(checkboxId);

                                        if (checkbox) {
                                            if (checkbox.checked) {
                                                // Jika checkbox dipilih, berikan kembali atribut 'name'
                                                input.setAttribute('name', 'target[' + checkbox.value + ']');
                                                selectedTargets[checkbox.value] = input.value;
                                            } else {
                                                input.removeAttribute('name');
                                                if (selectedTargets[checkbox.value])
                                                    delete selectedTargets[checkbox.value];
                                            }
                                        }
                                    });
                                    // Convert objek selectedTargets menjadi string JSON dan masukkan ke input tersembunyi
                                    document.getElementById('selectedTargets').value = JSON.stringify(selectedTargets);
                                });
                            </script>
                            <div id="alertMessage" class="alert alert-warning alert-dismissible fade show"
                                style="display: none;">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <path
                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                    </path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <strong class="alertMessagee"></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="btn-close"></button>
                            </div>
                            <script>
                                var selectedTargets = {};

                                // Fungsi untuk memperbarui objek selectedTargets
                                function updateSelectedTargets() {
                                    var targetInputs = document.querySelectorAll('.target-input');

                                    targetInputs.forEach(function(input) {
                                        var checkboxId = input.id.replace('inputTarget_', 'pegawai_');
                                        var checkbox = document.getElementById(checkboxId);

                                        if (checkbox) {
                                            if (checkbox.checked) {
                                                // Jika checkbox dipilih, berikan kembali atribut 'name'
                                                input.setAttribute('name', 'target[' + checkbox.value + ']');
                                                selectedTargets[checkbox.value] = input.value;
                                            } else {
                                                input.removeAttribute('name');
                                                if (selectedTargets[checkbox.value])
                                                    delete selectedTargets[checkbox.value];
                                            }
                                        }
                                    });

                                    // Convert objek selectedTargets menjadi string JSON dan masukkan ke input tersembunyi
                                    document.getElementById('selectedTargets').value = JSON.stringify(selectedTargets);
                                }

                                // Memanggil fungsi updateSelectedTargets saat ada perubahan pada checkbox
                                $(".form-check-input").change(function() {
                                    updateSelectedTargets();
                                });

                                // Memanggil fungsi updateSelectedTargets saat ada perubahan pada input target
                                $(".target-input").change(function() {
                                    updateSelectedTargets();
                                });

                                // Validasi saat formulir akan disubmit
                                document.getElementById("myForm").addEventListener("submit", function(event) {
                                    // Mendapatkan daftar checkbox dan input target
                                    var checkboxes = document.querySelectorAll(".form-check-input");

                                    // Mengecek apakah minimal satu checkbox tercentang di semua halaman
                                    var atLeastOneChecked = false;

                                    for (var key in selectedTargets) {
                                        if (selectedTargets.hasOwnProperty(key)) {
                                            atLeastOneChecked = true;
                                            break;
                                        }
                                    }

                                    // Mengecek apakah semua target dari pegawai yang dipilih telah terisi
                                    var allTargetsFilled = true;
                                    for (var key in selectedTargets) {
                                        if (selectedTargets.hasOwnProperty(key) && selectedTargets[key].trim() === "") {
                                            allTargetsFilled = false;
                                            break;
                                        }
                                    }


                                    // Jika tidak ada checkbox yang tercentang, hentikan proses submit
                                    if (!atLeastOneChecked) {
                                        event.preventDefault();
                                        document.getElementById("alertMessage").innerText = "Pilih minimal satu pegawai.";
                                        document.getElementById("alertMessage").style.display = "block";
                                        // Fokus ke checkbox pertama
                                        checkboxes[0].focus();
                                    } else if (!allTargetsFilled) { // Jika semua pegawai yang dipilih, memiliki target yang terisi
                                        event.preventDefault();
                                        document.getElementById("alertMessage").innerText =
                                            "Semua target pegawai yang dipilih harus terisi.";
                                        document.getElementById("alertMessage").style.display = "block";
                                        // Fokus ke input target yang belum terisi untuk setiap pegawai yang dipilih
                                        $(".target-input").each(function() {
                                            if ($(this).val().trim() === "") {
                                                $(this).focus();
                                                return false; // Hentikan iterasi setelah fokus ke input pertama yang belum terisi
                                            }
                                        });
                                    }
                                });
                            </script>

                            <div class="form-group">
                                <label for="inputCatatan">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan"></textarea>
                            </div>
                            <br>
                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                        </div>

                        <!--END FORM BUAT PEKERJAAN-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update-->
    <div class="modal fade" id="updatekerja" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Update Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!--FORM BUAT PEKERJAAN-->
                    <form id="updateform" action="{{ Route('update') }}" method="post">
                        @csrf
                        <div class="container">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputId" name="id">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPegawai">Nama Pegawai<span class="text-danger">*</span></label>
                                        <div>

                                            <select name="pegawai_id" class="selectpicker form-control"
                                                data-live-search="true" id="inputpegawai_id">
                                                @foreach ($pegawai as $pegawaibps)
                                                    <option value="{{ $pegawaibps->id }}">{{ $pegawaibps->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- <div class="form-group col">
                                <label for="inputpegawai_id">ID Pegawai</label>
                                <input type="text" class="form-control" id="inputpegawai_id" name="pegawai_id"">
                            </div> --}}

                            <div class="row">
                                <div class="form-group col">
                                    {{-- <label for="inputTask">Tugas</label>
                                    <input type="text" class="form-control" id="inputTask" name="nama" required> --}}

                                    <label>Pilih Tugas<span class="text-danger">*</span></label>
                                    <select name="jenistask_id" id="inputTask" class="selectpicker form-control">
                                        <option>Pilih Tugas</option>
                                        @foreach ($jenis_tasks as $jenis)
                                            <option value="{{ $jenis->no }}" data-satuan="{{ $jenis->satuan }}"
                                                data-bobot="{{ $jenis->bobot }}">
                                                {{ $jenis->tugas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--
                                <div class="form-group col">
                                    <label for="inputAsal">Asal</label>
                                    <input type="text" class="form-control" id="inputAsal" name="asal" required>
                                </div> --}}

                                <div class="form-group">
                                    <label for="inputAsal">Tim Pemberi Tugas<span class="text-danger">*</span></label>
                                    <div>

                                        <select class="selectpicker form-control" data-live-search="true" id="inputAsal">
                                            <option disabled>Pilih Tim</option>

                                            @foreach ($jenis_tim as $jtim)
                                                <option value="{{ $jtim->tim }}">
                                                    {{ $jtim->tim }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    {{-- <label for="inputbobot">Bobot</label>
                                    <div>
                                        <select name="bobot" class="selectpicker form-control" data-live-search="true"
                                            id="inputbobot">
                                            <option>Pilih Bobot</option>
                                            <option>Besar</option>
                                            <option>Sedang</option>
                                            <option>Kecil</option>
                                        </select>
                                    </div> --}}
                                    {{-- <div class="col-md-2">
                                        <label for="inputbobot">Bobot</label>
                                        <input type="text" class="form-control" id="inputbobot" name="bobot"
                                            readonly="readonly">
                                    </div> --}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputTarget">Target <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputTarget" name="target" required>
                                </div>

                                <!-- Validasi -->
                                <script>
                                    // Tangkap form
                                    var form = document.getElementById("updateform");

                                    // Tambahkan event listener untuk peristiwa submit
                                    form.addEventListener("submit", function(event) {
                                        // Dapatkan nilai input target
                                        var inputValue = document.getElementById("inputTarget").value;

                                        // Gunakan ekspresi reguler untuk memeriksa apakah hanya berisi bilangan bulat atau desimal dengan titik
                                        var regex = /^[0-9,.]+$/;

                                        // Validasi input
                                        if (!regex.test(inputValue)) {
                                            // Tampilkan pesan validasi
                                            document.getElementById("targetValidationMessage").innerText =
                                                "Input harus berupa bilangan bulat, huruf tidak diperbolehkan.";

                                            // Set fokus ke input target
                                            document.getElementById("inputTarget").focus();

                                            // Mencegah pengiriman formulir jika validasi gagal
                                            event.preventDefault();
                                        } else {
                                            // Bersihkan pesan validasi jika input valid
                                            document.getElementById("targetValidationMessage").innerText = "";
                                        }
                                    });
                                </script>

                                <div class="col-md-2">
                                    <label for="inputRealisasi">Realisasi</label>
                                    <input type="text" class="form-control" id="inputRealisasi" name="realisasi"
                                        readonly="readonly">
                                </div>

                                <div class="col-md-2">
                                    <label for="inputbobot">Bobot</label>
                                    <input type="text" class="form-control" id="inputbobot" readonly="readonly">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputSatuan">Satuan</label>
                                    <input type="text" class="form-control" id="inputsatuan" readonly="readonly">
                                </div>
                            </div>
                            <small id="targetValidationMessage" class="text-danger"></small>
                            <div class="form-group">
                                <label for="inputDeadline">Deadline <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="inputDeadline" name="deadline"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="inputCatatan">Catatan</label>
                                <textarea class="form-control" id="inputCatatan" name="catatan"></textarea>
                            </div>
                            <input type="hidden" class="form-control" name="tgl_realisasi" />
                            <input type="hidden" class="form-control" name="nilai" />
                            <input type="hidden" class="form-control" name="keterangan" />
                            <input type="hidden" class="form-control" name="file" />
                            <br>

                        </div>

                        <!--END FORM BUAT PEKERJAAN-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deletekerja" tabindex="-1" aria-labelledby="modaldeleteBarang" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Hapus Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Kamu Yakin Ingin Menghapus ?</p>
                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ route('delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="task_id" id="inputIdDelete">


                        <!--END FORM BUAT PEKERJAAN-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn light btn-bahaya">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Penilaian -->
    <div class="modal fade" id="penilaiankerja" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Penilaian Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('penilaian') }}" method="post">
                        @csrf
                        <div class="container">
                            <div class="form-group col">
                                <input type="hidden" class="form-control" id="inputidnmr" name="task_id">
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="inputOrang">Nama Pegawai</label>
                                    <input type="text" class="form-control" id="inputOrang" name="Pegawai" disabled>
                                </div>

                                <div class="form-group col">
                                    <label for="inputTugas">Tugas</label>
                                    <input type="text" class="form-control" id="inputTugas" name="" disabled>
                                </div>

                                <div class="form-group col">
                                    <label for="inputTim">Asal</label>
                                    <input type="text" class="form-control" id="inputTim" name="" disabled>
                                </div>
                            </div>

                            <div class="form-group col">
                                <br>
                                <label for="inputTim">Hasil Penugasan</label>
                                <div class="col dokumen"></div>
                            </div>
                            <div class="form-group col">
                                <label for="inputnilai">Beri Nilai Kuantitas<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputnilaikuantitas"
                                    name="nilai_kuantitas" required>
                            </div>
                            <div class="form-group col">
                                <label for="inputnilai">Beri Nilai Kualitas<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputnilaikualitas" name="nilai_kualitas"
                                    required>
                            </div>
                            <br>

                        </div>

                        <!--END FORM BUAT PEKERJAAN-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom">Submit</button>
                    </form>
                    <form action="{{ Route('kembalikan') }}" method="post">
                        @csrf
                        <div class="form-group col">
                            <input type="hidden" class="form-control" id="inputugas_id" name="task_id">
                            {{-- <input type="hidden" class="form-control" id="inputfile_id" name="file_id"> --}}
                        </div>
                        <button type="submit" class="btn btn-custom">Kembalikan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Cetak CKP -->
    <div class="modal fade" id="ckpkerja" tabindex="-1" aria-labelledby="modalcetakckp" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Cetak CKP Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <div class="form-group col">
                        <input type="hidden" class="form-control" id="inputIdcetak" name="id">
                    </div> --}}
                    <form>
                        <div class="form-group">
                            <label for="inputPegawai">Nama Pegawai</label>
                            <div>

                                <select name="pegawai_id" class="selectpicker form-control" data-live-search="true"
                                    id="inputcetakpegawai_id">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($pegawai as $pegawaibps)
                                        <option value="{{ $pegawaibps->id }}">{{ $pegawaibps->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        <button type="submit" name="action" class="btn btn-primary" formaction="/admin/ckp-r">CETAK
                            CKP-R</button>
                        <button type="submit" name="action" class="btn btn-primary" formaction="/admin/ckp-t">CETAK
                            CKP-T</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal Import -->
    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title" id="successModalLabel">Import Alokasi Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <br>
                <div class="modal-body">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col">
                            <label>Upload Template<span class="text-danger">*</span></label>
                            <input type="file" name="file" accept=".xlsx, .xls" class="form-control">
                        </div>
                        <br>
                        <Strong>Template Alokasi Pekerjaan:</Strong>
                        <a href="{{ asset('template_plotting/Template.xlsx') }}" download="Template.xlsx"
                            class="btn btn-link">
                            <i class="fas fa-download" style="color: green;"></i>
                        </a>
                        <br>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="form-group col px-1">
                            <button type="submit" class="btn btn-primary">Impor</button>
                        </div>
                        <div class="form-group col px-0">
                            <button type="button" class="btn light btn-bahaya" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Menampilkan modal berhasil simpan update -->
    @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Sukses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @elseif(session('failed'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Warning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            @foreach (session('failed') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('importErrors'))
        <div class="alert alert-danger">
            <ul>
                @foreach (session('importErrors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    @if (session('success'))
        <script>
            $(document).ready(function() {
                $('#successModal .modal-header').addClass('success');
                $('#successModal').modal('show');
            });
        </script>
    @elseif(session('failed'))
        <script>
            $(document).ready(function() {
                $('#successModal .modal-header').addClass('failure');
                $('#successModal').modal('show');
            });
        </script>
    @endif


    <script>
        $("#ckpt").click(function() {
            $.ajax({
                url: "/admin/ckp-t",
                type: "get", //send it through get method
                data: {

                },
                success: function(response) {
                    //Do Something
                },
                error: function(xhr) {
                    //Do Something to handle error
                }
            });
        });

        $(document).ready(function() {
            $('#inputTaskk').change(function() {
                const selectedOption = $(this).find(':selected');
                const selectedSatuan = selectedOption.data('satuan');
                const selectedBobot = selectedOption.data('bobot');

                $('#inputSatuann').val(selectedSatuan);
                $('#inputBobott').val(selectedBobot);
            });
        });

        $(document).ready(function() {
            $('#inputTask').change(function() {
                const selectedOptionn = $(this).find(':selected');
                const selectedSatuann = selectedOptionn.data('satuan');
                const selectedBobott = selectedOptionn.data('bobot');

                $('#inputsatuan').val(selectedSatuann);
                $('#inputbobot').val(selectedBobott);
            });
        });


        $(".fa-square-pen").click(function() {
            let key = $(this).attr('data');
            let id = $(`#id${key}`).val();
            let pegawai_id = $(`#pegawai_id${key}`).val();
            let jenistask_id = $(`#jenistask_id${key}`).val();
            let pegawai = $(`#Pegawai${key}`).text();
            let nama = $(`#Nama${key}`).text();
            let asal = $(`#Asal${key}`).text();
            let target = $(`#Target${key}`).text();
            let realisasi = $(`#Realisasi${key}`).text();
            let satuan = $(`#Satuan${key}`).text();
            let bobot = $(`#Bobot${key}`).text();
            let catatan = $(`#Catatan${key}`).text();
            let deadline = $(`#Deadline${key}`).data('value');

            $('#inputId').val(id);
            $('#inputPegawai').val(pegawai_id);
            $('#inputpegawai_id').val(pegawai_id);
            $('#inputTask').val(jenistask_id);
            $('#inputAsal').val(asal);
            $('#inputbobot').val(bobot);
            $('#inputTarget').val(target);
            $('#inputRealisasi').val(realisasi);
            $('#inputsatuan').val(satuan);
            $('#inputDeadline').val(deadline);
            $('#inputCatatan').val(catatan);
        });

        $(".hapus").click(function() {
            let key = $(this).attr('data');
            let id = $(`#id${key}`).val();
            $('#inputIdDelete').val(id);
        });

        // $("#cetak").click(function() {
        //     let key = $(this).attr('data');
        //     let id = $(`#id${key}`).val();
        //     let pegawai_id = $(`#pegawai_id${key}`).val();
        //     $('#inputIdcetak').val(id);
        //     $('#inputcetakpegawai_id').val(id);
        // });

        $(".fa-check-circle").click(function() {
            let keyy = $(this).attr('data');
            let idd = $(`#id${keyy}`).val();
            let iddd = $(`#tugas_id${keyy}`).val();
            // let file_idd = $(`#file_idd${keyy}`).val();
            let pegawai_idd = $(`#pegawai_id${keyy}`).val();
            let pegawaii = $(`#Pegawai${keyy}`).text();
            let namaa = $(`#Nama${keyy}`).text();
            let asall = $(`#Asal${keyy}`).text();
            let file = $(`#file${keyy}`).val();

            $('#inputidnmr').val(idd);
            $('#inputugas_id').val(iddd);
            // $('#inputfile_id').val(file_idd);
            $('#inputOrang').val(pegawaii);
            $('#inputpegawaiidnmr').val(pegawai_idd);
            $('#inputTugas').val(namaa);
            $('#inputTim').val(asall);
            // $('.dokumen').html(
            //     `<a class ='unduh' href='${file}'><button class='btn light btn-download'type='button'><i class="bi bi-eye"></i> Lihat</button></a>`

            // );
        });
    </script>

    <script>
        // Fungsi untuk membuka modal dan mengisi dengan konten yang sesuai
        function openModalWithFile(task) {
            let dokumenContainer = $('.dokumen');
            dokumenContainer.empty(); // Kosongkan konten sebelumnya

            if (task.link_file) {
                dokumenContainer.append(`
                <a class='unduh' href='${task.link_file}' target='_blank'>
                    <button class='btn light btn-download' type='button'>
                        <i class="bi bi-eye"></i> Lihat Link
                    </button>
                </a>
            `);
            }

            if (task.files && task.files.length > 0) {
                task.files.forEach(file => {
                    dokumenContainer.append(`
                    <a class='unduh' href='/file/${file.file_name}' target='_blank'>
                        <button class='btn light btn-download' type='button'>
                            <i class="bi bi-eye"></i> Lihat File
                        </button>
                    </a>
                `);
                });
            }

            $('#penilaiankerja').modal('show');
        }

        // Event listener untuk tombol "Lihat"
        $(document).ready(function() {
            $('.lihat-dokumen-btn').on('click', function(e) {
                e.preventDefault(); // Ini untuk mencegah tautan default
                var taskData = $(this).data('task');
                openModalWithFile(taskData);
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            // Panggil Select2 pada elemen dropdown dengan id "inputTaskk"
            $('#inputTaskk').select2({
                placeholder: 'Pilih Tugas', // Teks placeholder untuk input pencarian
                allowClear: true, // Menampilkan tombol "Hapus" untuk menghapus pilihan
                width: '100%', // Lebar dropdown
                dropdownParent: $('#tambahkerja')
            });

            // Event listener untuk mengisi input bobot saat memilih jenis pekerjaan
            $('#inputTaskk').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var bobot = selectedOption.attr('data-bobot');
                $('#inputBobot').val(bobot);
            });

            // Event listener untuk mengisi input satuan saat memilih jenis pekerjaan
            $('#inputTaskk').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var satuan = selectedOption.attr('data-satuan');
                $('#inputSatuan').val(satuan);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Panggil Select2 pada elemen dropdown dengan id "inputTaskk"
            $('#inputTask').select2({
                allowClear: true, // Menampilkan tombol "Hapus" untuk menghapus pilihan
                width: '100%', // Lebar dropdown
                dropdownParent: $('#updatekerja')
            });

            // Event listener untuk mengisi input bobot saat memilih jenis pekerjaan
            $('#inputTask').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var bobot = selectedOption.attr('data-bobot');
                $('#inputbobot').val(bobot);
            });

            // Event listener untuk mengisi input satuan saat memilih jenis pekerjaan
            $('#inputTask').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var satuan = selectedOption.attr('data-satuan');
                $('#inputsatuan').val(satuan);
            });
        });
    </script>

    <!-- mengisi otomatis field asal tim -->
    <script>
        $(document).ready(function() {
            var timYangLogin =
                "{{ Auth::check() && Auth::user()->JenisJabatan && Auth::user()->JenisJabatan->NamaTim ? Auth::user()->JenisJabatan->NamaTim->tim : '' }}";
            console.log(timYangLogin);
            $("#inputAsall").val(timYangLogin).selectpicker('refresh');
        });
    </script>

    {{-- <script>
        document.getElementById("inputTaskk").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var bobot = selectedOption.getAttribute("data-bobot");
            document.getElementById("inputBobot").value = bobot;
        });
    </script>

    <script>
        document.getElementById("inputTaskk").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var satuan = selectedOption.getAttribute("data-satuan");
            document.getElementById("inputSatuan").value = satuan;
        });
    </script> --}}


    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>

    <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">


    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/fixedColumns.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">


    {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> --}}


    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}

    {{--
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
    <script src=" https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src=" https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script> --}}

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href=" https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css"> --}}
@endsection
