@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <table class="table table-bordered table-striped">
        <tr>
            <th>@lang('app.campaign_title')</th>
            <th>@lang('app.raised')</th>
            <th>@lang('app.your_commission')</th>
            <th>@lang('app.action')</th>
        </tr>

        @foreach($campaigns as $campaign)
            <tr>
                <td> <a href="{{route('campaign_single', [$campaign->id, $campaign->slug])}}" target="_blank"> {{$campaign->title}} </a> </td>
                <td>{!! get_amount($campaign->amount_raised()->amount_raised) !!}</td>
                <td>{!! get_amount($campaign->amount_raised()->campaign_owner_commission) !!} ({{$campaign->campaign_owner_commission}}%)</td>

                <td>
                    @if($campaign->is_ended())
                        @if($campaign->requested_withdrawal)
                            {{$campaign->requested_withdrawal->status}}
                        @else
                            <a href="javascript:;" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#{{$campaign->id}}-withdraw-modal">
                                @lang('app.withdraw')
                            </a>
                        @endif
                    @else
                        @lang('app.running')
                    @endif

                </td>
            </tr>
        @endforeach
    </table>

    @if($withdrawal_requests->count() > 0)
        <h3>@lang('app.all_withdrawals')</h3>

        <table class="table table-bordered table-striped">

            <tr>
                <th>@lang('app.campaign')</th>
                <th>@lang('app.method')</th>
                <th>@lang('app.amount')</th>
                <th>@lang('app.status')</th>
                <th>@lang('app.date')</th>
                <th>#</th>
            </tr>


            @foreach($withdrawal_requests as $withdraw)

            <tr>
                <td> @if($withdraw->campaign) {{$withdraw->campaign->title }} @endif</td>
                <td>{{$withdraw->withdrawal_account}}</td>
                <td>{!! get_amount($withdraw->withdrawal_amount) !!}</td>
                <td>{{$withdraw->status}}</td>
                <td>{{$withdraw->created_at->format('jS F, Y')}}</td>
                <td><a href="{{route('withdraw_request_view', $withdraw->id)}}" class="btn-link"><i class="fa fa-eye"></i> </a> </td>
            </tr>
            @endforeach


        </table>

    @endif

    @foreach($campaigns as $campaign)

        <div class="modal fade" id="{{$campaign->id}}-withdraw-modal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">@lang('app.your_withdraw_amount') <strong>{!! get_amount($campaign->amount_raised()->campaign_owner_commission) !!}</strong> </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <h4>@lang('app.default_withdrawal_account'): <strong>{{withdrawal_preference()}}</strong>
                            <a href="{{route('withdrawal_preference')}}" class="btn xs btn-link">@lang('app.update') </a>
                        </h4>

                        <h5>@lang('app.withdrawal_method_details')</h5>


                        <table class="table table-bordered table-striped">

                            @if(withdrawal_preference() == 'paypal')
                                <tr>
                                    <th>@lang('app.paypal_email')</th>
                                    <td>{{withdrawal_preference('paypal_email')}}</td>
                                </tr>
                            @elseif(withdrawal_preference() == 'bank')
                                <tr>
                                    <th>@lang('app.bank_account_holders_name')</th>
                                    <td>{{withdrawal_preference('bank_account_holders_name')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.bank_account_number')</th>
                                    <td>{{withdrawal_preference('bank_account_number')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.swift_code')</th>
                                    <td>{{withdrawal_preference('swift_code')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.bank_name_full')</th>
                                    <td>{{withdrawal_preference('bank_name_full')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.bank_branch_name')</th>
                                    <td>{{withdrawal_preference('bank_branch_name')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.bank_branch_city')</th>
                                    <td>{{withdrawal_preference('bank_branch_city')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.bank_branch_address')</th>
                                    <td>{{withdrawal_preference('bank_branch_address')}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('app.country')</th>
                                    <td>{{withdrawal_preference('country_name')}}</td>
                                </tr>

                            @endif

                        </table>

                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="puul-left btn btn-default" data-bs-dismiss="modal">Close</button>
                            </div>

                            <div class="col-md-6">
                                <form action="" method="post" > @csrf

                                <input type="hidden" name="withdrawal_campaign_id" value="{{$campaign->id}}" />
                                <button type="submit" class="btn btn-primary">@lang('app.submit_request')</button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endforeach


@endsection