

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" id="top_navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                @if(get_option('logo_settings') == 'show_site_name')
                    {{ get_option('site_name') }}
                @else
                    @if(logo_url())
                        <img class="main-logo" src="{{ logo_url() }}" />
                    @else
                        {{ get_option('site_name') }}
                    @endif
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="/" class=" btn btn-info rounded-pill text-white">
                            <i class="fa fa-home"></i> @lang('app.home')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
