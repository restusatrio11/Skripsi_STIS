@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <h1>Ini adalah halaman admin</h1>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container">
        {{-- <p><a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter"></a></p>
        <div class="row">
            <div class="panel panel-primary filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Users</h3>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span>
                            Filter</button>
                    </div>
                </div>
                <table class="table">
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
                            <th><input type="text" class="form-control" placeholder="Nilai" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Keterangan" disabled></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $key => $task)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $task->nama }}</td>
                                <td>{{ $task->asal }}</td>
                                <td>{{ $task->target }}</td>
                                <td>{{ $task->realisasi }} <i class="fa-solid fa-square-plus"></i></td>
                                <td>{{ $task->satuan }}</td>
                                <td>{{ date('d M Y', strtotime($task->deadline)) }}</td>
                                <td>{{ date('d M Y', strtotime($task->tgl_realisasi)) }}</td>
                                <td>{{ $task->nilai }}</td>
                                <td>{{ $task->keterangan }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div> --}}

        <div class="table-responsive-lg">
            <table class="table">
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
                        <th><input type="text" class="form-control" placeholder="Nilai" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Keterangan" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $key => $task)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $task->nama }}</td>
                            <td>{{ $task->asal }}</td>
                            <td>{{ $task->target }}</td>
                            <td>{{ $task->realisasi }} <i class="fa-solid fa-square-plus"></i></td>
                            <td>{{ $task->satuan }}</td>
                            <td>{{ date('d M Y', strtotime($task->deadline)) }}</td>
                            <td>{{ date('d M Y', strtotime($task->tgl_realisasi)) }}</td>
                            <td>{{ $task->nilai }}</td>
                            <td>{{ $task->keterangan }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
@endsection
