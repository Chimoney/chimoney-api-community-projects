@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@php
$auth_user = \Auth::user();
@endphp

@section('content')


    @if($auth_user->is_admin())
        <div class="row">

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-default">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$pending_campaign_count}}</div>
                                <div>@lang('app.pending_campaigns')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$active_campaign_count}}</div>
                                <div>@lang('app.active_campaigns')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-warning">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$blocked_campaign_count}}</div>
                                <div>@lang('app.blocked_campaigns')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$payment_created}}</div>
                                <div>@lang('app.payment_created')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{!! get_amount($payment_amount) !!}</div>
                                <div>@lang('app.total_payments')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card card-green">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$user_count}}</div>
                                <div>@lang('app.users')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">
                                    @php
                                    $campaign_owner_comission = get_option('campaign_owner_commission');
                                    @endphp
                                    {{get_option('campaign_owner_commission')}}%
                                </div>
                                <div>@lang('app.campaign_owner_will_receive')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{100 - $campaign_owner_comission}}%</div>
                                <div>@lang('app.platform_owner_will_receive')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">


            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">
                                    @php
                                    $platform_owner_commission = ( (100 - $campaign_owner_comission) * $payment_amount ) / 100;
                                    @endphp

                                    {!! get_amount($platform_owner_commission) !!}
                                </div>
                                <div>@lang('app.platform_owner_commission')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">
                                    {!! get_amount($payment_amount - $platform_owner_commission) !!}
                                </div>
                                <div>@lang('app.campaign_owner_commission')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 p-2">
                <div class="card bg-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{!! get_amount($pending_payment_amount) !!}</div>
                                <div>@lang('app.pending_payment_amount')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif

    <div class="row">
        <div class="col-md-12 pt-5">
            <div class="card bg-default">
                <div class="card-header">
                    @lang('app.last_pending_campaigns')
                </div>

                @if($pending_campaigns->count() > 0)
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>@lang('app.title')</th>
                                <th>@lang('app.by')</th>
                            </tr>

                            @foreach($pending_campaigns as $pc)
                                <tr>
                                    <td>{{$pc->title}}</td>
                                    <td>{{$pc->user->name}} <br /> {{$pc->user->email}} </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif

            </div>

        </div>
        <div class="col-md-12 pt-5">

            <div class="card bg-default">
                <div class="card-header">
                    @lang('app.last_ten_payment')
                </div>

                <div class="card-body">

                    @if($last_payments->count() > 0)
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>@lang('app.campaign_title')</th>
                                <th>@lang('app.payer_email')</th>
                                <th>@lang('app.amount')</th>
                                <th>@lang('app.time')</th>
                                <th>#</th>
                                <th>#</th>
                            </tr>

                            @foreach($last_payments as $payment)

                                <tr>
                                    <td>
                                        @if($payment->campaign)
                                            <a href="{{route('payment_view', $payment->id)}}">{{$payment->campaign->title}}</a>
                                        @else
                                            @lang('app.campaign_deleted')
                                        @endif
                                    </td>
                                    <td><a href="{{route('payment_view', $payment->id)}}"> {{$payment->email}} </a></td>
                                    <td>{!! get_amount($payment->amount) !!}</td>
                                    <td><span data-toggle="tooltip" title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span></td>

                                    <td>
                                        @if($payment->reward)
                                            <a href="{{route('payment_view', $payment->id)}}" data-toggle="tooltip" title="@lang('app.selected_reward')">
                                                <i class="fa fa-gift"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td><a href="{{route('payment_view', $payment->id)}}"><i class="fa fa-eye"></i> </a></td>

                                </tr>
                            @endforeach

                        </table>

                    @else
                        @lang('app.no_campaigns_to_display')
                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection