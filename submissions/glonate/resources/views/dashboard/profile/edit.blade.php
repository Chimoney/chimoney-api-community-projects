@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" > @csrf
            <div class="row mb-3 {{ $errors->has('name')? 'is-invalid':'' }}">
                <label for="name" class="col-sm-4 col-form-label">@lang('app.name')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" value="{{ old('name')? old('name') : $user->name }}" name="name" placeholder="@lang('app.name')">
                    {!! $errors->has('name')? '<p class="help-block">'.$errors->first('name').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('email')? 'is-invalid':'' }}">
                <label for="email" class="col-sm-4 col-form-label">@lang('app.email')</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" value="{{ old('email')? old('email') : $user->email }}" name="email" placeholder="@lang('app.email')">
                    {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('gender')? 'is-invalid':'' }}">
                <label for="gender" class="col-sm-4 col-form-label">@lang('app.gender')</label>
                <div class="col-sm-8">
                    <select id="gender" name="gender" class="form-control select2">
                        <option value="">Select Gender</option>
                        <option value="male" {{ $user->gender == 'male'?'selected':'' }}>Male</option>
                        <option value="female" {{ $user->gender == 'female'?'selected':'' }}>Fe-Male</option>
                        <option value="third_gender" {{ $user->gender == 'third_gender'?'selected':'' }}>Third Gender</option>
                    </select>

                    {!! $errors->has('gender')? '<p class="help-block">'.$errors->first('gender').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('phone')? 'is-invalid':'' }}">
                <label for="phone" class="col-sm-4 col-form-label">@lang('app.phone')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="phone" value="{{ old('phone')? old('phone') : $user->phone }}" name="phone" placeholder="@lang('app.phone')">
                    {!! $errors->has('phone')? '<p class="help-block">'.$errors->first('phone').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('country_id')? 'is-invalid':'' }}">
                <label for="phone" class="col-sm-4 col-form-label">@lang('app.country')</label>
                <div class="col-sm-8">
                    <select id="country_id" name="country_id" class="form-control select2">
                        <option value="">@lang('app.select_a_country')</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' :'' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->has('country_id')? '<p class="help-block">'.$errors->first('country_id').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('address')? 'is-invalid':'' }}">
                <label for="address" class="col-sm-4 col-form-label">@lang('app.address')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" value="{{ old('address')? old('address') : $user->address }}" name="address" placeholder="@lang('app.address')">
                    {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3  {{ $errors->has('photo')? 'is-invalid':'' }}">
                <label class="col-sm-4 col-form-label">@lang('app.change_avatar')</label>
                <div class="col-sm-8">
                    <input type="file" id="photo" name="photo" class="filestyle" >
                    {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}
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