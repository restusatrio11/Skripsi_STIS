@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Bulan Deadline</label>
                    <select class="form-select" id="bulandl" oninput="filterDL()">
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
                    <select class="form-select" id="tahundl" oninput="filterDL()">
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
                    <select class="form-select" id="bulanreal" oninput="filterRealisasi()">
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
                    <select class="form-select" id="tahunreal" oninput="filterRealisasi()">
                        <option>Semua</option>
                        <option>2021</option>
                        <option>2022</option>
                        <option>2023</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="No" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nama" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Asal" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Target" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Realisasi" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Satuan" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Deadline" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Tgl Realisasi" disabled></th>
                        <th><input type="text" class="form-control" placeholder="File" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nilai" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Keterangan" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $key => $task)
                        <tr>
                            <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                            <td>{{ $key + 1 }}</td>
                            <td id="nama{{ $key }}">{{ $task->nama }}</td>
                            <td>{{ $task->asal }}</td>
                            <td id="target{{ $key }}">{{ $task->target }}</td>
                            <td id="realisasi{{ $key }}">{{ $task->realisasi }} <i data="{{ $key }}"
                                    data-id="{{ $task->task_id }}" class="fa-solid fa-square-plus" role="button"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                            <td>{{ $task->satuan }}</td>
                            <td>{{ date('d M Y', strtotime($task->deadline)) }}</td>
                            @if ($task->tgl_realisasi != null)
                                <td class="text-center">{{ date('d M Y', strtotime($task->tgl_realisasi)) }}</td>
                            @else
                                <td class="text-center"></td>
                            @endif
                            <td>
                                @if ($task->file != null)
                                    <a href="file/{{ $task->file }}"><button class="btn btn-success"
                                            type="button">Download</button></a>
                                @else
                                    Tugas Belum Disubmit
                                @endif
                            </td>
                            <td>{{ $task->nilai }}</td>
                            <td>{{ $task->keterangan }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
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
                            <input type="text" class="form-control" id="realisasi" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_realisasi" class="form-label">Tanggal Realisasi</label>
                            <input type="text" class="form-control" id="tgl_realisasi" name="tgl_realisasi" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="update" class="form-label">Update Realisasi</label>
                            <input type="date" class="form-control" id="update" name="update">
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Hasil Kegiatan</label><br>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
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
                $('#successModal').modal('show');
            });
        </script>
    @endif

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(".fa-square-plus").click(function() {
            let key = $(this).attr('data');
            let id = $(`#id${key}`).val();
            let nama = $(`#nama${key}`).text();
            let target = $(`#target${key}`).text();
            let realisasi = $(`#realisasi${key}`).text();
            let tgl_realisasi = $(`#tgl_realisasi${key}`).text();
            $('#idtask').val(id);
            $('#idhidden').val(id);
            $('#nama').val(nama);
            $('#target').val(target);
            $('#realisasi').val(realisasi);
            $('#tgl_realisasi').val(tgl_realisasi);
        });

        function filterDL() {
            let dropdownbulan, table, rows, cells, dl, filterbulan, dropdowntahun, filtertahun;
            dropdownbulan = $('#bulandl');
            dropdowntahun = $('#tahundl');
            table = document.getElementById("dtBasicExample");
            rows = table.getElementsByTagName("tr");
            filterbulan = dropdownbulan.val();
            filtertahun = dropdowntahun.val();
            for (let row of rows) {
                cells = row.getElementsByTagName("td");
                dl = cells[6] || null;
                if ((filterbulan === "Semua" && filtertahun === "Semua") || !dl ||
                    (filterbulan === dl.textContent.substring(3, 6) && filtertahun === dl.textContent.substring(7, 11)) ||
                    (filterbulan === dl.textContent.substring(3, 6) && filtertahun === "Semua") ||
                    (filterbulan === "Semua" && filtertahun === dl.textContent.substring(7, 11))) {
                    row.style.display = ""; // shows this row
                } else {
                    row.style.display = "none"; // hides this row
                }
            }
        }

        function filterRealisasi() {
            let dropdownbulan, table, rows, cells, dl, filterbulan, dropdowntahun, filtertahun;
            dropdownbulan = $('#bulanreal');
            dropdowntahun = $('#tahunreal');
            table = document.getElementById("dtBasicExample");
            rows = table.getElementsByTagName("tr");
            filterbulan = dropdownbulan.val();
            filtertahun = dropdowntahun.val();
            for (let row of rows) {
                cells = row.getElementsByTagName("td");
                dl = cells[7] || null;
                if ((filterbulan === "Semua" && filtertahun === "Semua") || !dl ||
                    (filterbulan === dl.textContent.substring(3, 6) && filtertahun === dl.textContent.substring(7, 11)) ||
                    (filterbulan === dl.textContent.substring(3, 6) && filtertahun === "Semua") ||
                    (filterbulan === "Semua" && filtertahun === dl.textContent.substring(7, 11))) {
                    row.style.display = ""; // shows this row
                } else {
                    row.style.display = "none"; // hides this row
                }
            }
        }
    </script>
@endsection
