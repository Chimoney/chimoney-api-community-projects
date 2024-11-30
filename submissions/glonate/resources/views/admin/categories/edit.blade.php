@extends('layouts.dashboard.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection


@section('content')
    

    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" > @csrf

                <div class="row mb-3 {{ $errors->has('category_name')? 'is-invalid':'' }}">
                    <label for="category_name" class="col-sm-4 col-form-label">@lang('app.category_name')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="category_name" value="{{ $category->category_name }}" name="category_name" placeholder="@lang('app.category_name')">
                        {!! $errors->has('category_name')? '<p class="help-block">'.$errors->first('category_name').'</p>':'' !!}
                    </div>
                </div>


                <div class="row mb-3 {{ $errors->has('image')? 'is-invalid':'' }}">
                    <label for="image" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-4">

                        <img src="{{$category->get_image_url()}}" class="img-responsive img-thumbnail" />

                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('image')? 'is-invalid':'' }}">
                    <label for="image" class="col-sm-4 col-form-label">@lang('app.image')</label>
                    <div class="col-sm-8">


                        <input type="file" name="image" id="image" class="form-control">

                        {!! $errors->has('image')? '<p class="help-block">'.$errors->first('image').'</p>':'' !!}

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-sm-4 col-sm-8">
                        <button type="submit" class="btn btn-primary">@lang('app.save_new_category')</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
    
@endsection

@section('page-js')

@endsection