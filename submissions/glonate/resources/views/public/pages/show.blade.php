@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="categories-wrap"> <!-- explore categories -->
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title"> {{$page->title}} </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    {!! safe_output($page->post_content) !!}
                </div>
            </div>

        </div>
    </section> <!-- #explore categories -->

@endsection
