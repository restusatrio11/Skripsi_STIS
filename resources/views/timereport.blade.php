@extends('layouts.app')

@section('content')
    <div class="container">
        @php
            $selectedYear = request('year', null);
            $selectedMonth = request('month', null);
        @endphp

        <div class="row">
            <div class="col-sm-auto align-self-center">
                <h5>Time Report</h5>
            </div>
            <div class="col align-self-center border-top border-primary d-none d-sm-block"></div>
            <div class="col-sm-auto align-self-center ml-auto">

                <form method="post" action="{{ route('timereport', ['pegawai_id' => $pegawai_id]) }}" class="form-inline">
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
                                <option value="" {{ $selectedYear === null ? 'selected' : '' }}>Tahun
                                </option>
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
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
        <style>
            .card-info {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
            }

            .card-info-icon {
                margin-right: 15px;
            }

            .card-info-name {
                font-weight: bold;
                margin-bottom: 5px;
            }

            .card-info-nip-tim {
                color: #555;
                font-size: 14px;
            }
        </style>
        <!-- tabel Pegawai BPS -->
        <div class="card-shadow">
            <div class="card-body bg-white">
                <div class="card-header"style="background: linear-gradient(to right, #4c96db, #194d7e);">
                    <h4 class="card-title" style="color: white">Tabel Time Report Pegawai</h4>
                </div>
                <br>
                <div class="card-info">
                    <div class="card-info-icon">
                        <!-- Icon orang -->
                        <i class="fas fa-user" style="color: #4c96db; font-size: 100px;"></i>
                    </div>
                    @foreach ($pegawai as $jbt)
                        <div class="card-info-details">
                            <!-- Nama, NIP, dan Tim -->
                            <input type="hidden" name="pegawai_id" id="pegawai_id" value="{{ $jbt->id }}">
                            <p class="card-info-name">{{ $jbt->name }}</p>
                            <p class="card-info-nip-tim">NIP: {{ $jbt->id }}</p>
                            <p class="card-info-tim-jabatan">
                                Tim: {{ $jbt->tim }}, Jabatan: {{ $jbt->JabatanPegawai }} <br>
                            </p>
                    @endforeach
                </div>
            </div>
            <br>
            <progress value="{{ $totalWaktukerja }}" max="{{ $totalWaktu }}"
                style="width: 100%; height:20px;"></progress>
            <strong> Total Waktu kerja: {{ $totalWaktukerja }}</strong>
            <br>
            <br>
            <div class="table-responsive-xl">
                <table id="exampletimereport" class="stripe row-border order-column nowrap">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Pekerjaan</th>
                            <th class="text-center">Total Waktu</th>
                            {{-- <th class="text-center">ID Pegawai</th> --}}
                            <th class="text-center"></th>
                            {{-- <th class="text-center">Aksi</th> --}}
                            {{-- <th class="d-none"></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($task as $key => $jt)
                            <tr>
                                <input id="id{{ $key }}" type="hidden" value="{{ $jt->pegawai_id }}">
                                {{-- <td id="Password{{ $key }}" class="d-none">{{ $jt->password }}</td> --}}
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td id="nama{{ $key }}">{{ $jt->tugas }}</td>
                                <td class="text-center" id="TotalWaktu{{ $key }}">
                                    {{ $jt->volume_tertimbang }}
                                </td>
                                <td class="text-center">
                                    <progress value="{{ $jt->volume_tertimbang }}"
                                        max="{{ $jt->bobot * $jt->realisasi }}"></progress>
                                </td>
                                {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
