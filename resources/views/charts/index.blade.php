@extends('layouts.app')

@push('scripts')
    <script>
        $(function () {
            @foreach($totals as $label => $data)
            var  {{ $data['div'] }} = Highcharts.chart('container_{{ $data['div'] }}', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: '{{ $data['label'] }} Primary Voter Turnout Comparison'
                },
                xAxis: {
                    categories: ['5/18', '8/16', '3/16', '8/14', '5/14', '8/12', '11/10', '5/10', '8/08']
                },
                yAxis: {
                    title: {
                        text: 'Total Primary Voters'
                    }
                },
                series: [{
                    name: 'Republican',
                    color: '#AA0000',
                    data: {{ json_encode($data['republican']) }}
                }, {
                    name: 'Democrat',
                    color: '#071765',
                    data: {{ json_encode($data['democrat']) }}
                }]
            });
            @endforeach
        });
    </script>
@endpush


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($totals as $label => $data)
                    <div id="container_{{ $data['div'] }}" style="width:100%; height:400px;" class="mb-2"></div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
