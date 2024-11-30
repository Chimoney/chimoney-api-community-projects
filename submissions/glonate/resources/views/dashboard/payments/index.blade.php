@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('title_link') 
    <a class="btn btn-primary pull-right" href="{{route('payments_pending')}}">@lang('app.pending_payments')</a>
@endsection

@section('content')

    <div class="admin-campaign-lists">

        <div class="row">
            <div class="col-md-5">
                @lang('app.total') : {{$payments->count()}}
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

    @if($payments->count() > 0)
        <table class="table table-striped table-bordered">

            <tr>
                <th>@lang('app.campaign_title')</th>
                <th>@lang('app.payer_email')</th>
                <th>@lang('app.amount')</th>
                <th>@lang('app.method')</th>
                <th>@lang('app.time')</th>
                <th>#</th>
                <th>#</th>
                <th width="90">#</th>
            </tr>

            @foreach($payments as $payment)
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
                    <td>{{$payment->payment_method}}</td>
                    <td><span data-toggle="tooltip" title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span></td>

                    <td>
                        @if($payment->reward)
                            <a href="{{route('payment_view', $payment->id)}}" data-toggle="tooltip" title="@lang('app.selected_reward')">
                                <i class="fa fa-gift"></i>
                            </a>
                        @endif
                    </td>
                    <td>
                        @if($payment->status == 'success')
                            <span class="text-success" data-toggle="tooltip" title="{{$payment->status}}"><i class="fa fa-check-circle-o"></i> </span>
                        @else
                            <span class="text-warning" data-toggle="tooltip" title="{{$payment->status}}"><i class="fa fa-exclamation-circle"></i> </span>
                        @endif

                    </td>
                    <td>
                        <a href="{{route('payment_view', $payment->id)}}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> </a>

                        <a href="{{route('payment_delete', $payment->id)}}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> </a>
                    </td>

                </tr>
            @endforeach

        </table>

        {!! $payments->links() !!}

    @else
        @lang('app.no_data')
    @endif

@endsection