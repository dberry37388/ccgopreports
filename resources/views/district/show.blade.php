@extends('layouts.app')

@push('scripts')
    <script>
        $(function () {
            var myChart = Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Voter Turnout Comparison'
                },
                xAxis: {
                    categories: ['5/18', '8/16', '3/16', '8/14', '5/14', '8/12', '11/10', '5/10', '8/08']
                },
                yAxis: {
                    title: {
                        text: 'Total Voters'
                    }
                },
                series: [{
                    name: 'Republican',
                    color: '#AA0000',
                    data: {{ json_encode($republicanTotals) }}
                }, {
                    name: 'Democrat',
                    color: '#071765',
                    data: {{ json_encode($democratTotals) }}
                }]
            });
        });
    </script>

@endpush

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">
                            Coffee County District {{ $district }}
                        </h4>
                    </div>

                    <div class="card-body">

                        <div id="container" class="mb-5" style="width:100%; height:400px;"></div>

                        <table class="table table-striped table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>FNAME</th>
                                    <th>LNAME</th>
                                    <th>ADDRESS</th>
                                    <th>PHONE</th>
                                    <th>T</th>
                                    <th>R</th>
                                    <th>D</th>
                                    @foreach(config('votelist.elections') as $election => $header)
                                        <th>{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($voters as $voter)
                                    <tr>
                                        <td>{{ $voter->first_name }}</td>
                                        <td>{{ $voter->last_name }}</td>
                                        <td>{{ $voter->address }}</td>
                                        <td>{{ $voter->phone }}</td>
                                        <td>{{ $voter->total_votes }}</td>
                                        <td>{{ $voter->republican_votes }}</td>
                                        <td>{{ $voter->democrat_votes }}</td>
                                        @foreach(config('votelist.elections') as $election => $header)
                                            <th>{{ $voter->$election ?: '-' }}</th>
                                        @endforeach

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-center">
                        {{ $voters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
