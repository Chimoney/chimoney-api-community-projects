@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <div class="admin-campaign-lists">

        <div class="row">
            <div class="col-md-5">

            </div>

            <div class="col-md-7">

                <form class="form-inline" method="get" action="">
                    <div class="form-group">
                        <input type="text" name="q" value="{{request('q')}}" class="form-control" placeholder="@lang('app.payer_email')">
                    </div>
                    <button type="submit" class="btn btn-default">@lang('app.search')</button>
                </form>

            </div>
        </div>

    </div>

    <table class="table table-striped table-bordered">
        <tr>
            <th>@lang('app.campaign_title')</th>
            <td>{{$payment->campaign->title}}</td>
        </tr>

        <tr>
            <th>@lang('app.payer_name')</th>
            <td>{{$payment->name}}</td>
        </tr>
        <tr>
            <th>@lang('app.payer_email')</th>
            <td>{{$payment->email}}</td>
        </tr>

        <tr>
            <th>@lang('app.amount')</th>
            <td>{!! get_amount($payment->amount) !!}</td>
        </tr>

        <tr>
            <th>@lang('app.method')</th>
            <td>{{$payment->payment_method}}</td>
        </tr>

        <tr>
            <th>@lang('app.currency')</th>
            <td>{{$payment->currency}}</td>
        </tr>

        @if($payment->payment_method == 'stripe')

            <tr>
                <th>@lang('app.card_last4')</th>
                <td>{{$payment->card_last4}}</td>
            </tr>

            <tr>
                <th>@lang('app.card_id')</th>
                <td>{{$payment->card_id}}</td>
            </tr>

            <tr>
                <th>@lang('app.card_brand')</th>
                <td>{{$payment->card_brand}}</td>
            </tr>

            <tr>
                <th>@lang('app.card_expire')</th>
                <td>{{$payment->card_exp_month}},{{$payment->card_exp_year}}</td>
            </tr>

        @endif

        <tr>
            <th>@lang('app.gateway_transaction_id')</th>
            <td>{{$payment->charge_id_or_token}}</td>
        </tr>

        @if($payment->payment_method == 'bank_transfer')
            <tr>
                <th colspan="2"><h4>@lang('app.bank_transfer_information')</h4></th>
            </tr>
            <tr>
                <th>@lang('app.bank_swift_code')</th>
                <td>{{$payment->bank_swift_code}}</td>
            </tr>

            <tr>
                <th>@lang('app.account_number')</th>
                <td>{{$payment->account_number}}</td>
            </tr>

            <tr>
                <th>@lang('app.branch_name')</th>
                <td>{{$payment->branch_name}}</td>
            </tr>

            <tr>
                <th>@lang('app.branch_address')</th>
                <td>{{$payment->branch_address}}</td>
            </tr>

            <tr>
                <th>@lang('app.account_name')</th>
                <td>{{$payment->account_name}}</td>
            </tr>

            <tr>
                <th>@lang('app.iban')</th>
                <td>{{$payment->iban}}</td>
            </tr>
        @endif

        <tr>
            <th>@lang('app.time')</th>
            <td>{{$payment->created_at->format('F d, Y h:i a')}}</td>
        </tr>
    </table>


    @if($payment->reward)
        <h3>@lang('app.selected_reward')</h3>
        <table class="table table-striped table-bordered">
            <tr>
                <th>@lang('app.amount')</th>
                <td>{!! get_amount($payment->reward->amount) !!}</td>
            </tr>
            <tr>
                <th>@lang('app.description')</th>
                <td>{{$payment->reward->description}}</td>
            </tr>
            <tr>
                <th>@lang('app.estimated_delivery')</th>
                <td>{{$payment->reward->estimated_delivery}}</td>
            </tr>
        </table>
    @endif


    @if($payment->status != 'success')
        <a href="{{route('status_change', [$payment->id, 'success'] )}}" class="btn btn-success"><i class="fa fa-check-circle-o"></i> @lang('app.mark_as_success') </a>
    @endif

@endsection