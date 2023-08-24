@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endsection
