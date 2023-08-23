@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
    
                    <div class="card-body">
                        <table id="example" class="table">
                            <thead>
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Kegiatan</th>
                                <th scope="col">Asal Kegiatan</th>
                                <th scope="col">Target</th>
                                <th scope="col">Realisasi</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Batas Waktu</th>
                                <th scope="col">Tanggal Realisasi</th>
                                <th scope="col">Nilai</th>
                                <th scope="col">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach($tasks as $key => $task)
                                    <tr>    
                                        <td>{{$key + 1}}</td>
                                        <td>{{$task->nama}}</td>
                                        <td>{{$task->asal}}</td>               
                                        <td>{{$task->target}}</td>               
                                        <td>{{$task->realisasi}} <i class="fa-solid fa-square-plus"></i></td>               
                                        <td>{{$task->satuan}}</td>               
                                        <td>{{date("d M Y", strtotime($task->deadline))}}</td>               
                                        <td>{{date("d M Y", strtotime($task->tgl_realisasi))}}</td>               
                                        <td>{{$task->nilai}}</td>               
                                        <td>{{$task->keterangan}}</td>               
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>$(document).ready( function () {
        $('#example').dataTable( {
          "bFilter": false
        } );
      } );</script>
    
@endsection