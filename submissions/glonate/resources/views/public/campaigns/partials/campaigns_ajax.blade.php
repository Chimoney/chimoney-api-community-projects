@if($new_campaigns->count())

    @foreach($new_campaigns as $nc)
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 box-campaign-item">
            <div class="box-campaign">
                <div class="box-campaign-image">
                    <a href="{{route('campaign_single', [$nc->id, $nc->slug])}}"><img src="{{ $nc->feature_img_url()}}" /> </a>
                </div>
                <div class="box-campaign-content">
                    <div class="box-campaign-description">
                        <h4><a href="{{route('campaign_single', [$nc->id, $nc->slug])}}"> {{$nc->title}} </a> </h4>
                        <p>{{$nc->short_description}}</p>
                    </div>

                    <div class="box-campaign-summery">
                        <ul>
                            <li><strong>{{$nc->days_left()}}</strong> @lang('app.days_left')</li>
                            <li><strong>{{$nc->total_payments}}</strong> @lang('app.backers')</li>
                            <li><strong>{{get_amount($nc->total_raised())}}</strong> @lang('app.funded')</li>
                        </ul>
                    </div>

                    <div class="progress">
                        @php
                        $percent_raised = $nc->percent_raised();
                        @endphp
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$percent_raised <= 100 ? $percent_raised : 100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent_raised}}%;">
                            {{$percent_raised}}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endif
