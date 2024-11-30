@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    @if($withdraw_requests->count() > 0)
        <table class="table table-bordered table-striped">
            <tr>
                <th>@lang('app.campaign')</th>
                <th>@lang('app.method')</th>
                <th>@lang('app.amount')</th>
                <th>@lang('app.status')</th>
                <th>@lang('app.date')</th>
                <th>#</th>
            </tr>

            @foreach($withdraw_requests as $withdraw)
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

    {!! $withdraw_requests->links() !!}

@endsection