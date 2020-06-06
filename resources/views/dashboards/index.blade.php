@extends('layouts.master')
@section('content')
<div class="main">
    <div class="main-content">

        <div class="panel">
            <div class="panel-body">
                <div class="ct-chart"></div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-body">
                <h5>Report Bulanan</h5>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Pendapatan</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($reportBulanan as $b)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$b->bulan}}</td>
                            <td>Rp {{number_format($b->pendapatan)}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <h5>Report Tahunan</h5>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Pendapatan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reportTahunan as $t)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$t->tahun}}</td>
                                <td>Rp {{number_format($t->pendapatan)}}</td>
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
@stop
@php
    $labels = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    $dataChart = [];
    $dataSet = [];
    foreach ($reportBulanan as $data) {
        $dataChart[] = $data;
    }
    foreach($labels as $label) {
        $dataSet[] = null;
    }

    foreach($dataChart as $chart) {
        $index = array_search($chart['bulan'], $labels, true);
        if($index !== -1) {
            $dataSet[$index] = $chart['pendapatan'];
        }
    }
@endphp
@section('script')
<script>
    var dataChart = [];
    var bulan = [];
    var labels = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

    new Chartist.Line('.ct-chart', {
        labels: labels,
        series: [
            @json($dataSet)
        ]
    }, {
        height: '450px'
    });
</script>
@endsection
