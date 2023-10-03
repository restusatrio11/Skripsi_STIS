@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <a href="/user/ckp-r" class="btn btn-primary mb-3" target="_blank">CETAK CKP-R</a> --}}
        <div class="card-body bg-white">
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
        </div>
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="table-responsive-xl">
                    <table id="dtBasicExample" class="stripe row-border order-column nowrap">
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
                            <th class="text-center">Tgl Realisasi</th>
                            <th class="text-center">File</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Keterangan</th>

                            {{-- </thead> --}}
                            {{-- </tr> --}}
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr>
                                    <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td id="nama{{ $key }}" style="text-align: center">{{ $task->nama }}</td>
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
                                    <td>{{ $task->asal }}</td>
                                    <td id="target{{ $key }}" style="text-align: center">{{ $task->target }}</td>
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
                                        @endphp
                                        {{-- @if ($task->tgl_realisasi <= $task->deadline) --}}


                                        @if ($tanggalSekarang > $task->deadline)
                                            <div></div>
                                        @else
                                            <i data="{{ $key }}" data-id="{{ $task->task_id }}"
                                                class="fa-solid fa-square-plus" role="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"></i>
                                        @endif

                                    </td>
                                    <td style="text-align: center">{{ $task->satuan }}</td>
                                    <td style="text-align: center">{{ date('d M Y', strtotime($task->deadline)) }}</td>
                                    @if ($task->tgl_realisasi != null)
                                        <td class="text-center tgr">{{ (new DateTime($task->tgl_realisasi))->format('d M Y') }}</td>
                                    @else
                                        <td class="text-center tgr"></td>
                                    @endif
                                    <td>
                                        @if ($task->file != null)
                                            <a href="{{ route('downloadFile', ['fileId' => $task->task_id]) }}"
                                                class="text-center"><button class="btn btn-success mx-auto"
                                                    type="button">Download</button></a>
                                        @else
                                            Tugas Belum Disubmit
                                        @endif
                                    </td>
                                    <td style="text-align: center">{{ $task->nilai }}</td>
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
                        <form action="{{ route('updateUser') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="idtask" class="form-label">ID Kegiatan</label>
                                <input type="text" class="form-control" id="idtask" name="idtask" disabled>
                            </div>
                            <input type="hidden" class="form-control" id="idhidden" name="idhidden">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="nama" name="nama" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="target" class="form-label">Target</label>
                                <input type="text" class="form-control" id="target" name="target" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="realisasi" class="form-label">Realisasi</label>
                                <input type="text" class="form-control" id="realisasi" name="realisasi">
                            </div>
                            {{-- <div class="mb-3">
                            <label for="tgl_realisasi" class="form-label">Tanggal Realisasi</label>
                            <input type="text" class="form-control" id="tgl_realisasi" name="tgl_realisasi" disabled>
                        </div> --}}
                            <div class="mb-3">
                                {{-- <label for="update" class="form-label">Tanggal Realisasi</label> --}}
                                <input type="date" class="form-control" id="tgl_realisasi" name="update" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload Hasil Kegiatan</label><br>
                                <input type="file" class="form-control" id="file" name="file[]" required
                                    multiple>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
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
                let realisasi = $(`#realisasi${key}`).text();

                // Mendapatkan tanggal saat ini dalam format "YYYY-MM-DD"
                let currentDate = new Date().toISOString().slice(0, 10);

                $('#idtask').val(id);
                $('#idhidden').val(id);
                $('#nama').val(nama);
                $('#target').val(target);
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
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>

        <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    @endsection
