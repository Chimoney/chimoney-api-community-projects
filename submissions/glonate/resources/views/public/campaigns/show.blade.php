@extends('layouts.public.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('meta-data')
    <meta name="description" content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}">
    {{--<meta name="twitter:site" content="@publisher_handle">--}}
    <meta name="twitter:title" content="@if( ! empty($title)) {{ $title }} @endif">
    <meta name="twitter:description" content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}">
    {{--<meta name="twitter:creator" content="@author_handle" />--}}
    <!-- Twitter Summary card images must be at least 120x120px -->
    <meta name="twitter:image" content="{{$campaign->feature_img_url(true)}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="@if( ! empty($title)) {{ $title }} @endif" />
    <meta property="og:url" content="{{route('campaign_single', [$campaign->id, $campaign->slug])}}" />
    <meta property="og:image" content="{{$campaign->feature_img_url(true)}}" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}" />

@endsection

@section('content')

    <section class="campaign-details-wrap">

        @include('public.campaigns.partials.header')

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('layouts.partials.alert')

                    <div class="campaign-decription">


                        <div class="single-campaign-embeded">


                            @if( ! empty($campaign->video))
                                <?php
                                $video_url = $campaign->video;
                                if (strpos($video_url, 'youtube') > 0) {
                                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                                    if ( ! empty($matches[1])){
                                        echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$matches[1].'" frameborder="0" allowfullscreen></iframe></div>';
                                    }

                                } elseif (strpos($video_url, 'vimeo') > 0) {
                                    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $video_url, $regs)) {
                                        if (!empty($regs[3])){
                                            echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$regs[3].'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
                                        }
                                    }
                                }
                                ?>

                            @else

                                <div class="campaign-feature-img">
                                    <img src="{{$campaign->feature_img_url(true)}}" class="img-responsive" />
                                </div>

                            @endif

                        </div>

                        {!! safe_output($campaign->description) !!}

                        @if($enable_discuss)
                            <div class="comments-title"><h2> <i class="fa fa-comment"></i> @lang('app.comments')</h2></div>
                            <div id="disqus_thread"></div>
                            <script>
                                var disqus_config = function () {
                                    this.page.url = '{{route('campaign_single', [$campaign->id, $campaign->slug])}}';  // Replace PAGE_URL with your page's canonical URL variable
                                    this.page.identifier = '{{route('campaign_single', [$campaign->id, $campaign->slug])}}'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                                };
                                (function() { // DON'T EDIT BELOW THIS LINE
                                    var d = document, s = d.createElement('script');
                                    s.src = '//{{get_option('disqus_shortname')}}.disqus.com/embed.js';
                                    s.setAttribute('data-timestamp', +new Date());
                                    (d.head || d.body).appendChild(s);
                                })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

                        @endif


                    </div>

                </div>

                <div class="col-md-4">
                    @include('layouts.public.partials.get_start_section')
                </div>

            </div>
        </div>

    </section>

@endsection

@section('page-js')
    @if($enable_discuss)
        <script id="dsq-count-scr" src="//{{get_option('disqus_shortname')}}.disqus.com/count.js" async></script>
    @endif

    <script src="{{asset('assets/plugins/SocialShare/SocialShare.min.js')}}"></script>
    <script>
        $('.share').ShareLink({
            title: '{{$campaign->title}}', // title for share message
            text: '{{$campaign->short_description ? $campaign->short_description : $campaign->description}}', // text for share message
            width: 640, // optional popup initial width
            height: 480 // optional popup initial height
        })
    </script>

    <script>
        $(function(){
            $(document).on('click', '.donate-amount-placeholder ul li', function(e){
                $(this).closest('form').find($('[name="amount"]')).val($(this).data('value'));
            });

            $('#campaign_url_copy_btn').click(function(){
                copyToClipboard('#campaign_url_input');
            });

        });



        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            toastr.success('@lang('app.campaign_url_copied')', '@lang('app.success')', toastr_options);
            $temp.remove();
        }

    </script>

@endsection