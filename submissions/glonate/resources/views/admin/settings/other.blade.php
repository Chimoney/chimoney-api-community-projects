@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" > @csrf

            <div class="row mb-3 {{ $errors->has('logo')? 'is-invalid':'' }}">
                <label class="col-sm-4 col-form-label">@lang('app.site_logo')</label>
                <div class="col-sm-8">

                    @if(logo_url())
                        <img src="{{ logo_url() }}" />
                    @endif


                    <input type="file" id="logo" name="logo" class="filestyle" >
                    {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                </div>
            </div>


            <hr />

            <div class="row mb-3">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary">@lang('app.edit')</button>
                </div>
            </div>

            </form>

        </div>
    </div>
@endsection

@section('page-js')


@endsection