<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{route('welcome.index')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ optional(\App\Models\Logo::first())->image_path }}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{ optional(\App\Models\Logo::first())->image_path }}" alt="" height="17">
                                </span>
                </a>

                <a href="{{route('welcome.index')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ optional(\App\Models\Logo::first())->image_path }}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{ optional(\App\Models\Logo::first())->image_path }}" alt="" height="36">
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                    id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="d-none d-sm-block ms-2">
                @yield('name')
            </div>
        </div>

        <!-- Search input -->
        <div class="search-wrap" id="search-wrap">
            <div class="search-bar">
                <input class="search-input form-control" placeholder="Search" onkeydown="search(this)">
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                    <i class="mdi mdi-close-circle"></i>
                </a>
            </div>
        </div>

        <div class="d-flex header-right">

            <div class="dropdown d-none d-lg-inline-block search_init">
                <button type="button" class="btn header-item toggle-search noti-icon waves-effect"
                        data-target="#search-wrap">
                    <i class="mdi mdi-magnify"></i>
                </button>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            @auth()
                <div class="dropdown d-inline-block me-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ion ion-md-notifications"></i>
                        @if(\Illuminate\Support\Facades\Auth::user()->getUserNotification()->count())
                            <span
                                class="badge bg-danger rounded-pill">{{\Illuminate\Support\Facades\Auth::user()->getUserNotification()->count()}}</span>
                        @endif

                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-16"> Thông báo
                                        ({{\Illuminate\Support\Facades\Auth::user()->getUserNotification()->count()}}) </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">

                            @foreach(\Illuminate\Support\Facades\Auth::user()->getUserNotification() as $notificationItem)
                                <a href="{{route('user.notifications')}}" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                    <i class="mdi mdi-message-text-outline"></i>
                                                </span>
                                        </div>
                                        <div class="flex-1">
                                            @if(isset($notificationItem->data) && isset(json_decode($notificationItem->data , true)['body']))
                                                <h6 class="mt-0 font-size-15 mb-1">{{json_decode($notificationItem->data , true)['body']}}</h6>
                                            @endif
                                            @if(isset($notificationItem->data) && isset(json_decode($notificationItem->data , true)['text']))
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">{{json_decode($notificationItem->data , true)['text']}}</p>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                        <div class="p-2 border-top">
                            <div class="d-grid">
                                <a class="btn btn-sm btn-link font-size-14  text-center"
                                   href="{{route('user.notifications')}}">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth


            <div class="@auth() dropdown d-inline-block @endauth()" style="@auth() @else align-items: center;display: flex; @endauth()">

                @auth()
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <a href="{{ route('user.profile') }}" class="dropdown-item">{{auth()->user()->name}}</a>

                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
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
                            @auth
                                <a href="{{ route('user.profile') }}" class="dropdown-item">Tài khoản</a>
                            @else
                                <a href="{{ route('login') }}" class="dropdown-item">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 dropdown-item text-danger">Register</a>
                                @endif
                            @endauth

                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            {{--                        <li class="nav-item dropdown">--}}
                            {{--                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
                            {{--                                {{ Auth::user()->name }}--}}
                            {{--                            </a>--}}
                            {{--                        </li>--}}
                        @endguest


                    </div>
                @else
                    <a class="text-white btn rounded-pill" href="{{ route('login') }}" style="font-weight: bold; background-color: #D3AB56;">Đăng nhập</a>
                @endauth

            </div>


        </div>
    </div>
</header>
