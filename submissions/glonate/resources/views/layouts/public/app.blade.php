@extends('layouts.app')

@section('styles')
    @yield('page-css')
@endsection

@section('content-wrapper')

    <div id="content-wrap">
        @include('layouts.public.partials.header')
        @yield('content')
    </div>

    @include('layouts.public.partials.footer')
@stop

@section('scripts')
    <script>
        window.onload = function(){
            var ht = document.getElementById('footer').offsetHeight;
            $('#content-wrap').css('padding-bottom',ht);
        };
    </script>
    @yield('page-js')
@endsection