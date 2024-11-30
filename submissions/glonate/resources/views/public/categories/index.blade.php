@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="categories-wrap"> <!-- explore categories -->
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title"> @lang('app.find_campaign_fund_them')  </h2>
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

        </div>
    </section> <!-- #explore categories -->

@endsection
