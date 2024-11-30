@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/metisMenu/dist/metisMenu.min.css') }}">
	@yield('page-css')
@endsection

@section('content-wrapper')
    @include('layouts.dashboard.partials.header')

    <div id="content-wrap">
	    <div class="dashboard-wrap">
	        <div class="container-fluid">
	            <div id="wrapper" class="row flex-nowrap">
       				<div class="col-auto col-sm-2 px-sm-2 px-0 bg-dark">

	                	@include('layouts.dashboard.partials.menu')
	            	</div>

	                <div id="page-wrapper" class="col py-3">

	                    @if( ! empty($title))
	                        <div class="row">
	                            <div class="col-lg-12 align-items-center justify-content-center text-center">
	                                <h1 class="page-header"> 
	                                	{{ $title }}
	                                	@yield('title_link')
	                                </h1>
	                            </div> <!-- /.col-lg-12 -->
	                        </div> <!-- /.row -->
	                    @endif

	                    @include('layouts.partials.alert')
        				@yield('content')
        			</div>
        		</div>
        	</div>
        </div>
    </div>

    @include('layouts.dashboard.partials.footer')
@stop

@section('scripts')
	<script src="{{ asset('assets/plugins/metisMenu/dist/metisMenu.min.js') }}"></script>
    <script>
        $(function() {
            $('#side-menu').metisMenu();
        });
		window.onload = function(){
			var foot_ht = document.getElementById('footer').offsetHeight;
			var nav_ht = document.getElementById('top_navbar').offsetHeight;
			
			// 20px - padding (t + b) of dashboard wrap
			var minht = window.innerHeight - (foot_ht + nav_ht + 20);
			$('#page-wrapper').css('min-height',minht);
			$('#content-wrap').css('padding-bottom',foot_ht);
		};
    </script>
	@yield('page-js')
@endsection