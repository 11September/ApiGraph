@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Records - {{ count($records) }}</div>

                    @foreach($records as $record)
                        <div class="card-body">
                            <p>{{ $record->value }} - {{ $record->date }}</p>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="ambarchart2" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>

    <script src="{{ asset('js/bar-chart.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>

@endsection
