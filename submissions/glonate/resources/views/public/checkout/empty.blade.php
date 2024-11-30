@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="checkout-empty">


        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">


                    <div class="checkout-wrap">
                        <h1><i class="fa fa-exclamation-triangle"></i> @lang('app.nothing_in_the_checkout')</h1>
                        <a href="{{route('browse_categories')}}" class="btn btn-lg-filled">@lang('app.browse_campaign')</a>
                    </div>


                </div>

            </div>
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