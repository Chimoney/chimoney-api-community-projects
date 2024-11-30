@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" > @csrf


            <div class="row mb-3 {{ $errors->has('default_withdrawal_account')? 'is-invalid':'' }}">
                <label for="email_address" class="col-sm-4 col-form-label">@lang('app.default_withdrawal_account')</label>
                <div class="col-sm-8">
                    <fieldset>
                        <label><input type="radio" id="default_paypal" value="paypal" name="default_withdrawal_account" @if(withdrawal_preference() == 'paypal') checked="checked" @endif > @lang('app.paypal') </label> <br />
                        <label><input type="radio" id="default_bank" value="bank" name="default_withdrawal_account" @if(withdrawal_preference() == 'bank') checked="checked" @endif > @lang('app.bank') </label> <br />
                    </fieldset>

                    {!! $errors->has('default_withdrawal_account')? '<p class="help-block">'.$errors->first('default_withdrawal_account').'</p>':'' !!}

                </div>
            </div>

            <hr />


            <div class="config_wrap paypal-wrap" style="display: @if(withdrawal_preference() == 'paypal') block @else none @endif;">

                <div class="row mb-3 {{ $errors->has('paypal_email')? 'is-invalid':'' }}">
                    <label for="paypal_email" class="col-sm-4 col-form-label">@lang('app.paypal_email')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="paypal_email" value="{{ withdrawal_preference('paypal_email') }}" name="paypal_email" placeholder="@lang('app.paypal_email')">
                        {!! $errors->has('paypal_email')? '<p class="help-block">'.$errors->first('paypal_email').'</p>':'' !!}
                    </div>
                </div>

            </div>


            <div class="config_wrap bank-wrap" style="display: @if(withdrawal_preference() == 'bank') block @else none @endif;" >


                <div class="row mb-3 {{ $errors->has('bank_account_holders_name')? 'is-invalid':'' }}">
                    <label for="bank_account_holders_name" class="col-sm-4 col-form-label">@lang('app.bank_account_holders_name')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_account_holders_name" value="{{ withdrawal_preference('bank_account_holders_name') }}" name="bank_account_holders_name" placeholder="@lang('app.bank_account_holders_name')">
                        {!! $errors->has('bank_account_holders_name')? '<p class="help-block">'.$errors->first('bank_account_holders_name').'</p>':'' !!}
                    </div>
                </div>


                <div class="row mb-3 {{ $errors->has('bank_account_number')? 'is-invalid':'' }}">
                    <label for="bank_account_number" class="col-sm-4 col-form-label">@lang('app.bank_account_number')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_account_number" value="{{ withdrawal_preference('bank_account_number') }}" name="bank_account_number" placeholder="@lang('app.bank_account_number')">
                        {!! $errors->has('bank_account_number')? '<p class="help-block">'.$errors->first('bank_account_number').'</p>':'' !!}
                    </div>
                </div>


                <div class="row mb-3 {{ $errors->has('swift_code')? 'is-invalid':'' }}">
                    <label for="swift_code" class="col-sm-4 col-form-label">@lang('app.swift_code')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="swift_code" value="{{ withdrawal_preference('swift_code') }}" name="swift_code" placeholder="@lang('app.swift_code')">
                        {!! $errors->has('swift_code')? '<p class="help-block">'.$errors->first('swift_code').'</p>':'' !!}
                    </div>
                </div>


                <div class="row mb-3 {{ $errors->has('bank_name_full')? 'is-invalid':'' }}">
                    <label for="bank_name_full" class="col-sm-4 col-form-label">@lang('app.bank_name_full')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_name_full" value="{{ withdrawal_preference('bank_name_full') }}" name="bank_name_full" placeholder="@lang('app.bank_name_full')">
                        {!! $errors->has('bank_name_full')? '<p class="help-block">'.$errors->first('bank_name_full').'</p>':'' !!}
                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('bank_branch_name')? 'is-invalid':'' }}">
                    <label for="bank_branch_name" class="col-sm-4 col-form-label">@lang('app.bank_branch_name')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_branch_name" value="{{ withdrawal_preference('bank_branch_name') }}" name="bank_branch_name" placeholder="@lang('app.bank_branch_name')">
                        {!! $errors->has('bank_branch_name')? '<p class="help-block">'.$errors->first('bank_branch_name').'</p>':'' !!}
                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('bank_branch_city')? 'is-invalid':'' }}">
                    <label for="bank_branch_city" class="col-sm-4 col-form-label">@lang('app.bank_branch_city')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_branch_city" value="{{ withdrawal_preference('bank_branch_city') }}" name="bank_branch_city" placeholder="@lang('app.bank_branch_city')">
                        {!! $errors->has('bank_branch_city')? '<p class="help-block">'.$errors->first('bank_branch_city').'</p>':'' !!}
                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('bank_branch_address')? 'is-invalid':'' }}">
                    <label for="bank_branch_address" class="col-sm-4 col-form-label">@lang('app.bank_branch_address')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_branch_address" value="{{ withdrawal_preference('bank_branch_address') }}" name="bank_branch_address" placeholder="@lang('app.bank_branch_address')">
                        {!! $errors->has('bank_branch_address')? '<p class="help-block">'.$errors->first('bank_branch_address').'</p>':'' !!}
                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('country_id')? 'is-invalid':'' }}">
                    <label for="phone" class="col-sm-4 col-form-label">@lang('app.country')</label>
                    <div class="col-sm-8">
                        <select id="country_id" name="country_id" class="form-control select2">
                            <option value="">@lang('app.select_a_country')</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ withdrawal_preference('country_id') == $country->id ? 'selected' :'' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        {!! $errors->has('country_id')? '<p class="help-block">'.$errors->first('country_id').'</p>':'' !!}
                    </div>
                </div>

            </div>


            <div class="row mb-3">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary">@lang('app.update')</button>
                </div>
            </div>

            </form>

        </div>
    </div>
@endsection

@section('page-js')
    <script>
        $(document).ready(function(){
            /**
             * show or hide stripe and paypal settings wrap
             */
            $('[name="default_withdrawal_account"]').click(function(){
                $preference = $(this).val();
                $('.config_wrap').hide();
                $('.'+$preference+'-wrap').show();
            });
        });
    </script>

@endsection