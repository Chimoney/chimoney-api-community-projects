@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="campaign-details-wrap">
        @include('public.campaigns.partials.header')
        <div class="container">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" >                                @csrf
            <div class="row">
                <div class="col-md-8">

                    <div class="checkout-wrap">

                        <div class="contributing-to">
                            <p class="contributing-to-name"><strong> @lang('app.you_are_contributing_to') {{$campaign->user->name}}</strong></p>
                            <h3>{{$campaign->title}}</h3>

                            @if( ! Auth::check())
                                <p class="guest_checkout_text"><strong> @lang('app.guest_checkout') <span class="text-muted">@lang('app.or')</span> <a href="{{route('login')}}">@lang('app.log_in')</a> </strong></p>
                            @endif
                        </div>

                        <div class="row mb-3 {{ $errors->has('full_name')? 'is-invalid':'' }}">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="full_name" value="@if(Auth::check()){{auth()->user()->name}}@else{{ old('full_name') }}@endif" name="full_name" placeholder="@lang('app.full_name')">
                                {!! $errors->has('full_name')? '<p class="help-block">'.$errors->first('full_name').'</p>':'' !!}
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="email" value="@if(Auth::check()){{auth()->user()->email}}@else{{ old('email') }}@endif" name="email" placeholder="@lang('app.email')">
                                {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}
                            </div>
                        </div>

                        <p>
                            <strong>@lang('app.contribution_appearance')</strong> <br />
                            @lang('app.name_displayed_publicly')
                        </p>

                        <div class="row mb-3 {{ $errors->has('contributor_name_display')? 'is-invalid':'' }}">
                            <div class="col-sm-12">
                                <div class="name_display_wrap">

                                    <label>
                                        <input type="radio" name="contributor_name_display" value="full_name" checked="checked" > @lang('app.full_name')
                                    </label>

                                    <label>
                                        <input type="radio" name="contributor_name_display" value="anonymous"> @lang('app.anonymous')
                                    </label>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="donation-summery">

                        <div class="card card-default">

                            <div class="card-header">
                                <h4 class="text-center">Summary</h4>
                            </div>

                            <div class="card-body">

                                @php
                                    if(session('cart.cart_type') == 'reward'){
                                    $donation_amount = $reward->amount;
                                    }else{
                                    $donation_amount = session('cart.amount');
                                    }
                                @endphp

                                <table class="table border-none">
                                    <tr>
                                        <td class="border-none">@lang('app.donation') : {{$campaign->title}}</td>
                                        <td class="border-none">{!! get_amount($donation_amount) !!}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('app.total')</th>
                                        <th>{!! get_amount($donation_amount) !!}</th>
                                    </tr>
                                </table>


                                @if(session('cart.cart_type') == 'reward')
                                    <div class="reward-box">
                                        <h4>@lang('app.selected_reward')</h4>

                                        <a href="javascript:;">
                                            <span class="reward-amount">@lang('app.pledge') <strong>{!! get_amount($reward->amount) !!}</strong></span>
                                            <span class="reward-text">{{$reward->description}}</span>
                                            <span class="reward-estimated-delivery"> @lang('app.estimated_delivery'): {{date('F Y', strtotime($reward->estimated_delivery))}}</span>
                                        </a>
                                    </div>
                                @endif

                                <p class="text-muted"> @lang('app.agree_terms_policy') </p>

                                <button type="submit" class="d-block w-100 btn btn-primary btn-lg">@lang('app.submit_payment')</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            </form>

        </div>

    </section>

@endsection

@section('page-js')

    <script>
        $(function(){
            $(document).on('click', '.donate-amount-placeholder ul li', function(e){
                $(this).closest('form').find($('[name="amount"]')).val($(this).data('value'));
            });
        });
    </script>

@endsection