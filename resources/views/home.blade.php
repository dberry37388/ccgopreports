@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @component('components.card')
                @slot('title')
                    Available Reports
                @endslot

                @include('dashboard.report-list')
            @endcomponent
        </div>
    </div>
</div>
@endsection
