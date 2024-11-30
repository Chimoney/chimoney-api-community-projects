@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 carousel">
                    <h1 class="section-title">{!! get_option('banner_main_header') !!}</h1>
                    <p class="jumbotron-sub-text">{!! get_option('banner_sub_header') !!}</p>

                    <div class="jumbotron-button-wrap">
                        <a class="btn btn-lg-outline" href="{{route('browse_categories')}}">@lang('app.support_campaigns')</a>
                        <a class="btn btn-lg-filled" href="{{route('start_campaign')}}">@lang('app.start_crowdfunding')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="home-campaign section-bg-white">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">@lang('app.why_choose_us') </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="title">
                            <h4>@lang('app.secure')</h4>
                        </div>
                        <div class="desc">
                            <p>@lang('app.secure_desc')</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-history"></i>
                        </div>
                        <div class="title">
                            <h4>@lang('app.flexible')</h4>
                        </div>
                        <div class="desc">
                            <p>@lang('app.flexible_desc')</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <div class="title">
                            <h4>@lang('app.easy')</h4>
                        </div>
                        <div class="desc">
                            <p>@lang('app.easy_desc')</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-gift"></i>
                        </div>
                        <div class="title">
                            <h4>@lang('app.supports_reward')</h4>
                        </div>
                        <div class="desc">
                            <p>@lang('app.supports_reward_desc')</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="home-campaign section-bg-gray"> <!-- explore categories -->
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">@lang('app.explore_categories') </h2>
                </div>
            </div>

            <div class="row">
                @foreach($categories as $cat)
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="home-category-box">
                            <img src="{{ $cat->get_image_url() }}" />
                            <div class="title">
                                <a href="{{route('single_category', [$cat->id, $cat->category_slug])}}">{{ $cat->category_name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="section-footer">
                        <a href="{{route('browse_categories')}}" class="section-action-btn">@lang('app.see_all')</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @if($new_campaigns->count())
        <section class="home-campaign section-bg-gray new-home-campaigns">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title"> @lang('app.new_campaigns') </h2>
                    </div>
                </div>

                <div class="row">
                    <div class="box-campaign-lists">

                        @foreach($new_campaigns as $nc)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 box-campaign-item p-2">
                                <div class="box-campaign">
                                    <div class="box-campaign-image">
                                        <a href="{{route('campaign_single', [$nc->id, $nc->slug])}}"><img src="{{ $nc->feature_img_url()}}" /> </a>
                                    </div>
                                    <div class="box-campaign-content">
                                        <div class="box-campaign-description">
                                            <h4><a href="{{route('campaign_single', [$nc->id, $nc->slug])}}"> {{$nc->title}} </a> </h4>
                                            <p>{{$nc->short_description}}</p>
                                        </div>

                                        <div class="box-campaign-summery">
                                            <ul>
                                                <li><strong>{{$nc->days_left()}}</strong> @lang('app.days_left')</li>
                                                <li><strong>{{$nc->total_payments}}</strong> @lang('app.backers')</li>
                                                <li><strong>{!! get_amount($nc->total_raised()) !!}</strong> @lang('app.funded')</li>
                                            </ul>
                                        </div>

                                        <div class="progress">
                                            @php
                                                $percent_raised = $nc->percent_raised();
                                            @endphp
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$percent_raised}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent_raised <= 100 ? $percent_raised : 100}}%;">
                                                {{$percent_raised}}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>  <!-- #box-campaign-lists -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="section-footer">
                            @if($new_campaigns->nextPageUrl())
                                <a href="{{$new_campaigns->nextPageUrl()}}" class="section-action-btn loadMorePagination"> <span id="load_more_indicator"></span> @lang('app.load_more')</a>
                            @else
                                <a href="javascript:;" class="section-action-btn" onclick="return alert('@lang('app.no_more_results')')"> <span></span> @lang('app.no_more_results')</a>
                            @endif

                        </div>
                    </div>
                </div>


            </div><!-- /.container -->
        </section>
    @endif

    @if($funded_campaigns->count())
        <section class="home-campaign section-bg-white">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title"> @lang('app.recently_funded_campaigns') </h2>
                    </div>
                </div>

                <div class="row">
                    <div class="box-campaign-lists">

                        @foreach($funded_campaigns as $fc)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 box-campaign-item p-2">
                                <div class="box-campaign">
                                    <div class="box-campaign-image">
                                        <a href="{{route('campaign_single', [$fc->id, $fc->slug])}}"><img src="{{ $fc->feature_img_url()}}" /> </a>
                                    </div>
                                    <div class="box-campaign-content">
                                        <div class="box-campaign-description">
                                            <h4><a href="{{route('campaign_single', [$fc->id, $fc->slug])}}"> {{$fc->title}} </a> </h4>
                                            <p>{{$fc->short_description}}</p>
                                        </div>

                                        <div class="box-campaign-summery">
                                            <ul>
                                                <li><strong>{{$fc->days_left()}}</strong> @lang('app.days_left')</li>
                                                <li><strong>{{$fc->total_payments}}</strong> @lang('app.backers')</li>
                                                <li><strong>{!! get_amount($fc->total_raised()) !!}</strong> @lang('app.funded')</li>
                                            </ul>
                                        </div>

                                        <div class="progress">
                                            @php
                                                $percent_raised = $fc->percent_raised();
                                            @endphp
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$percent_raised}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent_raised <= 100 ? $percent_raised : 100}}%;">
                                                {{$percent_raised}}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>  <!-- #box-campaign-lists -->
                </div>

            </div><!-- /.container -->
        </section>
    @endif

    <section class="footer-campaign-stats">
        <div class="container">
            <div class="row">
                <div class="col-md-4"><h3>{{$campaigns_count}}</h3> <h4>@lang('app.campaigns')</h4></div>
                <div class="col-md-4"> <h3>{!! get_amount($fund_raised_count) !!}</h3> <h4>@lang('app.funds_raised')</h4></div>
                <div class="col-md-4"><h3>{{$users_count}}</h3> <h4>@lang('app.users')</h4></div>
            </div>
        </div>
    </section>

    @include('layouts.public.partials.get_start_section')

@endsection

@section('page-js')

    <script type="text/javascript">

        $(document).ready(function(){
            $(document).on('click', '.loadMorePagination', function (e) {
                e.preventDefault();
                var anchor = $(this);
                var page_number = anchor.attr('href').split('page=')[1];
                var new_page = parseInt(page_number) + 1;

                //Show Indicator
                $('#load_more_indicator').html('<i class="fa fa-spin fa-spinner"></i>');

                $.get( "{{route('new_campaigns_ajax')}}?page="+page_number, function( data ) {
                    if( ! data.hasOwnProperty('success')){
                        anchor.attr('href',  "{{route('new_campaigns_ajax')}}?page="+new_page);
                        var el = jQuery(data);
                       $( ".new-home-campaigns .box-campaign-lists" ).append( el );
                    }else{
                        anchor.html('@lang('app.no_more_results')');
                    }

                    //Hide
                    $('#load_more_indicator').html('');

                });

            });
        });
    </script>


@endsection