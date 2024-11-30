@extends('layouts.public.app')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('app.login_desc')</div>

                <div class="card-body">

                    @include('layouts.partials.alert')


                    @if(get_option('enable_social_login') == 1)
                        <div class="row">

                            @if(get_option('enable_facebook_login') == 1)
                                <div class="col-sm-6">
                                    <a href="{{ route('facebook_redirect') }}" class="btn btn-lg w-100 d-block btn-primary m-1">
                                        <i class="fa fa-facebook d-sm-none"></i>
                                        <span class="d-sm-block"><i class="fa fa-facebook-square"></i> Facebook</span>
                                    </a>
                                </div>
                            @endif

                            @if(get_option('enable_google_login') == 1)
                                <div class="col-sm-6">
                                    <a href="{{ route('google_redirect') }}" class="btn btn-lg w-100 d-block btn-warning m-1">
                                        <i class="fa fa-google-plus d-sm-none"></i>
                                        <span class="d-sm-block"><i class="fa fa-google-plus-square"></i> Google+</span>
                                    </a>
                                </div>
                            @endif

                        </div>
                        <hr />
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">@lang('app.email_address')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">@lang('app.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if(get_option('enable_recaptcha_login') == 1)
                            <div class="row mb-3 {{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}">
                                <div class="col-md-6">
                                    <div class="g-recaptcha" data-sitekey="{{get_option('recaptcha_site_key')}}"></div>
                                    @error('g-recaptcha-response')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        @lang('app.remember_me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('app.login')
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        @lang('app.forgot_your_password')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
    @if(get_option('enable_recaptcha_login') == 1)
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
@endsection
