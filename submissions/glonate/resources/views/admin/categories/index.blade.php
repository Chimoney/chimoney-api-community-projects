@extends('layouts.dashboard.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection


@section('content')
    

    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-xs-12">

            <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" >                                @csrf


            <div class="row mb-3 {{ $errors->has('category_name')? 'is-invalid':'' }}">
                <label for="category_name" class="col-sm-4 col-form-label">@lang('app.category_name')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="category_name" value="{{ old('category_name') }}" name="category_name" placeholder="@lang('app.category_name')">
                    {!! $errors->has('category_name')? '<p class="help-block">'.$errors->first('category_name').'</p>':'' !!}

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

    @if($categories->count())
        <div class="row">
            <div class="col-sm-10 offset-sm-1 col-xs-12">
                <table class="table table-bordered categories-lists">
                    <tr>
                        <th>@lang('app.category_name') </th>
                        <th>@lang('app.image') </th>
                        <th>@lang('app.action') </th>
                    </tr>
                    @foreach($categories as $category)
                        <tr>
                            <td> {{ $category->category_name }}  </td>
                            <td> <img src="{{$category->get_image_url()}}" />  </td>
                            <td>
                                <a href="{{ route('edit_categories', $category->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
                                <a href="javascript:;" class="btn btn-danger btn-xs" data-id="{{ $category->id }}"><i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('.btn-danger').on('click', function (e) {
                if (!confirm("Are you sure? its can't be undone")) {
                    e.preventDefault();
                    return false;
                }

                var selector = $(this);
                var data_id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('delete_categories') }}',
                    data: {data_id: data_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            selector.closest('tr').hide('slow');
                        }
                    }
                });
            });
        });
    </script>
@endsection