@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="campaign-details-wrap">

        @include('public.campaigns.partials.header')

        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="campaign-decription">

                        @php
                        $backers = $campaign->success_payments()->orderBy('id','desc')->paginate(20);
                        @endphp


                        @if($backers->count())
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>@lang('app.backer_name')</th>
                                    <th>@lang('app.amount')</th>
                                </tr>

                                @if($backers->count() > 0)
                                    @foreach($backers as $backer)

                                        <tr>
                                            <td>{{ $backer->contributor_name_display =='anonymous' ? trans('app.anonymous') : $backer->name}}</td>
                                            <td>{!! get_amount($backer->amount) !!}</td>
                                        </tr>

                                    @endforeach
                                @endif
                            </table>

                            {{ $backers->links() }}
                        @else

                            <div class="no-data">
                                <i class="fa fa-smile-o"></i> <h1>@lang('app.no_contribute')</h1>
                            </div>

                        @endif


                    </div>

                </div>

                <div class="col-md-4">
                    @include('public.campaigns.partials.sidebar')
                </div>

            </div>
        </div>


    </section>


    @include('layouts.public.partials.get_start_section')


@endsection

@section('page-js')

    <script>
        $(function(){
            $(document).on('click', '.donate-amount-placeholder ul li', function(e){
                $(this).closest('form').find($('[name="amount"]')).val($(this).data('value'));
            });
        });
    </script>

@endsection