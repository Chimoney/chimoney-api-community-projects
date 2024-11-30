@extends('layouts.dashboard.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <div class="row">
        <div class="col-sm-8 offset-sm-1 col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" >                                @csrf

            <div class="row mb-3 {{ $errors->has('title')? 'is-invalid':'' }}">
                <label for="title" class="col-sm-4 col-form-label">@lang('app.title')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="title" value="{{ $update->title }}" name="title" placeholder="@lang('app.title')">
                    {!! $errors->has('title')? '<p class="help-block">'.$errors->first('title').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('description')? 'is-invalid':'' }}">
                <label for="description" class="col-sm-4 col-form-label">@lang('app.description')</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="description">{{$update->description}}</textarea>
                    {!! $errors->has('description')? '<p class="help-block">'.$errors->first('description').'</p>':'' !!}
                </div>
            </div>


            <div class="row mb-3">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">@lang('app.save_update')</button>
                </div>
            </div>
            </form>

        </div>

    </div>
@endsection