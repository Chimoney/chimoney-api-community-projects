@extends('layouts.public.app')

@section('content')
    <section class="auth-form">

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-default">
                        <div class="card-header text-center">@lang('app.contact_us')</div>
                        <div class="card-body">

                            @include('layouts.partials.alert')


                            <form class="form-horizontal" role="form" method="POST" action="{{ route('contact_us') }}">
                                {{ csrf_field() }}

                                <div class="row mb-3 {{ $errors->has('name') ? ' is-invalid' : '' }}">
                                    <label for="name" class="col-md-4 col-form-label">@lang('app.name') <span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="col-md-4 col-form-label">@lang('app.email_address')  <span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $errors->has('subject') ? ' is-invalid' : '' }}">
                                    <label for="subject" class="col-md-4 col-form-label">@lang('app.subject')  <span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="subject" type="subject" class="form-control" name="subject" value="{{ old('subject') }}" required>
                                        @if ($errors->has('subject'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $errors->has('message') ? ' is-invalid' : '' }}">
                                    <label for="message" class="col-md-4 col-form-label">@lang('app.message')</label>

                                    <div class="col-md-6">
                                        <textarea name="message" class="form-control" rows="7">{{ old('message') }}</textarea>
                                        @if ($errors->has('message'))
                                            <span class="help-block"><strong>{{ $errors->first('message') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $errors->has('project_owner') ? ' is-invalid' : '' }}">
                                    <div class="col-md-6 offset-md-4">
                                        <label><input type="checkbox" name="project_owner" value="Project Owner" /> @lang('app.project_owner')</label>
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $errors->has('project_backer') ? ' is-invalid' : '' }}">
                                    <div class="col-md-6 offset-md-4">
                                        <label><input type="checkbox" name="project_backer" value="Project Backer" /> @lang('app.project_backer')</label>
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $errors->has('other') ? ' is-invalid' : '' }}">
                                    <div class="col-md-6 offset-md-4">
                                        <label><input type="checkbox" name="other" value="Other" /> @lang('app.other')</label>
                                    </div>
                                </div>

                                @if(get_option('enable_recaptcha_contact_form') == 1)
                                    <div class="row mb-3  {{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="g-recaptcha" data-sitekey="{{get_option('recaptcha_site_key')}}"></div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-3 ">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('app.send_feedback')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@if(get_option('enable_recaptcha_contact_form') == 1)
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif