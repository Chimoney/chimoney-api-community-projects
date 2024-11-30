@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <form action="{{route('save_settings')}}" class="form-horizontal" method="post" enctype="multipart/form-data" > 
        @csrf

        <div class="form-check mb-3 {{ $errors->has('enable_paypal')? 'is-invalid':'' }}">
            <input class="form-check-input" type="checkbox" value="1" name="enable_paypal" {{ get_option('enable_paypal') == 1 ? 'checked="checked"': '' }}>
            <label class="form-check-label">@lang('app.enable_paypal')</label>
            {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
        </div>

        <div class="form-check mb-3 {{ $errors->has('enable_stripe')? 'is-invalid':'' }}">
            <input class="form-check-input" type="checkbox" value="1" name="enable_stripe" {{ get_option('enable_stripe') == 1 ? 'checked="checked"': '' }}>
            <label class="form-check-label">@lang('app.enable_stripe')</label>
            {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
        </div>

        <div class="form-check mb-3 {{ $errors->has('enable_bank_transfer')? 'is-invalid':'' }}">
            <input class="form-check-input" type="checkbox" value="1" name="enable_bank_transfer" {{ get_option('enable_bank_transfer') == 1 ? 'checked="checked"': '' }}>
            <label class="form-check-label"> @lang('app.enable_bank_transfer')</label>
            {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
        </div>

        <div id="paypal_settings_wrap" style="display: {{ get_option('enable_paypal') == 1 ? 'block' : 'none' }}">
            <hr />

            <legend>@lang('app.paypal_settings')</legend>

            <div class="form-check mb-3 {{ $errors->has('enable_paypal_sandbox')? 'is-invalid':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="enable_paypal_sandbox" {{ get_option('enable_paypal_sandbox') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_paypal_sandbox')</label>
            </div>

            <div class="row mb-3 {{ $errors->has('paypal_receiver_email')? 'is-invalid':'' }}">
                <label for="paypal_receiver_email" class="col-sm-4 col-form-label">@lang('app.paypal_receiver_email')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="paypal_receiver_email" value="{{ old('paypal_receiver_email')? old('paypal_receiver_email') : get_option('paypal_receiver_email') }}" name="paypal_receiver_email" placeholder="@lang('app.test_secret_key')">
                    {!! $errors->has('paypal_receiver_email')? '<p class="help-block">'.$errors->first('paypal_receiver_email').'</p>':'' !!}
                    <p class="text-info">@lang('app.paypal_receiver_email_help_text')</p>
                </div>
            </div>

        </div>

        <div id="stripe_settings_wrap" style="display: {{ get_option('enable_stripe') == 1 ? 'block' : 'none' }}">
            <hr />

            <legend>@lang('app.stripe_settings')</legend>

            <div class="form-check mb-3 {{ $errors->has('stripe_test_mode')? 'is-invalid':'' }}">
                <input class="form-check-input" type="checkbox" value="1" name="stripe_test_mode" {{ get_option('stripe_test_mode') == 1 ? 'checked="checked"': '' }}>
                <label class="form-check-label">@lang('app.enable_test_mode')</label>
            </div>

            <div class="row mb-3 {{ $errors->has('stripe_test_secret_key')? 'is-invalid':'' }}">
                <label for="stripe_test_secret_key" class="col-sm-4 col-form-label">@lang('app.test_secret_key')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stripe_test_secret_key" value="{{ old('stripe_test_secret_key')? old('stripe_test_secret_key') : get_option('stripe_test_secret_key') }}" name="stripe_test_secret_key" placeholder="@lang('app.test_secret_key')">
                    {!! $errors->has('stripe_test_secret_key')? '<p class="help-block">'.$errors->first('stripe_test_secret_key').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('stripe_test_publishable_key')? 'is-invalid':'' }}">
                <label for="stripe_test_publishable_key" class="col-sm-4 col-form-label">@lang('app.test_publishable_key')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stripe_test_publishable_key" value="{{ old('stripe_test_publishable_key')? old('stripe_test_publishable_key') : get_option('stripe_test_publishable_key') }}" name="stripe_test_publishable_key" placeholder="@lang('app.test_publishable_key')">
                    {!! $errors->has('stripe_test_publishable_key')? '<p class="help-block">'.$errors->first('stripe_test_publishable_key').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('stripe_live_secret_key')? 'is-invalid':'' }}">
                <label for="stripe_live_secret_key" class="col-sm-4 col-form-label">@lang('app.live_secret_key')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stripe_live_secret_key" value="{{ old('stripe_live_secret_key')? old('stripe_live_secret_key') : get_option('stripe_live_secret_key') }}" name="stripe_live_secret_key" placeholder="@lang('app.live_secret_key')">
                    {!! $errors->has('stripe_live_secret_key')? '<p class="help-block">'.$errors->first('stripe_live_secret_key').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('stripe_live_publishable_key')? 'is-invalid':'' }}">
                <label for="stripe_live_publishable_key" class="col-sm-4 col-form-label">@lang('app.live_publishable_key')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stripe_live_publishable_key" value="{{ old('stripe_live_publishable_key')? old('stripe_live_publishable_key') : get_option('stripe_live_publishable_key') }}" name="stripe_live_publishable_key" placeholder="@lang('app.live_publishable_key')">
                    {!! $errors->has('stripe_live_publishable_key')? '<p class="help-block">'.$errors->first('stripe_live_publishable_key').'</p>':'' !!}
                </div>
            </div>

        </div>

        <div class="bankPaymetWrap" style="display: {{ get_option('enable_bank_transfer') == 1 ? 'block' : 'none' }}">

            <hr />

            <legend>@lang('app.bank_transfer_settings')</legend>

            <div class="row mb-3 {{ $errors->has('bank_swift_code')? 'is-invalid':'' }}">
                <label for="bank_swift_code" class="col-sm-4 col-form-label">@lang('app.bank_swift_code') <span class="field-required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="bank_swift_code" value="{{ get_option('bank_swift_code') }}" name="bank_swift_code" placeholder="@lang('app.bank_swift_code')">
                    {!! $errors->has('bank_swift_code')? '<p class="help-block">'.$errors->first('bank_swift_code').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('account_number')? 'is-invalid':'' }}">
                <label for="account_number" class="col-sm-4 col-form-label">@lang('app.account_number') <span class="field-required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="account_number" value="{{ get_option('account_number') }}" name="account_number" placeholder="@lang('app.account_number')">
                    {!! $errors->has('account_number')? '<p class="help-block">'.$errors->first('account_number').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('branch_name')? 'is-invalid':'' }}">
                <label for="branch_name" class="col-sm-4 col-form-label">@lang('app.branch_name') <span class="field-required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="branch_name" value="{{ get_option('branch_name') }}" name="branch_name" placeholder="@lang('app.branch_name')">
                    {!! $errors->has('branch_name')? '<p class="help-block">'.$errors->first('branch_name').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('branch_address')? 'is-invalid':'' }}">
                <label for="branch_address" class="col-sm-4 col-form-label">@lang('app.branch_address') <span class="field-required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="branch_address" value="{{ get_option('branch_address') }}" name="branch_address" placeholder="@lang('app.branch_address')">
                    {!! $errors->has('branch_address')? '<p class="help-block">'.$errors->first('branch_address').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('account_name')? 'is-invalid':'' }}">
                <label for="account_name" class="col-sm-4 col-form-label">@lang('app.account_name') <span class="field-required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="account_name" value="{{ get_option('account_name') }}" name="account_name" placeholder="@lang('app.account_name')">
                    {!! $errors->has('account_name')? '<p class="help-block">'.$errors->first('account_name').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('iban')? 'is-invalid':'' }}">
                <label for="iban" class="col-sm-4 col-form-label">@lang('app.iban') <span class="field-required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="iban" value="{{ get_option('iban') }}" name="iban" placeholder="@lang('app.iban')">
                    {!! $errors->has('iban')? '<p class="help-block">'.$errors->first('iban').'</p>':'' !!}
                </div>
            </div>

        </div>

        <legend>@lang('app.commission_settings')</legend>

        <div class="row mb-3 {{ $errors->has('campaign_owner_commission')? 'is-invalid':'' }}">
            <label for="campaign_owner_commission" class="col-sm-4 col-form-label">@lang('app.campaign_owner_commission') %</label>
            <div class="col-sm-8">
                <input type="number" class="form-control" id="campaign_owner_commission" value="{{ old('campaign_owner_commission')? old('campaign_owner_commission') : get_option('campaign_owner_commission') }}" max="100" name="campaign_owner_commission" placeholder="@lang('app.commission_percent')">
                {!! $errors->has('campaign_owner_commission')? '<p class="help-block">'.$errors->first('campaign_owner_commission').'</p>':'' !!}
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
                    data: { [input_name]: input_value, '_token': '{{ csrf_token() }}' },
                });
            });

            /**
             * show or hide stripe and paypal settings wrap
             */
            $('#enable_paypal').click(function(){
                if ($(this).prop('checked')){
                    $('#paypal_settings_wrap').slideDown();
                }else{
                    $('#paypal_settings_wrap').slideUp();
                }
            });
            $('#enable_stripe').click(function(){
                if ($(this).prop('checked')){
                    $('#stripe_settings_wrap').slideDown();
                }else{
                    $('#stripe_settings_wrap').slideUp();
                }
            });

            $('#enable_bank_transfer').click(function(){
                if ($(this).prop('checked')){
                    $('.bankPaymetWrap').slideDown();
                }else{
                    $('.bankPaymetWrap').slideUp();
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