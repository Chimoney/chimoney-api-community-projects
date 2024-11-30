<div class="single-campaign-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="single-campaign-title">{{$campaign->title}}</h1>
            </div>
        </div>
    </div>

    <div class="single-campaign-menu">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @php
                    $backers_count = $campaign->total_payments;
                    $updates_count = $campaign->updates->count();
                    $faqs_count = $campaign->faqs->count();
                    @endphp
                    <ul>
                        <li><a href="{{route('campaign_single', [$campaign->id, $campaign->slug])}}"> @lang('app.campaign_home') </a> </li>
                        <li><a href="{{route('campaign_backers', [$campaign->id, $campaign->slug])}}"> @lang('app.backers') ({{$backers_count}}) </a> </li>
                        <li>
                            <a href="{{route('campaign_updates', [$campaign->id, $campaign->slug])}}"> @lang('app.updates')
                                @if($updates_count > 0) ({{$updates_count}}) @endif
                            </a> </li>
                        <li>
                            <a href="{{route('campaign_faqs', [$campaign->id, $campaign->slug])}}"> @lang('app.faqs')  @if($faqs_count > 0) ({{$faqs_count}}) @endif </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>