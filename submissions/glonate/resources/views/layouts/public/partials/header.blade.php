

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav">
                    <?php
                    $header_menu_pages = \App\Models\Post::whereStatus('1')->where('show_in_header_menu', 1)->get();
                    ?>
                    @if($header_menu_pages->count() > 0)
                        @foreach($header_menu_pages as $page)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('single_page', $page->slug) }}">{{ $page->title }} </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <form action="{{route('search')}}" method="get">
                    <input class="form-control" type="text" name="q" placeholder="@lang('app.search_campaigns')" aria-label="@lang('app.search_campaigns')">
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    
                    <li class="nav-item">
                        <a href="{{route('start_campaign')}}" class=" btn btn-info rounded-pill text-white">
                            @lang('app.start_a_campaign')
                        </a>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('dashboard')}}">
                                    <i class="fa fa-dashboard"></i> @lang('app.dashboard') 
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
