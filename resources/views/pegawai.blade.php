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
        @php
            $grouped_pegawai = $pegawai->groupBy('name');
        @endphp

        <br>
        @if (Auth::check() && Auth::user()->role == 'kepala_bps')
            <!-- tabel Pegawai BPS -->
            <div class="card-shadow">
                <div class="card-body bg-white">
                    <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h4 class="card-title" style="color: white">Tabel Pegawai BPS Kabupaten Klaten</h4>
                    </div>
                    <br>
                    <div class="table-responsive-xl">
                        <table id="examplepegawai" class="stripe row-border order-column nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Pegawai</th>
                                    <th class="text-center">NIP</th>
                                    {{-- <th class="text-center">ID Pegawai</th> --}}
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Tim Kerja</th>
                                    <th class="text-center">Aksi</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                    {{-- <th class="d-none"></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                // Menampilkan informasi pegawai yang sudah digabungkan
                                @foreach ($grouped_pegawai as $pegawai)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pegawai[0]->name }}</td> <!-- Nama pegawai -->
                                        <td class="text-center">{{ $pegawai[0]->id }}</td> <!-- ID pegawai -->
                                        <td class="text-center">
                                            @foreach ($pegawai as $key => $data)
                                                {{ $data->JabatanPegawai }}
                                                @if ($key < count($pegawai) - 1)
                                                    <br> <!-- Pisahkan dengan baris baru jika tidak di akhir -->
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-left">
                                            @foreach ($pegawai as $key => $data)
                                                {{ $data->tim }}
                                                @if ($key < count($pegawai) - 1)
                                                    <br> <!-- Pisahkan dengan baris baru jika tidak di akhir -->
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('timereport', ['pegawai_id' => $pegawai[0]->id]) }}">
                                                <i class="fas fa-square-pen" title="Edit"
                                                    style="color: orange; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <!-- tabel Pegawai BPS -->
            <div class="card-shadow">
                <div class="card-body bg-white">
                    <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                        <h4 class="card-title" style="color: white">Tabel Pegawai BPS Kabupaten Klaten</h4>
                    </div>
                    <br>
                    <div class="table-responsive-xl">
                        <table id="examplepegawai" class="stripe row-border order-column nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Pegawai</th>
                                    <th class="text-center">NIP</th>
                                    {{-- <th class="text-center">ID Pegawai</th> --}}
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Tim Kerja</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                    {{-- <th class="d-none"></th> --}}
                                </tr>
                            </thead>
                            <tbody>



                                {{-- Menampilkan informasi pegawai yang sudah digabungkan --}}
                                @foreach ($grouped_pegawai as $pegawai)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pegawai[0]->name }}</td> <!-- Nama pegawai -->
                                        <td class="text-center">{{ $pegawai[0]->id }}</td> <!-- ID pegawai -->
                                        <td class="text-center">
                                            @foreach ($pegawai as $key => $data)
                                                {{ $data->JabatanPegawai }}
                                                @if ($key < count($pegawai) - 1)
                                                    <br> <!-- Pisahkan dengan baris baru jika tidak di akhir -->
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-left">
                                            @foreach ($pegawai as $key => $data)
                                                {{ $data->tim }}
                                                @if ($key < count($pegawai) - 1)
                                                    <br> <!-- Pisahkan dengan baris baru jika tidak di akhir -->
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>



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
