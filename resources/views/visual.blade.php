{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-10">
            <div class="col-xl">
                <canvas id="avgChart" class="visual"></canvas>
                <br>
                <canvas id="countChart" class="visual"></canvas>
            </div>
        </div>
        <div class="row mb-3">

            <div class="col-sm-6 mx-auto">
                <canvas id="myChart" class=""></canvas>
            </div>

        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mt-4">
                <h2 class="display-4">Selamat Datang di Sistem Manajemen Kinerja</h2>
                <p class="lead">BPS Kabupaten Klaten</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title">Rata-Rata Nilai Kegiatan Pegawai</h4>
                        <canvas id="avgChart" class="visual"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title">Jumlah Kegiatan Pegawai</h4>
                        <canvas id="countChart" class="visual"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title">Tabel Kinerja Pegawai BPS Kabupaten Klaten</h4>
                        {{-- <canvas id="myChart" class="visual"></canvas> --}}
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
                                    <th class="text-center">Tgl Realisasi</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Keterangan</th>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $key => $task)
                                        <tr>
                                            <input id="id{{ $key }}" type="hidden" value="{{ $task->task_id }}">
                                            <input id="pegawai_id{{ $key }}" type="hidden"
                                                value="{{ $task->pegawai_id }}">
                                            <input id="file{{ $key }}" type="hidden" value="{{ $task->file }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center" id="Pegawai{{ $key }}">{{ $task->name }}</td>
                                            {{-- <td class="text-center" id="pegawai_id{{ $key }}">{{ $task->pegawai_id }}</td> --}}
                                            <td class="text-center" id="Nama{{ $key }}">{{ $task->nama }}</td>
                                            <td class="text-center" id="Asal{{ $key }}">{{ $task->asal }}</td>
                                            <td class="text-center" id="Target{{ $key }}">{{ $task->target }}
                                            </td>
                                            <td class="text-center" id="Realisasi{{ $key }}">
                                                {{ $task->realisasi }}</td>
                                            <td class="text-center" id="Satuan{{ $key }}">{{ $task->satuan }}
                                            </td>
                                            <td class="text-center tgd" id="Deadline{{ $key }}"
                                                data-value="{{ $task->deadline }}">
                                                {{ date('d M Y', strtotime($task->deadline)) }}</td>
                                            @if ($task->tgl_realisasi != null)
                                                <td class="text-center tgr">
                                                    {{ date('d M Y', strtotime($task->tgl_realisasi)) }}</td>
                                            @else
                                                <td class="text-center tgr"></td>
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
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endsection
