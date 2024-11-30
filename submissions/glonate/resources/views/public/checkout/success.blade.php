@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="campaign-details-wrap">

        <div class="container">

            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="checkout-wrap">

                        <div class="payment-received">
                            <h1> <i class="fa fa-check-circle-o"></i> @lang('app.payment_thank_you')</h1>
                            <p>@lang('app.payment_receive_successfully')</p>
                            <a href="{{route('browse_categories')}}" class="btn btn-filled">@lang('app.home')</a>
                        </div>

                    </div>

                </div>



            </div>


        </div>

    </section>

@endsection

@section('page-js')


@endsection