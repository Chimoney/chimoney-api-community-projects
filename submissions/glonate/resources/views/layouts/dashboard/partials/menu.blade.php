    @php
        $auth_user = \Illuminate\Support\Facades\Auth::user();
    @endphp
    
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2">
        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none">
            <span class="fs-5 d-none d-sm-inline text-white">Dashboard</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="side-menu">
           
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white align-middle px-0">
                    <i class="fa fa-dashboard fa-fw"></i>
                    <span class="ms-1 d-none d-sm-inline">@lang('app.dashboard')</span>
                </a>
            </li>
            <li>
                <a href="#submycampaigns" data-bs-toggle="collapse" class="nav-link text-white px-0 align-middle">
                    <i class="fa fa-bullhorn"></i> 
                    <span class="ms-1 d-none d-sm-inline">@lang('app.my_campaigns') </span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="collapse nav flex-column ms-3" id="submycampaigns" data-bs-parent="#side-menu">
                    <li class="w-100">
                        <a href="{{route('my_campaigns')}}" class="nav-link text-white px-0">
                            @lang('app.my_campaigns')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('start_campaign')}}" class="nav-link text-white px-0">
                            @lang('app.start_a_campaign')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('my_pending_campaigns')}}" class="nav-link text-white px-0">
                            @lang('app.pending_campaigns')</span>
                        </a>
                    </li>
                </ul>
            </li>

            @if($auth_user->is_admin())
                <li class="nav-item">
                    <a href="{{ route('categories') }}" class="nav-link text-white align-middle px-0">
                        <i class="fa fa-folder-o"></i>
                        <span class="ms-1 d-none d-sm-inline">@lang('app.categories')</span>
                    </a>
                </li>
                <li>
                    <a href="#submenu3" data-bs-toggle="collapse" class="nav-link text-white px-0 align-middle">
                        <i class="fa fa-bullhorn"></i>
                        <span class="ms-1 d-none d-sm-inline">@lang('app.campaigns')</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#side-menu">
                        <li> <a class="nav-link text-white px-0" href="{{ route('all_campaigns') }}">@lang('app.all_campaigns')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('funded') }}">@lang('app.funded')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('blocked_campaigns') }}">@lang('app.blocked_campaigns')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('pending_campaigns') }}">@lang('app.pending_campaigns')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('expired_campaigns') }}">@lang('app.expired_campaigns')</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#subsettings" data-bs-toggle="collapse" class="nav-link text-white px-0 align-middle">
                        <i class="fa fa-wrench fa-fw"></i>
                        <span class="ms-1 d-none d-sm-inline">@lang('app.settings')
                        <span class="fa arrow"></span></span>
                    </a>
                    <ul class="collapse nav flex-column ms-1" id="subsettings" data-bs-parent="#side-menu">
                        <li> <a class="nav-link text-white px-0" href="{{ route('general_settings') }}">@lang('app.general_settings')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('payment_settings') }}">@lang('app.payment_settings')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('theme_settings') }}">@lang('app.theme_settings')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('social_settings') }}">@lang('app.social_settings')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('re_captcha_settings') }}">@lang('app.re_captcha_settings')</a> </li>
                        <li> <a class="nav-link text-white px-0" href="{{ route('other_settings') }}">@lang('app.other_settings')</a> </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pages') }}" class="nav-link text-white align-middle px-0">
                        <i class="fa fa-file-word-o"></i> <span class="ms-1 d-none d-sm-inline">@lang('app.pages')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users')}}" class="nav-link text-white align-middle px-0">
                        <i class="fa fa-users"></i>
                        <span class="ms-1 d-none d-sm-inline">@lang('app.users')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('withdrawal_requests')}}" class="nav-link text-white align-middle px-0">
                        <i class="fa fa-balance-scale"></i> <span class="ms-1 d-none d-sm-inline">@lang('app.withdrawal_requests')</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{route('payments')}}" class="nav-link text-white align-middle px-0">
                    <i class="fa fa-money"></i> <span class="ms-1 d-none d-sm-inline">@lang('app.payments')</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('withdraw')}}" class="nav-link text-white align-middle px-0">
                    <i class="fa fa-credit-card"></i> <span class="ms-1 d-none d-sm-inline">@lang('app.withdraw')</span>
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user"></i>
                <span class="d-none d-sm-inline mx-1">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{route('profile')}}">@lang('app.profile')</li>
                <li><a class="dropdown-item" href="{{route('change_password')}}">@lang('app.change_password')</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
