
    @if( ! request()->cookie('accept_cookie'))
        <div class="alert alert-warning text-center cookie-notice" style="font-size: 16px; margin: 0; line-height: 25px;">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12">
                        <p>{!! get_option('cookie_message') !!}</p>
                        <a href="#" class="cookie-ok-btn btn btn-primary">Ok</a>
                        <a href="{!! get_post_url(get_option('cookie_learn_page')) !!}">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <footer id="footer">
        <div class="container footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <p class="footer-copyright"> {!! get_text_tpl(get_option('copyright_text')) !!} </p>
                    <p class="d-none d-sm-inline text-white text pull-right">Glonate <code>v.{{config('app.version')}}</code>, by <a href="https://github.com/Rotimiiam" target="_blank">Rotimi Oolorode</a> </p>
                </div>
            </div>
        </div>
    </footer>
