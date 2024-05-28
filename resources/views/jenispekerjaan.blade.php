@extends('layouts.app')

@section('content')
    <div class="container">

        <br>
        {{-- <div class="card-body bg-white">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Bulan Deadline</label>
                        <select class="form-select" id="bulandl" oninput="filter()">
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
                        <select class="form-select" id="tahundl" oninput="filter()">
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
                        <select class="form-select" id="bulanreal" oninput="filter()">
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
                        <select class="form-select" id="tahunreal" oninput="filter()">
                            <option>Semua</option>
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                        </select>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="d-grid gap-2 d-md-block">
            <button type="button" class="btn btn-primary btn-floating">
                <a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#ckpkerja" id="cetak"
                    style="color: #ffffff"><i class="fas fa-download"></i></a>
            </button>
        </div> --}}
        <br>

        <!-- tabel jenis pekerjaan -->
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Jenis Pekerjaan</h4>
                </div>
                <br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                    {{-- <a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#tambahtask"
                        style="color: #ffffff"><button type="button" class="btn btn-primary btn-floating"><i
                                class="fas fa-square-pen">
                                Tambah Jenis Pekerjaan</i></button></a> --}}
                    <a class="btn btn-custom" href="#" data-bs-toggle="modal" data-bs-target="#tambahtask"><i
                            class="bi bi-pencil-square"></i> Tambah Jenis Pekerjaan</a>
                    <a href="/export_excel_jp" class="btn btn-custom" target="_blank"><i
                            class="bi bi-box-arrow-right"></i>Export</a>
                    <a class="btn btn-custom" href="#" data-bs-toggle="modal" data-bs-target="#import"
                        id="cetak"><i class="bi bi-box-arrow-in-right"></i> Import</a>
                </div>

                <br>
                <div class="table-responsive-xl">
                    <table id="examplejt" class="stripe row-border order-column nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Jenis Pekerjaan</th>
                                <th class="text-center">Satuan</th>
                                {{-- <th class="text-center">ID Pegawai</th> --}}
                                <th class="text-center">Bobot</th>
                                <th class="text-center">Pemberi Pekerjaan</th>
                                <th class="text-center">Aksi</th>
                                {{-- <th class="d-none"></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis_tugas as $key => $jt)
                                <tr>
                                    <input id="no{{ $key }}" type="hidden" value="{{ $jt->no }}">
                                    <input id="tim_id{{ $key }}" type="hidden" value="{{ $jt->tim_id }}">
                                    {{-- <td id="Password{{ $key }}" class="d-none">{{ $jt->password }}</td> --}}
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td id="tugas{{ $key }}">{{ $jt->tugas }}</td>
                                    <td class="text-center" id="satuan{{ $key }}">{{ $jt->satuan }}</td>
                                    {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                                    <td class="text-center" id="bobot{{ $key }}">{{ $jt->bobot }}</td>
                                    <td class="text-center" id="asal_tim{{ $key }}">{{ $jt->tim }}</td>
                                    {{-- <td class="text-center" id="Role{{ $key }}">{{ $user->role }}</td> --}}

                                    <td class="text-center">
                                        <a href="#" class="edit" data-bs-toggle="modal"><i class="fas fa-square-pen"
                                                data-bs-toggle="modal" title="Edit"
                                                style="color: orange; font-size: 20px;" data-bs-target="#updatejt"
                                                data="{{ $key }}" data-id="{{ $jt->no }}"
                                                role="button"></i></a>
                                        {{-- <form class="delete-form" action="{{ route('delete') }}" method="POST"> --}}
                                        <a href="#" class="delete" data-bs-toggle="modal"><i
                                                class="fas fa-trash hapus" title="Delete"
                                                style="color: red; font-size: 20px;" data-id="{{ $jt->no }}"
                                                data-bs-target="#deletejt" data="{{ $key }}"
                                                data-bs-toggle="modal"></i></a>
                                        {{-- </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Insert task-->
    <div class="modal fade" id="tambahtask" tabindex="-1" aria-labelledby="modalTambahTask" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Buat Jenis Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('storeJT') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <label for="inputUser">Nama Tugas</label>
                                        <input type="text" class="form-control" id="inputTugas" name="tugas" required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputUser">Bobot</label>
                                        <input type="text" class="form-control" id="inputBobot" name="bobot" required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputUser">Pilih Satuan <i id="iconPlus"
                                                class="bi bi-plus-circle-fill"></i></label>

                                        <select name="satuan" id="inputSatuan" class="selectpicker form-control"
                                            data-live-search="true" required>
                                            <option>Pilih Satuan</option>
                                            @foreach ($satuan as $item)
                                                <option value="{{ $item->satuan }}">{{ $item->satuan }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control" id="inputSatuanInput"
                                            style="display: none;">
                                    </div>

                                    <script>
                                        // Ketika ikon plus diklik
                                        document.getElementById('iconPlus').addEventListener('click', function() {
                                            var selectElement = document.getElementById('inputSatuan');
                                            var inputElement = document.getElementById('inputSatuanInput');

                                            // Jika elemen select aktif
                                            if (selectElement.style.display !== 'none') {
                                                // Sembunyikan elemen select dan hapus name
                                                selectElement.style.display = 'none';
                                                selectElement.removeAttribute('name');
                                                selectElement.removeAttribute('required'); // Hapus atribut required
                                                // Tampilkan elemen input dan tambahkan name
                                                inputElement.style.display = 'block';
                                                inputElement.setAttribute('name', 'satuan');
                                                inputElement.setAttribute('required', 'required');
                                            } else { // Jika elemen input aktif
                                                // Sembunyikan elemen input dan hapus name
                                                inputElement.style.display = 'none';
                                                inputElement.removeAttribute('name');
                                                inputElement.removeAttribute('required');
                                                // Tampilkan elemen select dan tambahkan name
                                                selectElement.style.display = 'block';
                                                selectElement.setAttribute('name', 'satuan');
                                                selectElement.setAttribute('required', 'required'); // Tambahkan kembali atribut required
                                            }
                                        });

                                        // Ketika input satuan berubah
                                        document.getElementById('inputSatuanInput').addEventListener('input', function() {
                                            // Lakukan sesuatu dengan nilai input yang dimasukkan
                                        });
                                    </script>

                                    <div class="form-group">
                                        <label for="inputAsal">Tim Pemberi Tugas</label>
                                        <div>
                                            <select name="tim_id" class="selectpicker form-control"
                                                data-live-search="true" id="inputAsall_tim">
                                                <option>Pilih Tim</option>

                                                @foreach ($jenis_tim as $jtim)
                                                    <option value="{{ $jtim->kode }}">
                                                        {{ $jtim->tim }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group col">
                                <label>ID Pegawai</label>
                                <input type="text" class="form-control" id="inputpegawai_idd" name="pegawai_id">
                            </div> --}}

                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update JT -->
    <div class="modal fade" id="updatejt" tabindex="-1" aria-labelledby="modalUpdatetugas" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Update Jenis Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('updateJT') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    {{-- <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputId" name="id">
                                    </div> --}}
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputno" name="no">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputtugas">Jenis Pekerjaan</label>
                                        <input type="text" class="form-control" id="inputtugass" name="tugas"
                                            required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputbobot">Bobot</label>
                                        <input type="text" class="form-control" id="inputbobott" name="bobot"
                                            required>
                                    </div>
                                    {{-- <div class="form-group col">
                                        <label for="inputsatuan">Satuan</label>
                                        <input type="text" class="form-control" id="inputsatuann" name="satuan"
                                            required>
                                    </div> --}}
                                    <div class="form-group col">
                                        <label for="inputUser">Pilih Satuan <i id="iconPluss"
                                                class="bi bi-plus-circle-fill"></i></label>

                                        <select name="satuan" id="inputsatuann" class="selectpicker form-control"
                                            data-live-search="true" required>
                                            <option>Pilih Satuan</option>
                                            @foreach ($satuan as $item)
                                                <option value="{{ $item->satuan }}">{{ $item->satuan }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control" id="inputSatuannInput"
                                            style="display: none;">
                                    </div>
                                    <script>
                                        // Ketika ikon plus diklik
                                        document.getElementById('iconPluss').addEventListener('click', function() {
                                            var selectElements = document.getElementById('inputsatuann');
                                            var inputElements = document.getElementById('inputSatuannInput');

                                            // Jika elemen select aktif
                                            if (selectElements.style.display !== 'none') {
                                                // Sembunyikan elemen select dan hapus name
                                                selectElements.style.display = 'none';
                                                selectElements.removeAttribute('name');
                                                selectElements.removeAttribute('required'); // Hapus atribut required
                                                // Tampilkan elemen input dan tambahkan name
                                                inputElements.style.display = 'block';
                                                inputElements.setAttribute('name', 'satuan');
                                                inputElements.setAttribute('required', 'required');
                                            } else { // Jika elemen input aktif
                                                // Sembunyikan elemen input dan hapus name
                                                inputElements.style.display = 'none';
                                                inputElements.removeAttribute('name');
                                                inputElements.removeAttribute('required');
                                                // Tampilkan elemen select dan tambahkan name
                                                selectElements.style.display = 'block';
                                                selectElements.setAttribute('name', 'satuan');
                                                selectElements.setAttribute('required', 'required'); // Tambahkan kembali atribut required
                                            }
                                        });

                                        // Ketika input satuan berubah
                                        document.getElementById('inputSatuannInput').addEventListener('input', function() {
                                            // Lakukan sesuatu dengan nilai input yang dimasukkan
                                        });
                                    </script>
                                    <div class="form-group">
                                        <label for="inputAsal">Tim Pemberi Tugas</label>
                                        <div>

                                            <select name="tim_id" class="selectpicker form-control"
                                                data-live-search="true" id="inputasal_tim">
                                                <option>Pilih Tim</option>
                                                @foreach ($jenis_tim as $jtim)
                                                    <option value="{{ $jtim->kode }}">
                                                        {{ $jtim->tim }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group col">
                                <label>ID Pegawai</label>
                                <input type="text" class="form-control" id="inputpegawai_idd" name="pegawai_id">
                            </div> --}}

                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete JT-->
    <div class="modal fade" id="deletejt" tabindex="-1" aria-labelledby="modaldeleteJT" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Hapus Jenis Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Kamu Yakin Ingin Menghapus ?</p>
                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ route('deleteJT') }}" method="post">
                        @csrf
                        <input type="hidden" name="no" id="inputnoDelete">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
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
                    <form action="{{ route('importjt') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col">
                            <label>Upload Template<span class="text-danger">*</span></label>
                            <input type="file" name="file" accept=".xlsx, .xls" class="form-control">
                        </div>
                        <br>
                        <Strong>Template Master Pekerjaan:</Strong>
                        <a href="{{ asset('template_plotting/Template Master Kegiatan.xlsx') }}"
                            download="Template Master Kegiatan.xlsx" class="btn btn-link">
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                        <h5 class="modal-title" id="successModalLabel">Gagal</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
        $(".fa-square-pen").click(function() {
            let key = $(this).attr('data');
            let no = $(`#no${key}`).val();
            let tugas = $(`#tugas${key}`).text();
            let satuan = $(`#satuan${key}`).text();
            let bobot = $(`#bobot${key}`).text();
            let asal_tim = $(`#tim_id${key}`).val();

            $('#inputno').val(no);
            $('#inputtugass').val(tugas);
            $('#inputsatuann').val(satuan);
            $('#inputSatuannInput').val(satuan);
            $('#inputbobott').val(bobot);
            $('#inputasal_tim').val(asal_tim);
        });

        $(".hapus").click(function() {
            let key = $(this).attr('data');
            let no = $(`#no${key}`).val();
            $('#inputnoDelete').val(no);
        });


        // $("#cetak").click(function() {
        //     let key = $(this).attr('data');
        //     let id = $(`#id${key}`).val();
        //     let pegawai_id = $(`#pegawai_id${key}`).val();
        //     $('#inputIdcetak').val(id);
        //     $('#inputcetakpegawai_id').val(id);
        // });

        // $(".fa-circle-info").click(function() {
        //     let keyy = $(this).attr('data');
        //     let idd = $(`#id${keyy}`).val();
        //     let pegawai_idd = $(`#pegawai_id${keyy}`).val();
        //     let pegawaii = $(`#Pegawai${keyy}`).text();
        //     let namaa = $(`#Nama${keyy}`).text();
        //     let asall = $(`#Asal${keyy}`).text();
        //     let file = $(`#file${keyy}`).val();
        //     console.log(asall);

        //     $('#inputidnmr').val(idd);
        //     $('#inputOrang').val(pegawaii);
        //     $('#inputpegawaiidnmr').val(pegawai_idd);
        //     $('#inputTugas').val(namaa);
        //     $('#inputTim').val(asall);
        //     $('.dokumen').html(
        //         `<a class ='unduh' href='download-file/${file}'><button class='btn btn-success'type='button'>Download</button></a>`
        //     );
        // });

        // function filter() {
        //     let dropdownbulanreal, table, rows, cells,
        //         dl, real, filterbulanreal, dropdowntahunreal, filtertahunreal,
        //         dropdownbulandl, dropdowntahundl, filterbulandl, filtertahundl;
        //     dropdownbulanreal = $('#bulanreal');
        //     dropdowntahunreal = $('#tahunreal');
        //     dropdownbulandl = $('#bulandl');
        //     dropdowntahundl = $('#tahundl');
        //     table = document.getElementById("dtBasicExample");
        //     rows = table.getElementsByTagName("tr");
        //     filterbulanreal = dropdownbulanreal.val();
        //     filtertahunreal = dropdowntahunreal.val();
        //     filterbulandl = dropdownbulandl.val();
        //     filtertahundl = dropdowntahundl.val();
        //     for (let row of rows) {
        //         cells = row.getElementsByTagName("td");
        //         dl = cells[7] || null;
        //         real = cells[8] || null;
        //         if (
        //             (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === "Semua" &&
        //                 filtertahundl === "Semua") ||
        //             !dl ||
        //             (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === "Semua" &&
        //                 filtertahundl === dl.textContent.substring(7, 11)) ||
        //             (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === dl.textContent
        //                 .substring(3, 6) && filtertahundl === "Semua") ||
        //             (filterbulanreal === "Semua" && filtertahunreal === "Semua" && filterbulandl === dl.textContent
        //                 .substring(3, 6) && filtertahundl === dl.textContent.substring(7, 11)) ||
        //             (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
        //                 filterbulandl === "Semua" && filtertahundl === "Semua") ||
        //             (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
        //                 filterbulandl === "Semua" && filtertahundl === dl.textContent.substring(7, 11)) ||
        //             (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
        //                 filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === "Semua") ||
        //             (filterbulanreal === "Semua" && filtertahunreal === real.textContent.substring(7, 11) &&
        //                 filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === dl.textContent.substring(7,
        //                     11)) ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
        //                 filterbulandl === "Semua" && filtertahundl === "Semua") ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
        //                 filterbulandl === "Semua" && filtertahundl === dl.textContent.substring(7, 11)) ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
        //                 filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === "Semua") ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === "Semua" &&
        //                 filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === dl.textContent.substring(7,
        //                     11)) ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
        //                 7, 11) && filterbulandl === "Semua" && filtertahundl === "Semua") ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
        //                 7, 11) && filterbulandl === "Semua" && filtertahundl === dl.textContent.substring(7, 11)) ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
        //                 7, 11) && filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === "Semua") ||
        //             (filterbulanreal === real.textContent.substring(3, 6) && filtertahunreal === real.textContent.substring(
        //                     7, 11) && filterbulandl === dl.textContent.substring(3, 6) && filtertahundl === dl.textContent
        //                 .substring(7, 11))
        //         ) {
        //             row.style.display = ""; // shows this row
        //         } else {
        //             row.style.display = "none"; // hides this row
        //         }
        //     }
        // }
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">




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
