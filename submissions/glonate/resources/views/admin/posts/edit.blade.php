@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('title_link') 
    <a href="{{ route('create_new_page') }}" class="btn btn-info pull-right"> <i class="fa fa-floppy-o"></i> @lang('app.create_new_page')</a>
@endsection

@section('content')


    <div class="row">
        <div class="col-xs-12">

            <form action="" class="form-horizontal" method="post" > @csrf

            <div class="row mb-3 {{ $errors->has('title')? 'is-invalid':'' }}">
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="title" value="{{ old('title')?old('title'): $page->title }}" name="title" placeholder="@lang('app.title')">
                    {!! $errors->has('title')? '<p class="help-block">'.$errors->first('title').'</p>':'' !!}
                </div>
            </div>


            <div class="row mb-3 {{ $errors->has('post_content')? 'is-invalid':'' }}">
                <div class="col-sm-12">
                    <textarea name="post_content" id="post_content" class="form-control description">{!!  old('post_content')? old('post_content'): $page->post_content !!}</textarea>
                    {!! $errors->has('post_content')? '<p class="help-block">'.$errors->first('post_content').'</p>':'' !!}
                </div>
            </div>



            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check1" name="show_in_header_menu" value="1" {{ $page->show_in_header_menu? 'checked':'' }}>
                        <label class="form-check-label">@lang('app.show_in_header_menu')</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="show_in_footer_menu"  {{ $page->show_in_footer_menu? 'checked':'' }}>
                        <label class="form-check-label">@lang('app.show_in_footer_menu')</label>
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary">@lang('app.update_page')</button>
                </div>
            </div>
            </form>

        </div>

    </div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replaceClass = 'description';
        });
    </script>
@endsection