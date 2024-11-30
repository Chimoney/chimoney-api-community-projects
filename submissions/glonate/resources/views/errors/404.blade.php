@extends('layouts.public.app')
@section('title') @lang('app.not_found_404') | @parent @endsection

@section('content')

    <section class="categories-wrap wrap-404"> <!-- explore categories -->
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h1>404</h1>
                    <h2><i class="fa fa-info-circle"></i> @lang('app.not_found_404')</h2>
                </div>
            </div>

        </div>
    </section> <!-- #explore categories -->

@endsection
