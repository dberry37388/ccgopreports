@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                @component('components.card')
                    @slot('title')
                        Districts
                    @endslot

                    @include('dashboard.districts')
                @endcomponent
            </div>
        </div>
    </div>
@endsection
