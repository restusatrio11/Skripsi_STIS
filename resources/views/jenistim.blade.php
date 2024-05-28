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

        <!-- tabel jenis tim -->
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Jenis Tim</h4>
                </div>
                <br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">


                    <a class="btn btn-custom" href="#" data-bs-toggle="modal" data-bs-target="#tambahtim"><i
                            class="bi bi-pencil-square"></i> Tambah Jenis Tim</a>
                </div>
                <br>
                <div class="table-responsive-xl">
                    <table id="examplejtim" class="stripe row-border order-column nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Jenis Tim</th>
                                <th class="text-center">Aksi</th>
                                {{-- <th class="d-none"></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis_tim as $key => $jt)
                                <tr>
                                    <input id="no{{ $key }}" type="hidden" value="{{ $jt->kode }}">
                                    {{-- <td id="Password{{ $key }}" class="d-none">{{ $jt->password }}</td> --}}
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td id="tim{{ $key }}">{{ $jt->tim }}</td>
                                    {{-- <td class="text-center" id="Role{{ $key }}">{{ $user->role }}</td> --}}
                                    <td class="text-center">
                                        <a href="#" class="edit" data-bs-toggle="modal"><i class="fas fa-square-pen"
                                                data-bs-toggle="modal" title="Edit"
                                                style="color: orange; font-size: 20px;" data-bs-target="#updatetim"
                                                data="{{ $key }}" data-id="{{ $jt->kode }}"
                                                role="button"></i></a>
                                        {{-- <form class="delete-form" action="{{ route('delete') }}" method="POST"> --}}
                                        <a href="#" class="delete" data-bs-toggle="modal"><i
                                                class="fas fa-trash hapus" title="Delete"
                                                style="color: red; font-size: 20px;" data-id="{{ $jt->kode }}"
                                                data-bs-target="#deletetim" data="{{ $key }}"
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

    <!-- Modal Insert tim-->
    <div class="modal fade" id="tambahtim" tabindex="-1" aria-labelledby="modalTambahtim" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Buat Jenis tim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('storetim') }}" method="post">
                        @csrf
                        <div class="container">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <label for="inputTim">Nama Tim</label>
                                        <input type="text" class="form-control" id="inputTim" name="tim" required>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    <!--END FORM BUAT PEKERJAAN-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update tim -->
    <div class="modal fade" id="updatetim" tabindex="-1" aria-labelledby="modalUpdatetim" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Update Jenis Tim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('updatetim') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    {{-- <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputId" name="id">
                                    </div> --}}
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputno" name="kode">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputtugas">Jenis Tim</label>
                                        <input type="text" class="form-control" id="inputtimm" name="tim"
                                            required>
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
    <div class="modal fade" id="deletetim" tabindex="-1" aria-labelledby="modaldeleteJT" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Hapus Jenis Tim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Kamu Yakin Ingin Menghapus ?</p>
                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ route('deletetim') }}" method="post">
                        @csrf
                        <input type="hidden" name="kode" id="inputnoDelete">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
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
                $('#successModal .modal-header').addClass('success');
                $('#successModal').modal('show');
            });
        </script>
    @endif

    <script>
        $(".fa-square-pen").click(function() {
            let key = $(this).attr('data');
            let no = $(`#no${key}`).val();
            let tim = $(`#tim${key}`).text();

            $('#inputno').val(no);
            $('#inputtimm').val(tim);
        });

        $(".hapus").click(function() {
            let key = $(this).attr('data');
            let no = $(`#no${key}`).val();
            $('#inputnoDelete').val(no);
        });
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
