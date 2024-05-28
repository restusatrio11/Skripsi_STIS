@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Halaman Penilaian Kepala BPS</h1>
            <p id="realtime-clock" class="mb-0 text-gray-600"></p>
        </div>
        <br>
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Penilaian Pegawai </h4>
                </div>
                <br>
                <div class="table-responsive-xl">
                    <table id="examplekpbs" class="stripe row-border order-column nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">NIP</th>
                                {{-- <th class="text-center">ID Pegawai</th> --}}
                                <th class="text-center">Nilai</th>
                                <th class="text-center">Detail</th>
                                {{-- <th class="d-none"></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datapkbps as $key => $pkbps)
                                <tr>
                                    <input id="id{{ $key }}" type="hidden" value="{{ $pkbps->id }}">
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td id="nama_pegawai{{ $key }}">{{ $pkbps->name }}</td>
                                    <td class="text-center" id="nip{{ $key }}">{{ $pkbps->nip }}</td>
                                    <td class="text-center" id="nilaiKBPS{{ $key }}">{{ $pkbps->nilaiKBPS }}</td>

                                    <td class="text-center">
                                        <a href="#" class="edit btn btn-custom" data-bs-toggle="modal"
                                            data="{{ $key }}" data-id="{{ $pkbps->id }}"
                                            data-nip="{{ $pkbps->nip }}" role="button" data-bs-target="#updatepkbps"><i
                                                class="fas fa-square-pen" title="Edit" style="color: blue;"></i> Beri
                                            Nilai</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="updatepkbps" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Penilaian Pekerjaan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="tutup"></button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('updatepkbps') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" id="inputid" name="id">
                            <div class="form-group col">
                                <label for="inputnamapegawai">Nama Pegawai</label>
                                <input type="text" class="form-control" id="inputnamapegawai" name="nama_pegawai"
                                    readonly>
                            </div>
                            <div class="form-group col">
                                <label for="inputnip">NIP</label>
                                <input type="text" class="form-control" id="inputnip" name="nip" readonly>
                            </div>
                            <div class="form-group col">
                                <label for="inputnilaiKBPS">Beri Nilai Pegawai</label>
                                <input type="text" class="form-control" id="inputnilaiKBPS" name="nilaiKBPS" required>
                            </div>
                            <br>
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Pekerjaan</th>
                                        <th>Target</th>
                                        <th>Realisasi</th>
                                        <th>Nilai Kuantitas</th>
                                        <th>Nilai Kualitas</th>
                                    </tr>
                                </thead>
                                <tbody id="pekerjaanTableBody">
                                    <!-- Isi tabel akan diisi melalui JavaScript -->
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <strong>Nilai Akhir:</strong>
                                <span id="NAPlaceholder"></span>
                            </div>
                            <div class="mt-3">
                                <strong>Kategori:</strong>
                                <span id="kPlaceholder"></span>
                            </div>
                            <br>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom">Submit</button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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



        <script>
            $(".edit").click(function() {
                let key = $(this).attr('data');
                let id = $(`#id${key}`).val();
                let nama = $(`#nama_pegawai${key}`).text();
                let nip = $(`#nip${key}`).text();

                console.log(id);
                $('#inputid').val(id);
                $('#inputnamapegawai').val(nama);
                $('#inputnip').val(nip);
            });
        </script>

        <script>
            document.getElementById('updatepkbps').addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var nip = button.getAttribute('data-nip');

                // Ajukan permintaan AJAX ke server untuk mendapatkan data pekerjaan
                fetch('/simanja/kepala_BPS/' + nip + '/pekerjaan')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {


                        // Urutkan array objek berdasarkan nama tugas
                        data.pegawai.sort((a, b) => a.tugas.localeCompare(b.tugas));

                        // Mengisi tabel dengan data pekerjaan
                        var tableBody = document.getElementById('pekerjaanTableBody');
                        tableBody.innerHTML = '';

                        data.pegawai.forEach(function(pekerjaan) {
                            var row = '<tr>' +
                                '<td>' + pekerjaan.tugas + '</td>' +
                                '<td>' + pekerjaan.target + '</td>' +
                                '<td>' + pekerjaan.realisasi + '</td>' +
                                '<td>' + (pekerjaan.nilai_kuantitas ?? '') + '</td>' +
                                '<td>' + (pekerjaan.nilai_kualitas ?? '') + '</td>' +
                                '</tr>';
                            tableBody.innerHTML += row;
                        });

                        // Menampilkan nilai akhir di bawah tabel
                        var nilaiAkhir = data.nilai.nilai_akhir;
                        if (nilaiAkhir !== null && nilaiAkhir !== undefined) {
                            document.getElementById('NAPlaceholder').innerText = nilaiAkhir;
                        } else {
                            document.getElementById('NAPlaceholder').innerText = '';
                        }

                        // Menampilkan kategori bobot di bawah tabel
                        var kategoriBobot = data.nilai.kategori_bobot;
                        if (kategoriBobot !== null && kategoriBobot !== undefined) {
                            document.getElementById('kPlaceholder').innerText = kategoriBobot;
                        } else {
                            document.getElementById('kPlaceholder').innerText = '';
                        }




                    })
                    .catch(error => {
                        console.error('Error fetching pekerjaan data:', error);
                    });
            });

            // Menanggapi acara penutupan modal
            $('#updatepkbps').on('hide.bs.modal', function() {
                // Membersihkan nilai dalam modal atau mengatur ke nilai default
                $('#inputid').val('');
                $('#inputnamapegawai').val('');
                $('#inputnip').val('');
                $('#inputnilaiKBPS').val('');

                // Membersihkan isi tabel pekerjaan
                var tableBody = $('#pekerjaanTableBody');
                tableBody.empty();

                // Membersihkan nilai akhir placeholder
                document.getElementById('nilaiAkhirPlaceholder').innerText = '';
            });
        </script>

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




        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    @endsection
