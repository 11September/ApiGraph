@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Records - {{ count($records) }}</div>

                    @foreach($records as $record => $values)
                        <p>{{ $record }}</p>

                        @php($sum = 0)
                        @php($count = count($values))
                        @foreach($values as $record)
                            @php($sum += $record->value)
                        @endforeach

                        <p>{{ $sum / $count }}</p>

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

    {{--<script src="{{ asset('js/bar-chart.js') }}"></script>--}}
    <script src="{{ asset('js/plugins.js') }}"></script>


    <script>
        if ($('#ambarchart2').length) {
            var chart = AmCharts.makeChart("ambarchart2", {
                "type": "serial",
                "addClassNames": true,
                "theme": "light",
                "autoMargins": false,
                "marginLeft": 30,
                "marginRight": 8,
                "marginTop": 10,
                "marginBottom": 26,
                "balloon": {
                    "adjustBorderColor": false,
                    "horizontalPadding": 10,
                    "verticalPadding": 8,
                    "color": "#ffffff"
                },

                "dataProvider": [

                @foreach($records as $record => $values)

                @php($sum = 0)
                @php($year = 0)
                @php($count = count($values))
                @foreach($values as $record)
                @php($year = date_format(date_create($record->date), 'Y'))
                @php($sum += $record->value)
                @endforeach
                {
                    "year": {{ (int)$year }},
                    "income": {{ $sum / $count }},
                    "expenses": {{ ($sum / $count) + 1 }},
                    "color": "#7474f0"
                },
                @endforeach
                ],
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
                "startDuration": 1,
                "graphs": [{
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "fillColorsField": "color",
                    "title": "Income",
                    "type": "column",
                    "valueField": "income",
                    "dashLengthField": "dashLengthColumn"
                }, {
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "bullet": "round",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "lineColor": "#AA59FE",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Expenses",
                    "valueField": "expenses",
                    "dashLengthField": "dashLengthLine"
                }],
                "categoryField": "year",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                },
                "export": {
                    "enabled": false
                }
            });
        }
    </script>

@endsection
