@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" > @csrf

                <div class="row mb-3 {{ $errors->has('old_password')? 'is-invalid' : '' }}">
                    <label class="col-sm-3 col-form-label" for="old_password">@lang('app.old_password') *</label>
                    <div class="col-sm-9">
                        <input type="password" name="old_password" id="old_password" class="form-control" value="" autocomplete="off" placeholder="@lang('app.old_password') " />
                        {!! $errors->has('old_password')? '<p class="help-block"> '.$errors->first('old_password').' </p>':'' !!}
                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('new_password')? 'is-invalid' : '' }}">
                    <label class="col-sm-3 col-form-label" for="new_password">@lang('app.new_password') *</label>
                    <div class="col-sm-9">
                        <input type="password" name="new_password" id="new_password" class="form-control" value="" autocomplete="off" placeholder="@lang('app.new_password')" />
                        {!! $errors->has('new_password')? '<p class="help-block"> '.$errors->first('new_password').' </p>':'' !!}
                    </div>
                </div>

                <div class="row mb-3 {{ $errors->has('new_password_confirmation')? 'is-invalid' : '' }}">
                    <label class="col-sm-3 col-form-label" for="new_password_confirmation">@lang('app.new_password_confirmation') *</label>
                    <div class="col-sm-9">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" value="" autocomplete="off" placeholder="@lang('app.new_password_confirmation')" />
                        {!! $errors->has('new_password_confirmation')? '<p class="help-block"> '.$errors->first('new_password_confirmation').' </p>':'' !!}
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="offset-md-3 col-md-10">
                        <button type="submit" class="btn btn-info">@lang('app.change_password')</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
@endsection

@section('page-js')

@endsection