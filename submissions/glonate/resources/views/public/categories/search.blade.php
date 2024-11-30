@extends('layouts.public.app')

@section('content')

    <section class="home-campaign section-bg-white">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title"> @lang('app.campaigns_search_results') </h2>
                </div>
            </div>

            <div class="row">

                @if($campaigns->count() > 0)
                    <div class="box-campaign-lists">
                        @foreach($campaigns as $spc)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 box-campaign-item p-2">
                                <div class="box-campaign">
                                    <div class="box-campaign-image">
                                        <a href="{{route('campaign_single', [$spc->id, $spc->slug])}}"><img src="{{ $spc->feature_img_url()}}" /></a>

                                    </div>
                                    <div class="box-campaign-content">
                                        <div class="box-campaign-description">
                                            <h4><a href="{{route('campaign_single', [$spc->id, $spc->slug])}}"> {{$spc->title}} </a> </h4>
                                            <p>{{$spc->short_description}}</p>
                                        </div>

                                        <div class="box-campaign-summery">
                                            <ul>
                                                <li><strong>{{$spc->days_left()}}</strong> @lang('app.days_left')</li>
                                                <li><strong>{{$spc->total_payments}}</strong> @lang('app.backers')</li>
                                                <li><strong>{!! get_amount($spc->total_raised()) !!}</strong> @lang('app.funded')</li>
                                            </ul>
                                        </div>

                                        <div class="progress">
                                            @php
                                            $percent_raised = $spc->percent_raised();
                                            @endphp
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$percent_raised}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent_raised <= 100 ? $percent_raised : 100}}%;">
                                                {{$percent_raised}}%
                                            </div>
                                        </div>

                                        <div class="box-campaign-footer">
                                            <!--<ul>
                                        <li><img src="{{ asset('assets/images/avatar.png') }}"> John Doe</li>
                                        <li> <strong>$12,000.00</strong> Goal </li>
                                    </ul>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>  <!-- #box-campaign-lists -->

                @else
                    <div class="payment-received">
                        <h1><i class="fa fa-exclamation-triangle"></i> @lang('app.no_campaigns_to_display')</h1>
                        <a href="{{route('browse_categories')}}" class="btn btn-lg-filled">@lang('app.browse_campaign')</a>
                    </div>
                @endif
            </div>
            <div class="row">

                {{$campaigns->appends(['q' => $q])->links()}}
            </div>

        </div><!-- /.container -->

    </section>

@endsection
