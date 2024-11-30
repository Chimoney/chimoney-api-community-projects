<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="icon" href="../../favicon.ico">

	    <!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">

	    <title> @yield('title') {{ get_option('site_title') }} @show </title>

	    @yield('meta-data')

	    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

	    <!-- Font awesome 4.4.0 -->
	    <link rel="stylesheet" href="{{ asset('assets/font-awesome-4.4.0/css/font-awesome.min.css') }}">
	    <!-- load page specific css -->

	    <!-- main select2.css -->
	    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
	    <!-- main style.css -->

        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
	    @yield('styles')
        
        @if(get_option('additional_css'))
            <style type="text/css">
                {{ get_option('additional_css') }}
            </style>
        @endif
        
        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        </script>
	</head>
	<body>
	    <div id="app" class="page-container">
	            @yield('content-wrapper')
		</div>

		<!-- Scripts -->
		<script src="{{ asset('assets/js/jquery-1.11.2.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

		<script>
		    var toastr_options = {closeButton : true};
		    $('.cookie-ok-btn').click(function(e){
		        e.preventDefault();
		        var element = $(this);
		        $.ajax({
		            type : 'post',
		            url : '{{route('cookie_accept')}}',
		            data: {cookie_accept: true, _token : '{{csrf_token()}}'},
		            success: function(data){
		                if (data.accept_cookie){
		                    element.closest('.cookie-notice').slideUp();
		                }
		            }
		        });
		    });

		</script>
		@yield('scripts')

		@if(get_option('additional_js') && get_option('additional_js') !== 'additional_js')
		{!! get_option('additional_js') !!}
		@endif

	</body>
</html>
