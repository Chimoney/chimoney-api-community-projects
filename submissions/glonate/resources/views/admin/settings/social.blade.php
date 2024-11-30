@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <form action="{{route('save_settings')}}" class="form-horizontal" method="post" enctype="multipart/form-data" >
        @csrf

        <div id="social_login_settings_wrap">

            <legend>@lang('app.social_login')</legend>

            <div class="form-check mb-3 {{ $errors->has('enable_facebook_login')? 'is-invalid':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_social_login" {{ get_option('enable_social_login') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_social_login')</label>
            </div>

            <div class="form-check mb-3 {{ $errors->has('enable_facebook_login')? 'is-invalid':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_facebook_login" {{ get_option('enable_facebook_login') == 1 ? ' checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_facebook_login')</label>
            </div>

            <div class="form-check mb-3 {{ $errors->has('enable_google_login')? 'is-invalid':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_google_login" {{ get_option('enable_google_login') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_google_login')</label>
            </div>

            <div id="facebook_login_api_wrap" style="display: {{ get_option('enable_facebook_login') == 1 ? 'block' : 'none' }};">
                <hr />
                <div class="row mb-3">
                    <label for="fb_app_id" class="col-sm-4 col-form-label">@lang('app.facebook') @lang('app.app_id')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="fb_app_id" value="{{ get_option('fb_app_id') }}" name="fb_app_id" placeholder="@lang('app.fb_app_id')">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fb_app_secret" class="col-sm-4 col-form-label">@lang('app.facebook') @lang('app.app_secret')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="fb_app_secret" value="{{ get_option('fb_app_secret') }}" name="fb_app_secret" placeholder="@lang('app.app_secret')">
                    </div>
                </div>
            </div>

            <div id="google_login_api_wrap" style="display: {{ get_option('enable_google_login') == 1 ? 'block' : 'none' }};">
                <hr />
                <div class="row mb-3">
                    <label for="google_client_id" class="col-sm-4 col-form-label">@lang('app.google') @lang('app.client_id')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="google_client_id" value="{{ get_option('google_client_id') }}" name="google_client_id" placeholder="@lang('app.google_client_id')">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="google_client_secret" class="col-sm-4 col-form-label">@lang('app.google') @lang('app.client_secret')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="google_client_secret" value="{{ get_option('google_client_secret') }}" name="google_client_secret" placeholder="@lang('app.app_secret')">
                    </div>
                </div>

            </div>

        </div>

        <hr />

        <div class="row mb-3">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" id="settings_save_btn" class="btn btn-primary">@lang('app.save_settings')</button>
            </div>
        </div>

    </form>
@endsection


@section('page-js')
    <script>
        $(document).ready(function(){

            $('input[type="checkbox"], input[type="radio"]').click(function(){
                var input_name = $(this).attr('name');
                var input_value = 0;
                if ($(this).prop('checked')){
                    input_value = $(this).val();
                }
                $.ajax({
                    url : '{{ route('save_settings') }}',
                    type: "POST",
                    data: { [input_name]: input_value, '_token': '{{ csrf_token() }}' }
                });
            });

            /**
             * show or hide stripe and paypal settings wrap
             */
            $('#enable_facebook_login').click(function(){
                if ($(this).prop('checked')){
                    $('#facebook_login_api_wrap').slideDown();
                }else{
                    $('#facebook_login_api_wrap').slideUp();
                }
            });
            $('#enable_google_login').click(function(){
                if ($(this).prop('checked')){
                    $('#google_login_api_wrap').slideDown();
                }else{
                    $('#google_login_api_wrap').slideUp();
                }
            });



            /**
             * Send settings option value to server
             */
            $('#settings_save_btn').click(function(e){
                e.preventDefault();

                var this_btn = $(this);
                this_btn.attr('disabled', 'disabled');

                var form_data = this_btn.closest('form').serialize();
                $.ajax({
                    url : '{{ route('save_settings') }}',
                    type: "POST",
                    data: form_data,
                    success : function (data) {
                        if (data.success == 1){
                            this_btn.removeAttr('disabled');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });

        });
    </script>
@endsection