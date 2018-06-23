@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h3 class="card-title">{{ __('Register') }}</h3>

                    <p>
                        Access to this site is currently limited. You can request contacting Sally Singles
                        <a href="mailto:coffeecotngop@aol.com">coffeecotngop@aol.com</a>, or Daniel Berry
                        <a href="mailto:daniel@builtybyberry.com">daniel@builtbyberry.com</a>.
                    </p>

                    <p>
                        Please include the following information:
                    </p>

                    <ul>
                        <li>Your Name,</li>
                        <li>Best phone number to contact you,</li>
                        <li>Your party affiliation, and</li>
                        <li>The reason you are requesting access.</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
