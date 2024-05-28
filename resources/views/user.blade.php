@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- <a href="/user/ckp-r" class="btn btn-primary mb-3" target="_blank">CETAK CKP-R</a> --}}
        @php
            $selectedYear = request('year', null);
            $selectedMonth = request('month', null);
        @endphp

        <div class="row">
            <div class="col-sm-auto align-self-center">
                <h5>Halaman Pekerjaan</h5>
            </div>
            <div class="col align-self-center border-top border-primary d-none d-sm-block"></div>
            <div class="col-sm-auto align-self-center ml-auto">

                <form method="post" action="{{ url('/simanja/pekerjaan') }}" class="form-inline">
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
        {{-- <div class="col-xxl-6 col-lg-12"> --}}
        <div class="card">
            <div class="card-header d-flex flex-between-center"
                style="background: linear-gradient(to right, #4c96db, #194d7e);">
                <h5 class="mb-0" style="color: white">Progress</h5>
            </div>
            <div class="card-body bg-white">
                <p class="fs--1 text-600">
                    @if ($persentaseSelesai < 50)
                        Tetap semangat! Meskipun kita masih di awal, tetapi usahamu sangat dihargai. Setiap
                        langkah kecil membawa kita menuju keberhasilan besar.
                    @elseif ($persentaseSelesai >= 50 && $persentaseSelesai < 80)
                        Kerja bagus! Kita sudah mencapai setengah perjalanan dan pencapaianmu luar biasa. Mari
                        pertahankan semangat ini hingga akhir!
                    @else
                        Wow, ini luar biasa! Kita hampir mencapai tujuan bersama. Keberhasilan ini tak terlepas dari
                        kerja keras dan komitmenmu. Terima kasih atas dedikasimu yang luar biasa!
                    @endif
                </p>

                <div class="progress mb-3 rounded-pill" style="height: 6px;" role="progressbar"
                    aria-valuenow="{{ $persentaseSelesai }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-progress-gradient rounded-pill" style="width: {{ $persentaseSelesai }}%">
                    </div>
                </div>

                <p class="mb-0 text-primary">{{ $persentaseSelesai }}% Terselesaikan</p>
                <p>{{ $projectCount }} Project</p>
                <p class="mb-0 fs--2 text-500" style="font-weight: bold;">Nilai pada bulan
                    {{ date('F', mktime(0, 0, 0, intval($bulan), 1)) }}</p>
                <div class="display-4 fs-4 mb-0 fw-normal font-sans-serif text-warning"
                    data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                    {{ $nilaiAkhir }}</div>
            </div>

        </div>
        {{-- </div> --}}




        <br>
        <div class="card-body bg-white">
            <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                <h4 class="card-title" style="color: white">Tabel Pekerjaan </h4>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Bulan Deadline</label>
                        <select class="form-select" id="bulandl" oninput="filter()" autocomplete="off">
                            <option>Semua</option>
                            <option value="Jan">Januari</option>
                            <option value="Feb">Februari</option>
                            <option value="Mar">Maret</option>
                            <option value="Apr">April</option>
                            <option value="May">Mei</option>
                            <option value="Jun">Juni</option>
                            <option value="Jul">Juli</option>
                            <option value="Aug">Agustus</option>
                            <option value="Sep">September</option>
                            <option value="Oct">Oktober</option>
                            <option value="Nov">November</option>
                            <option value="Dec">Desember</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Tahun Deadline</label>
                        <select class="form-select" id="tahundl" oninput="filter()" autocomplete="off">
                            <option>Semua</option>
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Bulan Realisasi</label>
                        <select class="form-select" id="bulanreal" oninput="filter()" autocomplete="off">
                            <option>Semua</option>
                            <option value="Jan">Januari</option>
                            <option value="Feb">Februari</option>
                            <option value="Mar">Maret</option>
                            <option value="Apr">April</option>
                            <option value="May">Mei</option>
                            <option value="Jun">Juni</option>
                            <option value="Jul">Juli</option>
                            <option value="Aug">Agustus</option>
                            <option value="Sep">September</option>
                            <option value="Oct">Oktober</option>
                            <option value="Nov">November</option>
                            <option value="Dec">Desember</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Tahun Realisasi</label>
                        <select class="form-select" id="tahunreal" oninput="filter()" autocomplete="off">
                            <option>Semua</option>
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="table-responsive-xl">
                    <table id="dtBasicExampleUser" class="stripe row-border order-column nowrap">
                        <thead>
                            {{-- <tr class="filters"> --}}
                            {{-- <th><input type="text" class="form-control" placeholder="No" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nama" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Asal" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Target" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Realisasi" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Satuan" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Deadline" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Tgl Realisasi" disabled></th>
                        <th><input type="text" class="form-control" placeholder="File" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nilai" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Keterangan" disabled></th> --}}
                            {{-- <thead> --}}
                            <th class="text-center">No</th>
                            <th class="text-center">Tugas</th>
                            <th class="text-center">Bobot</th>
                            <th class="text-center">Asal</th>
                            <th class="text-center">Target</th>
                            <th class="text-center">Realisasi</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Deadline</th>
                            <th class="text-center">Catatan</th>
                            <th class="text-center">Tgl Realisasi</th>
                            <th class="text-center">File</th>
                            <th class="text-center">Nilai Kualitas</th>
                            <th class="text-center">Nilai Kuantitas</th>
                            <th class="text-center">Keterangan</th>

                            {{-- </thead> --}}
                            {{-- </tr> --}}
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr>

                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td id="nama{{ $key }}" style="text-align: center">{{ $task->tugas }}</td>
                                    <script>
                                        // Mendapatkan elemen dengan id 'Nama{{ $key }}'
                                        var element = document.getElementById('nama{{ $key }}');

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
                                                id="bobot{{ $key }}">Besar</span>
                                        @elseif ($task->bobot == 'Sedang')
                                            <span class="badge  rounded-pill text-bg-warning text-white"
                                                id="bobot{{ $key }}">Sedang</span>
                                        @elseif ($task->bobot == 'Kecil')
                                            <span class="badge rounded-pill text-bg-success text-white"
                                                id="bobot{{ $key }}">Kecil</span>
                                        @else
                                            {{ $task->bobot }}
                                        @endif
                                    </td>
                                    <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                                    <td class="text-left" id="tim{{ $key }}">{{ $task->tim }}</td>
                                    <script>
                                        // Mendapatkan elemen dengan id 'Nama{{ $key }}'
                                        var element = document.getElementById('tim{{ $key }}');

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
                                    <td id="target{{ $key }}" style="text-align: center">{{ $task->target }}
                                    </td>
                                    <td style="text-align: center">
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
                                        <div id="realisasi{{ $key }}"></div>
                                        @php
                                            // Mendapatkan tanggal saat ini dalam format Y-m-d
                                            $tanggalSekarang = date('Y-m-d');

                                            // Mendapatkan tanggal deadline
                                            $tanggalDeadline = $task->deadline;

                                            // Mendapatkan tanggal terakhir bulan
                                            $bulanSekarang = date('n', strtotime($tanggalDeadline));
                                            $tanggalTerakhirBulan = date('d', strtotime($tanggalDeadline));

                                            // Ambil tahun saat ini
                                            $tahunSekarang = date('Y');

                                            // Tentukan apakah tahun saat ini adalah tahun kabisat atau bukan
                                            $adalahTahunKabisat =
                                                $tahunSekarang % 4 == 0 &&
                                                ($tahunSekarang % 100 != 0 || $tahunSekarang % 400 == 0);

                                            // Mendapatkan tanggal deadline + 3 hari jika tanggal deadline adalah 30 atau 31, jika tidak, maka tidak ditambah
                                            if (
                                                $tanggalTerakhirBulan == 30 ||
                                                $tanggalTerakhirBulan == 31 ||
                                                ($tanggalTerakhirBulan == 29 && $adalahTahunKabisat) ||
                                                ($bulanSekarang == 2 && $tanggalTerakhirBulan == 28)
                                            ) {
                                                $tanggalDeadlinePlus3Hari = date(
                                                    'Y-m-d',
                                                    strtotime($tanggalDeadline . ' + 3 days'),
                                                );
                                            } else {
                                                $tanggalDeadlinePlus3Hari = $tanggalDeadline;
                                                // Mendapatkan hari dalam sebulan
                                                $hariDalamSebulan = date('j', strtotime($tanggalDeadlinePlus3Hari));
                                            }
                                        @endphp

                                        @if ($tanggalSekarang <= $tanggalDeadlinePlus3Hari)
                                            <i data="{{ $key }}" data-id="{{ $task->task_id }}"
                                                class="fa-solid fa-square-plus" role="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"></i>
                                        @elseif ($hariDalamSebulan <= 27)
                                            <i data="{{ $key }}" data-id="{{ $task->task_id }}"
                                                class="fa-solid fa-square-plus" role="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"></i>
                                        @else
                                            <div></div>
                                        @endif

                                    </td>
                                    <td style="text-align: center" id="satuan{{ $key }}">{{ $task->satuan }}
                                    </td>
                                    <td style="text-align: center">{{ date('d M Y', strtotime($task->deadline)) }}</td>
                                    <td class="text-justify">
                                        <!-- Tombol "Lihat" hanya muncul jika ada catatan -->
                                        @if ($task->catatan)
                                            <button class="btn btn-custom" data-bs-toggle="modal"
                                                data-bs-target="#modalCatatan{{ $key }}"><i
                                                    class="bi bi-eye"></i> Lihat</button>
                                        @endif
                                    </td>
                                    @if ($task->tgl_realisasi != null)
                                        <td class="text-center tgr">
                                            {{ (new DateTime($task->tgl_realisasi))->format('d M Y') }}</td>
                                    @else
                                        <td class="text-center tgr"></td>
                                    @endif
                                    <td class="text-center">
                                        @if ($task->link_file)
                                            <a href="{{ $task->link_file }}" target="_blank" class="text-center">
                                                <button class="btn light btn-download text-center" type="button">
                                                    <i class="bi bi-eye"></i> Lihat Link
                                                </button>
                                            </a>
                                        @elseif ($task->files()->count() > 0)
                                            <form
                                                action="{{ route('tasks.download', ['fileId' => $task->files->pluck('file_id')->implode(',')]) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn light btn-download text-center" type="submit">
                                                    <i class="bi bi-download"></i> Download File
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge light badge-dark">Belum Upload Pekerjaan</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">{{ $task->nilai_kualitas }}</td>
                                    <td style="text-align: center">{{ $task->nilai_kuantitas }}</td>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Pekerjaan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="uploadform" action="{{ route('updateUser') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                {{-- <label for="idtask" class="form-label">ID Kegiatan</label> --}}
                                <input type="hidden" class="form-control" id="idtask" name="idtask" disabled>
                            </div>
                            <input type="hidden" class="form-control" id="idhidden" name="idhidden">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="target" class="form-label">Target</label>
                                <input type="text" class="form-control" id="target" name="target" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="target" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="realisasi" class="form-label">Realisasi<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="realisasi" name="realisasi" required>
                            </div>
                            {{-- <div class="mb-3">
                                        <label for="realisasi" class="form-label">Tanggal Realisasi</label>
                                        <input type="date" class="form-control" id="tgl_realisasi" name="tgl_realisasi">
                                    </div> --}}

                            <!-- Validasi -->
                            <small id="targetValidationMessage" class="text-danger"></small>
                            <!-- Validasi -->
                            <script>
                                // Tangkap form
                                var form = document.getElementById("uploadform");

                                // Tambahkan event listener untuk peristiwa submit
                                form.addEventListener("submit", function(event) {
                                    // Dapatkan nilai input target
                                    var inputValue = document.getElementById("realisasi").value;

                                    // Gunakan ekspresi reguler untuk memeriksa apakah hanya berisi bilangan bulat atau desimal dengan titik
                                    var regex = /^[0-9,.]+$/;

                                    // Validasi input
                                    if (!regex.test(inputValue)) {
                                        // Tampilkan pesan validasi
                                        document.getElementById("targetValidationMessage").innerText =
                                            "Input harus berupa bilangan bulat atau desimal,huruf tidak diperbolehkan.";

                                        // Set fokus ke input target
                                        document.getElementById("realisasi").focus();

                                        // Mencegah pengiriman formulir jika validasi gagal
                                        event.preventDefault();
                                    } else {
                                        // Bersihkan pesan validasi jika input valid
                                        document.getElementById("targetValidationMessage").innerText = "";
                                    }
                                });
                            </script>
                            {{-- <div class="mb-3">
                                    <label for="tgl_realisasi" class="form-label">Tanggal Realisasi</label>
                                    <input type="text" class="form-control" id="tgl_realisasi" name="tgl_realisasi" disabled>
                                    </div> --}}
                            <div class="mb-3">
                                <label for="update" class="form-label">Tanggal Realisasi<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_realisasi" name="update" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Metode Unggahan<span class="text-danger">*</span></label>
                                <select class="form-control" id="uploadMethod" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="file">Upload File</option>
                                    <option value="link">Masukkan Link</option>
                                </select>
                            </div>

                            <!-- File Upload Section -->
                            <div id="fileUpload" class="mb-3 custom-file" style="display: none;">
                                <label class="form-label" for="file">Upload Bukti<span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="file" name="file[]" multiple>

                                <!-- Selected Files Section -->
                                <div class="selected-files">
                                    <strong>Selected Files:</strong>
                                    <div id="file-list" class="list-group mt-2"></div>
                                </div>

                                <button type="button" class="btn btn-info mt-3 d-none" id="add-file-btn">
                                    <i class="fas fa-plus"></i> Add Another File
                                </button>
                            </div>

                            <!-- Link Upload Section -->
                            <div id="linkUpload" class="mb-3" style="display: none;">
                                <label class="form-label" for="link_file">Link Bukti<span
                                        class="text-danger">*</span></label>
                                <input type="url" class="form-control" id="link_file" name="link_file">
                            </div>

                            <script>
                                document.getElementById('uploadMethod').addEventListener('change', function() {
                                    var method = this.value;
                                    var fileUpload = document.getElementById('fileUpload');
                                    var linkUpload = document.getElementById('linkUpload');
                                    var fileInput = document.getElementById('file');
                                    var linkInput = document.getElementById('link_file');

                                    if (method === 'file') {
                                        fileUpload.style.display = 'block';
                                        linkUpload.style.display = 'none';
                                        fileInput.required = true;
                                        linkInput.required = false;
                                    } else if (method === 'link') {
                                        fileUpload.style.display = 'none';
                                        linkUpload.style.display = 'block';
                                        fileInput.required = false;
                                        linkInput.required = true;
                                    } else {
                                        fileUpload.style.display = 'none';
                                        linkUpload.style.display = 'none';
                                        fileInput.required = false;
                                        linkInput.required = false;
                                    }
                                });

                                // Inisialisasi
                                var input = document.getElementById('file');
                                var addFileBtn = document.getElementById('add-file-btn');
                                var fileListContainer = document.getElementById('file-list');

                                // Fungsi untuk menambahkan file ke daftar
                                function addFileToList(file) {
                                    var fileItem = document.createElement('div');
                                    fileItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                                    var fileName = document.createElement('span');
                                    fileName.textContent = file.name;

                                    var removeButton = document.createElement('button');
                                    removeButton.textContent = 'Remove';
                                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm');
                                    removeButton.addEventListener('click', function() {
                                        // Hapus elemen file dari tampilan
                                        fileListContainer.removeChild(fileItem);

                                        // Hapus file dari daftar files
                                        var files = Array.from(input.files);
                                        var index = files.indexOf(file);
                                        if (index !== -1) {
                                            files.splice(index, 1);
                                            input.files = new FileListWrapper(files, input);
                                        }

                                        // Periksa jumlah file dan tampilkan/sembunyikan tombol "Add Another File"
                                        toggleAddFileButton();
                                    });

                                    fileItem.appendChild(fileName);
                                    fileItem.appendChild(removeButton);
                                    fileListContainer.appendChild(fileItem);

                                    // Periksa jumlah file dan tampilkan/sembunyikan tombol "Add Another File"
                                    toggleAddFileButton();

                                    // Sembunyikan input file setelah satu file ditambahkan
                                    input.classList.add('d-none');
                                }

                                // Tambahkan event listener ke tombol "Add Another File"
                                addFileBtn.addEventListener('click', function() {
                                    // Buka jendela pilih file
                                    input.click();
                                });

                                // Event listener untuk meng-handle pemilihan file
                                input.addEventListener('change', function(e) {
                                    var newFiles = e.target.files;

                                    // Iterasi melalui file yang baru dipilih dan tambahkan ke daftar
                                    for (var i = 0; i < newFiles.length; i++) {
                                        addFileToList(newFiles[i]);
                                    }
                                });

                                // Helper class untuk membuat FileList baru
                                function FileListWrapper(items, input) {
                                    var dataTransfer = new DataTransfer();
                                    items.forEach(function(item) {
                                        dataTransfer.items.add(item);
                                    });
                                    return dataTransfer.files;
                                }

                                // Periksa jumlah file dan tampilkan/sembunyikan tombol "Add Another File"
                                function toggleAddFileButton() {
                                    addFileBtn.classList.toggle('d-none', input.files.length === 0);
                                }
                            </script>

                            {{-- <div class="mb-3">
                                        <label for="file" class="form-label">Upload Hasil Kegiatan</label><br>
                                        <input type="file" class="form-control" id="file" name="file[]" required
                                            multiple>
                                    </div> --}}

                            {{-- <div class="mb-3 custom-file">
                                <label class="form-label" for="file">Upload Bukti<span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="file" name="file[]" required
                                    multiple>
                            </div> --}}

                            {{-- <div class="mb-3 custom-file">
                                <label class="form-label" for="file">Upload Bukti<span
                                        class="text-danger">*</span></label>
                                <input type="url" class="form-control" id="file" name="link_file" required>
                            </div> --}}

                            {{-- <div class="selected-files">
                                <strong>Selected Files:</strong>
                                <div id="file-list" class="list-group mt-2"></div>
                            </div>

                            <button type="button" class="btn btn-info mt-3 d-none" id="add-file-btn">
                                <i class="fas fa-plus"></i> Add Another File
                            </button>
                            <br>
                            <script>
                                // Inisialisasi
                                var input = document.getElementById('file');
                                var addFileBtn = document.getElementById('add-file-btn');
                                var fileListContainer = document.getElementById('file-list');

                                // Fungsi untuk menambahkan file ke daftar
                                function addFileToList(file) {
                                    var fileItem = document.createElement('div');
                                    fileItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                                    var fileName = document.createElement('span');
                                    fileName.textContent = file.name;

                                    var removeButton = document.createElement('button');
                                    removeButton.textContent = 'Remove';
                                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm');
                                    removeButton.addEventListener('click', function() {
                                        // Hapus elemen file dari tampilan
                                        fileListContainer.removeChild(fileItem);

                                        // Hapus file dari daftar files
                                        var files = Array.from(input.files);
                                        var index = files.indexOf(file);
                                        if (index !== -1) {
                                            files.splice(index, 1);
                                            input.files = new FileListWrapper(files, input);
                                        }

                                        // Periksa jumlah file dan tampilkan/sembunyikan tombol "Add Another File"
                                        toggleAddFileButton();
                                    });

                                    fileItem.appendChild(fileName);
                                    fileItem.appendChild(removeButton);
                                    fileListContainer.appendChild(fileItem);

                                    // Periksa jumlah file dan tampilkan/sembunyikan tombol "Add Another File"
                                    toggleAddFileButton();

                                    // Sembunyikan input file setelah satu file ditambahkan
                                    input.classList.add('d-none');
                                }

                                // Tambahkan event listener ke tombol "Add Another File"
                                addFileBtn.addEventListener('click', function() {
                                    // Buka jendela pilih file
                                    input.click();
                                });

                                // Event listener untuk meng-handle pemilihan file
                                input.addEventListener('change', function(e) {
                                    var newFiles = e.target.files;

                                    // Iterasi melalui file yang baru dipilih dan tambahkan ke daftar
                                    for (var i = 0; i < newFiles.length; i++) {
                                        addFileToList(newFiles[i]);
                                    }
                                });

                                // Helper class untuk membuat FileList baru
                                function FileListWrapper(items, input) {
                                    var dataTransfer = new DataTransfer();
                                    items.forEach(function(item) {
                                        dataTransfer.items.add(item);
                                    });
                                    return new FileList(dataTransfer.files, input);
                                }

                                // Periksa jumlah file dan tampilkan/sembunyikan tombol "Add Another File"
                                function toggleAddFileButton() {
                                    addFileBtn.classList.toggle('d-none', input.files.length === 0);
                                }
                            </script> --}}
                            <br>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Menampilkan modal berhasil simpan update -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Sukses</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ session('status') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('status'))
            <script>
                $(document).ready(function() {
                    $('#successModal .modal-header').addClass('success');
                    $('#successModal').modal('show');
                });
            </script>
        @endif

        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
        <script>
            $(".fa-square-plus").click(function() {
                let key = $(this).attr('data');
                let id = $(`#id${key}`).val();
                let nama = $(`#nama${key}`).text();
                let target = $(`#target${key}`).text();
                let satuan = $(`#satuan${key}`).text();
                let realisasi = $(`#realisasi${key}`).text();

                // Mendapatkan tanggal saat ini dalam format "YYYY-MM-DD"
                let currentDate = new Date().toISOString().slice(0, 10);

                $('#idtask').val(id);
                $('#idhidden').val(id);
                $('#nama').val(nama);
                $('#target').val(target);
                $('#satuan').val(satuan);
                $('#realisasi').val(realisasi);

                // Mengisi tanggal realisasi dengan tanggal saat ini
                $('#tgl_realisasi').val(currentDate);
            });


            function filter() {
                let dropdownbulanreal, table, rows, cells,
                    dl, real, filterbulanreal, dropdowntahunreal, filtertahunreal,
                    dropdownbulandl, dropdowntahundl, filterbulandl, filtertahundl;
                dropdownbulanreal = $('#bulanreal');
                dropdowntahunreal = $('#tahunreal');
                dropdownbulandl = $('#bulandl');
                dropdowntahundl = $('#tahundl');
                table = document.getElementById("dtBasicExample");
                rows = table.getElementsByTagName("tr");
                filterbulanreal = dropdownbulanreal.val();
                filtertahunreal = dropdowntahunreal.val();
                filterbulandl = dropdownbulandl.val();
                filtertahundl = dropdowntahundl.val();
                for (let row of rows) {
                    cells = row.getElementsByTagName("td");
                    console.log(cells);
                    dl = cells[7] || null;
                    real = cells[8] || null;
                    if (
                        (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === "Semua" &&
                            filtertahundl === "Semua") ||
                        !dl ||
                        (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === "Semua" &&
                            filtertahundl === dl.textContent.substring(7, 11)) ||
                        (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === dl.textContent
                            .substring(3, 6) && filtertahundl === "Semua") ||
                        (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === dl.textContent
                            .substring(3, 6) && filtertahundl === dl.textContent.substring(7, 11)) ||
                        (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
                            filterbulandl === "Semua" && filtertahundl === "Semua") ||
                        (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
                            filterbulandl === "Semua" && filtertahundl === dl.textContent.substring(7, 11)) ||
                        (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
                            filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === "Semua") ||
                        (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
                            filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === dl.textContent.substring(7,
                                11)) ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
                            filterbulandl === "Semua" && filtertahundl === "Semua") ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
                            filterbulandl === "Semua" && filtertahundl === dl.textContent.substring(7, 11)) ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
                            filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === "Semua") ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
                            filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === dl.textContent.substring(7,
                                11)) ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
                            7, 11) && filterbulandl === "Semua" && filtertahundl === "Semua") ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
                            7, 11) && filterbulandl === "Semua" && filtertahundl === dl.textContent.substring(7, 11)) ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
                            7, 11) && filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === "Semua") ||
                        (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
                                7, 11) && filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === dl.textContent
                            .substring(7, 11))
                    ) {
                        row.style.display = ""; // shows this row
                    } else {
                        row.style.display = "none"; // hides this row
                    }
                }
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>

        <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">

        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/fixedColumns.dataTables.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    @endsection
