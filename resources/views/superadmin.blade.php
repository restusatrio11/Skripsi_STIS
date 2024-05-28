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
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Akun Pegawai</h4>
                </div>
                <br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                    {{-- <a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#tambahuser"
                        style="color: #ffffff"><button type="button" class="btn btn-primary btn-floating"><i
                                class="fas fa-square-pen">
                                Tambah Akun</i></button></a> --}}

                    <a class="btn btn-custom" href="#" data-bs-toggle="modal" data-bs-target="#tambahuser"><i
                            class="bi bi-pencil-square"></i> Tambah Akun</a>

                </div>
                <br>
                @php

                @endphp
                <div class="table-responsive-xl">
                    <table id="example" class="stripe row-border order-column nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Tim</th>
                                <th class="text-center">Jabatan</th>
                                {{-- <th class="text-center">ID Pegawai</th> --}}
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Aksi</th>
                                {{-- <th class="d-none"></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <input id="urutan{{ $key }}" type="hidden" value="{{ $user->urutan }}">
                                    <input id="no{{ $key }}" type="hidden" value="{{ $user->no }}">
                                    <input id="id{{ $key }}" type="hidden" value="{{ $user->id }}">
                                    <input id="idtim{{ $key }}" type="hidden" value="{{ $user->KodeTim }}">
                                    <input type="hidden" id="Password{{ $key }}" value="{{ $user->password }}">
                                    {{-- <td id="Password{{ $key }}" class="d-none">{{ $user->password }}</td> --}}
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td id="Pegawai{{ $key }}">{{ $user->name }}</td>
                                    <td class="text-center" id="NIP{{ $key }}">{{ $user->id }}</td>
                                    <td class="text-left" id="Tim{{ $key }}">{{ $user->tim }}</td>
                                    <td class="text-center" id="Jabatan{{ $key }}">{{ $user->JabatanPegawai }}
                                    </td>
                                    {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                                    <td class="text-left" id="Email{{ $key }}">{{ $user->email }}</td>
                                    {{-- <td class="text-center" id="Role{{ $key }}">{{ $user->role }}</td> --}}
                                    <td class="text-center">
                                        @if ($user->role === 'admin')
                                            <span class="badge light badge-primary"
                                                id="Role{{ $key }}">{{ $user->role }}</span>
                                        @elseif ($user->role === 'user')
                                            <span class="badge light badge-warning"
                                                id="Role{{ $key }}">{{ $user->role }}</span>
                                        @elseif ($user->role === 'superadmin')
                                            <span class="badge light badge-success"
                                                id="Role{{ $key }}">{{ $user->role }}</span>
                                        @else
                                            <span class="badge light badge-kbps"
                                                id="Role{{ $key }}">{{ $user->role }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="#" class="edit" data-bs-toggle="modal"><i class="fas fa-square-pen"
                                                data-bs-toggle="modal" title="Edit"
                                                style="color: orange; font-size: 20px;" data-bs-target="#updateuser"
                                                data="{{ $key }}" data-id="{{ $user->id }}"
                                                data-urutan="{{ $user->urutan }}"
                                                data-jabatan="{{ $user->JabatanPegawai }}" role="button"></i></a>
                                        {{-- <form class="delete-form" action="{{ route('delete') }}" method="POST"> --}}
                                        <a href="#" class="delete" data-bs-toggle="modal"><i
                                                class="fas fa-trash hapus" title="Delete"
                                                style="color: red; font-size: 20px;" data-id="{{ $user->id }}"
                                                data-bs-target="#deleteuser" data="{{ $key }}"
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
        <br>


    </div>


    <!-- Modal Insert akun-->
    <div class="modal fade" id="tambahuser" tabindex="-1" aria-labelledby="modalTambahUser" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Buat Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('storeSA') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <label for="inputUser">Nama</label>
                                        <input type="text" class="form-control" id="inputUser" name="name"
                                            required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputUser">NIP</label>
                                        <input type="text" class="form-control" id="inputNIP" name="id"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <div>
                                            <select name="role" class="selectpicker form-control"
                                                data-live-search="true" required>
                                                <option value="">Pilih Role</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User
                                                </option>
                                                <option value="superadmin"
                                                    {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super admin
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Pilih Jenis Tim</th>
                                                        <th>Pilih Jabatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="barisPertama">
                                                    <tr>
                                                        <td>
                                                            <select name="tim[]" class="form-control">
                                                                <option value="Kepala BPS">Pilih Tim</option>
                                                                @foreach ($jenis_tim as $jtim)
                                                                    <option value="{{ $jtim->kode }}">
                                                                        {{ $jtim->tim }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="jabatan[]" class="form-control">
                                                                <option value="">Pilih Jabatan</option>
                                                                <option value="Kepala BPS">Kepala BPS</option>
                                                                <option value="Ketua Tim">Ketua Tim</option>
                                                                <option value="Anggota">Anggota</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="tambahBaris" class="btn btn-primary">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group col">
                                        <label for="inputEmail">Email</label>
                                        <input type="text" class="form-control" id="inputEmail" name="email"
                                            required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputPassword">password</label>
                                        <input type="text" class="form-control" id="inputpassword" name="password"
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


    <!-- Modal Update-->
    <div class="modal fade" id="updateuser" tabindex="-1" aria-labelledby="modalUpdateUser" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h5 class="modal-title">Update Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ Route('updateSA') }}" method="post">
                        @csrf
                        <div class="container">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputUrutan" name="urutan">
                                    </div>
                                    <div class="form-group col">
                                        <input type="hidden" class="form-control" id="inputNoo" name="no">
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputUser">Nama</label>
                                        <input type="text" class="form-control" id="inputUserr" name="name"
                                            required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="inputUser">NIP</label>
                                        <input type="text" class="form-control" id="inputNIPP" name="id"
                                            readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <div>
                                            <select name="role" class="selectpicker form-control"
                                                data-live-search="true" id="inputRolee" required>
                                                <option value="">Pilih Role</option>
                                                <option value="admin">admin</option>
                                                <option value="user">user</option>
                                                <option value="superadmin">superadmin</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="inputAsall">Tim</label>
                                        <div>

                                            <select class="selectpicker form-control" data-live-search="true"
                                                id="inputAsall" name="idtim">
                                                <option disabled>Pilih Tim</option>

                                                @foreach ($jenis_tim as $jtim)
                                                    <option value="{{ $jtim->kode }}">
                                                        {{ $jtim->tim }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <label for="inputJabatann">Jabatan</label>
                                        <input type="text" class="form-control" id="inputJabatann" name="jabatan"
                                            required>
                                    </div> --}}

                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Pilih Jenis Tim</th>
                                                        <th>Pilih Jabatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="barisPertamaa">
                                                    <tr>
                                                        <td>
                                                            <select name="tim[]" class="form-control" id="inputAsall">
                                                                <option value="Kepala BPS">Pilih Tim</option>
                                                                @foreach ($jenis_tim as $jtim)
                                                                    <option value="{{ $jtim->kode }}">
                                                                        {{ $jtim->tim }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="jabatan[]" class="form-control"
                                                                id="inputJabatann">
                                                                <option value="">Pilih Jabatan</option>
                                                                <option value="Kepala BPS">Kepala BPS</option>
                                                                <option value="Ketua Tim">Ketua Tim</option>
                                                                <option value="Anggota">Anggota</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="tambahBariss" class="btn btn-primary">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group col">
                                        <label for="inputEmail">Email</label>
                                        <input type="text" class="form-control" id="inputEmaill" name="email"
                                            required>
                                    </div>
                                    {{-- <div class="form-group col">
                                        <label for="inputPassword">password</label>
                                        <input type="text" class="form-control" id="inputpasswordd" name="password"
                                            required>
                                    </div> --}}
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

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteuser" tabindex="-1" aria-labelledby="modaldeleteUser" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Kamu Yakin Ingin Menghapus ?</p>
                    <!--FORM BUAT PEKERJAAN-->
                    <form action="{{ route('deleteSA') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="inputIdDelete">
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
    {{-- <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Import Alokasi Tugas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx, .xls">
                    <button type="submit">Impor Data</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}

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
            let urutan = $(`#urutan${key}`).val();
            let no = $(`#no${key}`).val();
            let id = $(`#id${key}`).val(); //NIP
            let idtim = $(`#idtim${key}`).val().trim().split(',');
            let pegawai = $(`#Pegawai${key}`).text();
            let jabatan = $(`#Jabatan${key}`).text().trim().split(',');
            let nip = $(`#NIP${key}`).text();
            let email = $(`#Email${key}`).text();
            let role = $(`#Role${key}`).text();
            // let password = $(`#Password${key}`).val();

            console.log('idtim:', idtim);

            $('#inputUrutan').val(urutan);
            $('#inputNoo').val(no);
            // $('#inputAsall').val(idtim);
            // $('#inputJabatann').val(jabatan);
            $('#inputUserr').val(pegawai);
            $('#inputNIPP').val(nip);
            $('#inputEmaill').val(email);
            $('#inputRolee').val(role);
            // $('#inputpasswordd').val(password);

            // Mengambil token CSRF dari meta tag dalam dokumen HTML
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Menghapus semua baris kecuali baris pertama
            $('#barisPertamaa tr').not(':first').remove();

            // Mengambil baris pertama
            let barisPertama = $('#barisPertamaa tr').first();

            // Set values for the first row
            barisPertama.find('select[name="tim[]"]').val(idtim[0]);
            barisPertama.find('select[name="jabatan[]"]').val(jabatan[0]);

            // Menambahkan baris-baris sesuai dengan jumlah tim dan jabatan pegawai
            for (let i = 1; i < idtim.length; i++) {
                // Clone the row
                let clone = barisPertama.clone();

                // Set values for the cloned row
                clone.find('select[name="tim[]"]').val(idtim[i]);
                clone.find('select[name="jabatan[]"]').val(jabatan[i]);

                // var hapusButton = $('<button>').attr({
                //     type: 'button',
                //     class: 'btn btn-outline-danger btn-sm',
                //     'data-no': no
                // }).append($('<span>').attr('aria-hidden', 'true').html('&times;'));

                // hapusButton.click(function() {
                //     var tombolHapus = $(this); // Simpan referensi tombol hapus

                //     var no = tombolHapus.data(
                //         'no'); // Ambil nomor entri dari data-no pada tombol hapus yang ditekan
                //     var idtim = tombolHapus.data(
                //         'idtim');
                //     console.log('no:', no + idtim);
                //     // Kirim permintaan AJAX untuk menghapus entri dari tabel jbtpegawai
                //     $.ajax({
                //         url: '/jbtpegawai/delete/' +
                //             no + '/' + idtim, // Gunakan nomor entri untuk URL endpoint yang sesuai
                //         type: 'DELETE',
                //         headers: {
                //             'X-CSRF-TOKEN': csrfToken
                //         },
                //         success: function(response) {
                //             tombolHapus.closest('tr')
                //                 .remove(); // Hapus baris yang sesuai dengan tombol hapus yang ditekan
                //         },
                //         error: function() {
                //             alert('Terjadi kesalahan saat menghapus data.');
                //         }
                //     });
                // });

                // clone.append($('<td>').append(hapusButton));



                // Append the cloned row
                $('#barisPertamaa').append(clone);
            }
        });

        $(".hapus").click(function() {
            let key = $(this).attr('data');
            let id = $(`#id${key}`).val();
            $('#inputIdDelete').val(id);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">

    <script>
        $(document).ready(function() {
            $('#tambahBaris').click(function() {
                var clone = $('#barisPertama tr').first().clone();



                // Tambahkan tombol hapus dengan ikon close Bootstrap
                var hapusButton = $('<button>').attr({
                    type: 'button',
                    class: 'btn btn-outline-danger btn-sm'
                }).append($('<span>').attr('aria-hidden', 'true').html('&times;')).click(function() {
                    $(this).closest('tr').remove();
                });
                clone.append($('<td>').append(hapusButton));

                // Tambahkan baris baru setelah baris terakhir
                $('#barisPertama').append(clone);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tambahBariss').click(function() {
                var clone = $('#barisPertamaa tr').first().clone();



                // Tambahkan tombol hapus dengan ikon close Bootstrap
                // var hapusButton = $('<button>').attr({
                //     type: 'button',
                //     class: 'btn btn-outline-danger btn-sm'
                // }).append($('<span>').attr('aria-hidden', 'true').html('&times;')).click(function() {
                //     $(this).closest('tr').remove();
                // });
                // clone.append($('<td>').append(hapusButton));

                // Tambahkan baris baru setelah baris terakhir
                $('#barisPertamaa').append(clone);
            });
        });
    </script>




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
