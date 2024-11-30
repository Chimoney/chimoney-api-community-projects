@extends('layouts.dashboard.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datetimepicker.css')}}">
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" >                                @csrf


            <div class="row mb-3 {{ $errors->has('amount')? 'is-invalid':'' }}">
                <label for="amount" class="col-sm-4 col-form-label">@lang('app.amount')</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="amount" value="{{ $reward->amount }}" name="amount" placeholder="@lang('app.amount')">
                    {!! $errors->has('amount')? '<p class="help-block">'.$errors->first('amount').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('description')? 'is-invalid':'' }}">
                <label for="description" class="col-sm-4 col-form-label">@lang('app.description')</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="description">{{$reward->description}}</textarea>
                    {!! $errors->has('description')? '<p class="help-block">'.$errors->first('description').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('quantity')? 'is-invalid':'' }}">
                <label for="quantity" class="col-sm-4 col-form-label">@lang('app.quantity')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="quantity" value="{{ $reward->quantity }}" name="quantity" placeholder="@lang('app.quantity')">
                    {!! $errors->has('quantity')? '<p class="help-block">'.$errors->first('quantity').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3 {{ $errors->has('estimated_delivery')? 'is-invalid':'' }}">
                <label for="estimated_delivery" class="col-sm-4 col-form-label">@lang('app.estimated_delivery')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="estimated_delivery" value="{{ $reward->estimated_delivery }}" name="estimated_delivery" placeholder="@lang('app.estimated_delivery')">
                    {!! $errors->has('estimated_delivery')? '<p class="help-block">'.$errors->first('estimated_delivery').'</p>':'' !!}
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">@lang('app.save_reward')</button>
                </div>
            </div>
            </form>

        </div>
    </div>
@endsection

@section('page-js')

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $(function () {
            $('#estimated_delivery').datetimepicker({format: 'YYYY-MM'});
        });
    </script>
@endsection