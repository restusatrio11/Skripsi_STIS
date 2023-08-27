@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-6 mx-auto">
                <canvas id="avgChart"></canvas>
                <canvas id="countChart"></canvas>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6 mx-auto">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection
