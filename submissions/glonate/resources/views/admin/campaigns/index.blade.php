@extends('layouts.dashboard.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

   <div class="admin-campaign-lists">
       <div class="row">
           <div class="col-md-5">
               @lang('app.total') : {{$campaigns->count()}}
           </div>

           <div class="col-md-7">

               <form class="form-inline" method="get" action="{{route('campaign_admin_search')}}">
                   <div class="row mb-3">
                       <input type="text" name="q" value="{{request('q')}}" class="form-control" placeholder="@lang('app.campaign_title_keyword')">
                   </div>
                   <button type="submit" class="btn btn-default">@lang('app.search')</button>
               </form>

           </div>
       </div>
   </div>

    @if($campaigns->count() > 0)
        <table class="table table-striped table-bordered">

            <tr>
                <th>@lang('app.image')</th>
                <th>@lang('app.title')</th>
                <th>@lang('app.campaign_info')</th>
                <th>@lang('app.owner_info')</th>
                <th>@lang('app.actions')</th>
            </tr>

            @foreach($campaigns as $campaign)

                <tr>

                    <td><img src="{{$campaign->feature_img_url()}}" height="100" class="img-responsive" /></td>
                    <td>{{$campaign->title}}

                        @if($campaign->is_funded == 1)
                            <p class="bg-success">@lang('app.added_to_funded')</p>
                        @endif
                    </td>
                    <td>
                        @lang('app.goal') : {!! get_amount($campaign->goal) !!} <br />
                        @lang('app.raised') :  {!! get_amount($campaign->total_raised()) !!} <br />
                        @lang('app.raised_percent') : {{$campaign->percent_raised()}}%<br />
                        @lang('app.days_left') : {{$campaign->days_left()}}<br />
                        @lang('app.backers') : {{$campaign->total_payments}}<br />
                    </td>

                    <td>
                        @if($campaign->user)
                            <strong>{{$campaign->user->name}}</strong> <br />
                        @endif
                        @lang('app.address') : {{$campaign->address}}
                    </td>

                    <td>
                        <a href="{{route('campaign_single', [$campaign->id, $campaign->slug])}}" class="btn btn-default btn-sm" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>
                        <a href="{{route('edit_campaign', $campaign->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="@lang('app.edit')"><i class="fa fa-pencil"></i> </a>

                    @if($campaign->status == 0)
                            <a href="{{route('campaign_status', [$campaign->id, 'approve'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="fa fa-check-circle-o"></i> </a>
                            <a href="{{route('campaign_status', [$campaign->id, 'block'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="fa fa-ban"></i> </a>


                        @elseif($campaign->status == 1)

                            <a href="{{route('campaign_status', [$campaign->id, 'block'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="fa fa-ban"></i> </a>

                        @elseif($campaign->status == 2)
                            <a href="{{route('campaign_status', [$campaign->id, 'approve'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="fa fa-check-circle-o"></i> </a>
                        @endif

                        @if(request()->segment(3) == 'expired_campaigns')
                            @if($campaign->is_funded != 1)
                                <a href="{{route('campaign_status', [$campaign->id, 'funded'])}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="@lang('app.mark_as_funded')"><i class="fa fa-check-circle-o"></i>  @lang('app.mark_as_funded')</a>
                            @endif
                        @endif

                        <a href="{{route('campaign_delete', $campaign->id)}}" class="btn btn-delete btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.delete')"><i class="fa fa-trash-o"></i> </a>


                    </td>

                </tr>

            @endforeach

        </table>

        {!! $campaigns->links() !!}
    @else
        @lang('app.no_campaigns_to_display')
    @endif
    
@endsection

@section('page-js')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-delete').click(function(e){
                if (! confirm("@lang('app.are_you_sure_undone')") ){
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection