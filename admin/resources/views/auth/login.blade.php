@extends('layouts/app', ['activePage' => 'login', 'title' => 'uprise sacco | Login'])

@section('content')
<div>
    <div class="content">
        <div class="container">
            <center>
                <div class="mb-3">
                    <img class="img-fluid" src="{{ asset('light-bootstrap/img/logo/logo-no-background.png') }}" style="width: 14%">
                </div>
            </center>
            <div class="col-md-8 col-sm-6 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card card-login card-hidden bg-light">

                        <div class="card-body ">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email" class="col-md-6 col-form-label">{{ __('Username') }}</label>

                                    <div class="col-md-14">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-md-6 col-form-label">{{ __('Password') }}</label>

                                        <div class="col-md-14">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-auto mr-auto">
                                <div class="container text-center" >
                                    <button type="submit" class="btn btn-primary btn-wd">{{ __('Login') }}</button>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a class="btn btn-link"  style="color:#000000" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
@endpush
