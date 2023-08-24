@extends('layouts.app')

@section('content')
    
    <div class="container">
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
                            <td>{{ $task->realisasi }} <i class="fa-solid fa-square-plus" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="idtask" class="form-label">ID Kegiatan</label>
                            <input type="text" class="form-control" id="idtask">
                        </div>
                        <div class="mb-3">
                        <label for="target" class="form-label">Target</label>
                        <input type="text" class="form-control" id="target">
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endsection