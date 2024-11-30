@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">



            @if($users->count() > 0)
                <p>{{number_format($users_count)}} @lang('app.total_users_found')</p>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>@lang('app.name')</td>
                        <td>@lang('app.email')</td>
                        <td>@lang('app.contributed')</td>
                        <td>@lang('app.actions')</td>
                    </tr>

                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->get_gravatar(30) }}" class="img-thumbnail img-circle" width="30" />
                                {{ $user->name }}
                            </td>
                            <td>{{$user->email}}</td>
                            <td>
                                @php $total_contributed = $user->contributed_amount(); @endphp
                                @if($total_contributed > 0)
                                    {!! get_amount($total_contributed) !!}
                                @endif
                            </td>

                            <td>
                                <a href="{{route('users_view', $user->id)}}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> </a>
                                @if($user->active_status == 0)
                                    <a href="{{route('user_status', [$user->id, 'approve'])}}" class="btn btn-default btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="fa fa-ban"></i> </a>

                                    <a href="{{route('user_status', [$user->id, 'block'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="fa fa-ban"></i> </a>

                                @elseif($user->active_status == '1')
                                    <a href="{{route('user_status', [$user->id, 'block'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="fa fa-ban"></i> </a>

                                @elseif($user->active_status == 2)
                                    <a href="{{route('user_status', [$user->id, 'approve'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="fa fa-check-circle-o"></i> </a>
                                @endif

                                <a href="{{route('users_edit', $user->id)}}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> </a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                {!! $users->links() !!}

            @else
                <h3>@lang('app.there_is_no_user')</h3>
            @endif

        </div>
    </div>
@endsection

@section('page-js')

@endsection