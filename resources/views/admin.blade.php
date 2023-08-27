@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="table-responsive-xl">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Pegawai</th>
                    {{-- <th class="text-center">ID Pegawai</th> --}}
                    <th class="text-center">Tugas</th>
                    <th class="text-center">Asal</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Realisasi</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Deadline</th>
                    <th class="text-center">Tgl Realisasi
                    </th>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $key => $task)
                        <tr>
                            <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                            <input id="pegawai_id{{ $key }}" type="hidden" value="{{ $task->pegawai_id }}">
                            <input id="file{{ $key }}" type="hidden" value="{{ $task->file }}">
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center" id="Pegawai{{ $key }}">{{ $task->name }}</td>
                            {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                            <td class="text-center" id="Nama{{ $key }}">{{ $task->nama }}</td>
                            <td class="text-center" id="Asal{{ $key }}">{{ $task->asal }}</td>
                            <td class="text-center" id="Target{{ $key }}">{{ $task->target }}</td>
                            <td class="text-center" id="Realisasi{{ $key }}">{{ $task->realisasi }}</td>
                            <td class="text-center" id="Satuan{{ $key }}">{{ $task->satuan }}</td>
                            <td class="text-center" id="Deadline{{ $key }}" data-value="{{ $task->deadline }}">
                                {{ date('d M Y', strtotime($task->deadline)) }}</td>
                            @if ($task->tgl_realisasi != null)
                                <td class="text-center">{{ date('d M Y', strtotime($task->tgl_realisasi)) }}</td>
                            @else
                                <td class="text-center"></td>
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
                                    <span class="badge rounded-pill text-bg-info text-white">{{ $task->keterangan }}</span>
                                </td>
                            @endif
                            <td class="text-center">
                                <a href="#" class="edit" data-bs-toggle="modal"><i class="fas fa-square-pen"
                                        data-bs-toggle="modal" title="Edit" style="color: orange;"
                                        data-bs-target="#updatekerja" data="{{ $key }}"
                                        data-id="{{ $task->task_id }}" role="button"></i></a>
                                {{-- <form class="delete-form" action="{{ route('delete') }}" method="POST"> --}}
                                <a href="#" class="delete" data-bs-toggle="modal"><i class="fas fa-trash hapus"
                                        title="Delete" style="color: red;" data-id="{{ $task->task_id }}"
                                        data-bs-target="#deletekerja" data="{{ $key }}"
                                        data-bs-toggle="modal"></i></a>
                                {{-- </form> --}}
                                @if ($task->file != null)
                                    <a href="#" class="edit" data-bs-toggle="modal"
                                        data-bs-target="#penilaiankerja"><i class="fas fa-circle-info"
                                            data-bs-toggle="modal" title="Edit" style="color: blue;"
                                            data-bs-target="#penilaiankerja" data="{{ $key }}"
                                            data-id="{{ $task->task_id }}" role="button"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Insert -->
    <div class="modal fade" id="tambahkerja" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('store') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputIdD" name="task_id">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Pegawai</label>
                                        <div>
                                            <select name="pegawai_id" class="selectpicker form-control"
                                                data-live-search="true">Pilih Pegawai
                                                @foreach ($pegawai as $pegawaibps)
                                                    <option value="{{ $pegawaibps->id }}">{{ $pegawaibps->name }}
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

                            <div class="row">
                                <div class="form-group col">
                                    <label for="inputTask">Tugas</label>
                                    <input type="text" class="form-control" id="inputTaskk" name="nama">
                                </div>

                                <div class="form-group col">
                                    <label for="inputAsal">Asal</label>
                                    <input type="text" class="form-control" id="inputAsall" name="asal">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputTarget">Target</label>
                                    <input type="text" class="form-control" id="inputTargett" name="target">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputRealisasi">Realisasi</label>
                                    <input type="text" class="form-control" id="inputRealisasii" name="realisasi">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputSatuan">Satuan</label>
                                    <input type="text" class="form-control" id="inputSatuann" name="satuan">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDeadline">Deadline</label>
                                <input type="date" class="form-control" id="deadlinee" name="deadline"
                                    placeholder="DD/MM/YYYY" />
                            </div>
                            <input type="hidden" class="form-control" name="keterangan" />
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update-->
    <div class="modal fade" id="updatekerja" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('update') }}" method="post">
                        @csrf
                        <div class="container">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputId" name="id">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPegawai">Nama Pegawai</label>
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
                                    <label for="inputTask">Tugas</label>
                                    <input type="text" class="form-control" id="inputTask" name="nama">
                                </div>

                                <div class="form-group col">
                                    <label for="inputAsal">Asal</label>
                                    <input type="text" class="form-control" id="inputAsal" name="asal">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputTarget">Target</label>
                                    <input type="text" class="form-control" id="inputTarget" name="target">
                                </div>
                                <div class="col-md-2">
                                    <label for="inputRealisasi">Realisasi</label>
                                    <input type="text" class="form-control" id="inputRealisasi" name="realisasi">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputSatuan">Satuan</label>
                                    <input type="text" class="form-control" id="inputSatuan" name="satuan">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDeadline">Deadline</label>
                                <input type="date" class="form-control" id="inputDeadline" name="deadline" />
                            </div>
                            <input type="hidden" class="form-control" name="tgl_realisasi" />
                            <input type="hidden" class="form-control" name="nilai" />
                            <input type="hidden" class="form-control" name="keterangan" />
                            <input type="hidden" class="form-control" name="file" />
                            <br>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deletekerja" tabindex="-1" aria-labelledby="modaldeleteBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ route('delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="task_id" id="inputIdDelete">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Penilaian -->
    <div class="modal fade" id="penilaiankerja" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
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
                                <label for="inputnilai">Beri Nilai</label>
                                <input type="text" class="form-control" id="inputnilai" name="nilai">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
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
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            $(document).ready(function() {
                $('#successModal').modal('show');
            });
        </script>
    @endif

    <script>
        $(".fa-square-pen").click(function() {
            let key = $(this).attr('data');
            let id = $(`#id${key}`).val();
            let pegawai_id = $(`#pegawai_id${key}`).val();
            let pegawai = $(`#Pegawai${key}`).text();
            let nama = $(`#Nama${key}`).text();
            let asal = $(`#Asal${key}`).text();
            let target = $(`#Target${key}`).text();
            let realisasi = $(`#Realisasi${key}`).text();
            let satuan = $(`#Satuan${key}`).text();
            let deadline = $(`#Deadline${key}`).data('value');

            // Mengambil nilai deadline dalam format YYYY-MM-DD
            // console.log(`#Deadline${key}`);

            // Konversi format tanggal sesuai kebutuhan, misalnya menjadi "DD-MM-YYYY"
            // let formattedDeadline = ""; // Default jika tidak ada nilai

            // if (deadline) {
            //     const parts = deadline.split('-');
            //     if (parts.length === 3) {
            //         formattedDeadline = `${parts[2]}/${parts[1]}/${parts[0]}`;
            //     }
            // }

            $('#inputId').val(id);
            $('#inputPegawai').val(pegawai_id);
            $('#inputpegawai_id').val(pegawai_id);
            $('#inputTask').val(nama);
            $('#inputAsal').val(asal);
            $('#inputTarget').val(target);
            $('#inputRealisasi').val(realisasi);
            $('#inputSatuan').val(satuan);
            $('#inputDeadline').val(deadline);
        });

        $(".hapus").click(function() {
            let key = $(this).attr('data');
            let id = $(`#id${key}`).val();
            $('#inputIdDelete').val(id);
        });

        $(".fa-circle-info").click(function() {
            let keyy = $(this).attr('data');
            let idd = $(`#id${keyy}`).val();
            let pegawai_idd = $(`#pegawai_id${keyy}`).val();
            let pegawaii = $(`#Pegawai${keyy}`).text();
            let namaa = $(`#Nama${keyy}`).text();
            let asall = $(`#Asal${keyy}`).text();
            let file = $(`#file${keyy}`).val();
            console.log(asall);

            $('#inputidnmr').val(idd);
            $('#inputOrang').val(pegawaii);
            $('#inputpegawaiidnmr').val(pegawai_idd);
            $('#inputTugas').val(namaa);
            $('#inputTim').val(asall);
            $('.dokumen').html(
                `<a class ='unduh' href='file/${file}'><button class='btn btn-success'type='button'>Download</button></a>`
            );
        });
    </script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endsection
