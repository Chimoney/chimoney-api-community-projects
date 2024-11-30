@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <form action="{{route('save_settings')}}" class="form-horizontal" method="post" enctype="multipart/form-data" >
        @csrf

        <div id="social_login_settings_wrap">

            <div class="form-check mb-3 {{ $errors->has('enable_recaptcha_login')? 'has-error':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_recaptcha_login" {{ get_option('enable_recaptcha_login') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_recaptcha_login')</label>
            </div>

            <div class="form-check mb-3 {{ $errors->has('enable_recaptcha_registration')? 'has-error':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_recaptcha_registration" {{ get_option('enable_recaptcha_registration') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_recaptcha_registration')</label>
            </div>

            <div class="form-check mb-3 {{ $errors->has('enable_recaptcha_contact_form')? 'has-error':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_recaptcha_contact_form" {{ get_option('enable_recaptcha_contact_form') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_recaptcha_contact_form')</label>
            </div>

            <hr />
            <div class="row mb-3">
                <label for="recaptcha_site_key" class="col-sm-4 col-form-label">@lang('app.site_key')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="site_key" value="{{ get_option('recaptcha_site_key') }}" name="recaptcha_site_key" placeholder="@lang('app.site_key')">
                </div>
            </div>

            <div class="row mb-3">
                <label for="recaptcha_secret_key" class="col-sm-4 control-label">@lang('app.secret_key')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="recaptcha_secret_key" value="{{ get_option('recaptcha_secret_key') }}" name="recaptcha_secret_key" placeholder="@lang('app.secret_key')">
                </div>
            </div>
        </div>

        <hr />

        <div class="row mb-3">
            <div class="offset-sm-4 col-sm-8">
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