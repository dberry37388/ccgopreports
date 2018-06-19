@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @component('components.card')
                @slot('title')
                    Dashboard
                @endslot

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!
            @endcomponent
        </div>
    </div>
</div>
@endsection
