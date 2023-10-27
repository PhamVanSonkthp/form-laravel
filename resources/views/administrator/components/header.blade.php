<!-- Page Header Start-->
<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="../assets/images/logo/logo.png"
                                                                alt=""></a></div>
            <div class="toggle-sidebar">
                <div class="status_toggle sidebar-toggle d-flex">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <g>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21.0003 6.6738C21.0003 8.7024 19.3551 10.3476 17.3265 10.3476C15.2979 10.3476 13.6536 8.7024 13.6536 6.6738C13.6536 4.6452 15.2979 3 17.3265 3C19.3551 3 21.0003 4.6452 21.0003 6.6738Z"
                                      stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.3467 6.6738C10.3467 8.7024 8.7024 10.3476 6.6729 10.3476C4.6452 10.3476 3 8.7024 3 6.6738C3 4.6452 4.6452 3 6.6729 3C8.7024 3 10.3467 4.6452 10.3467 6.6738Z"
                                      stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21.0003 17.2619C21.0003 19.2905 19.3551 20.9348 17.3265 20.9348C15.2979 20.9348 13.6536 19.2905 13.6536 17.2619C13.6536 15.2333 15.2979 13.5881 17.3265 13.5881C19.3551 13.5881 21.0003 15.2333 21.0003 17.2619Z"
                                      stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.3467 17.2619C10.3467 19.2905 8.7024 20.9348 6.6729 20.9348C4.6452 20.9348 3 19.2905 3 17.2619C3 15.2333 4.6452 13.5881 6.6729 13.5881C8.7024 13.5881 10.3467 15.2333 10.3467 17.2619Z"
                                      stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        <div class="left-side-header col ps-0 d-none d-md-block">
        </div>
        <div class="nav-right col-10 col-sm-6 pull-right right-header p-0">
            <ul class="nav-menus">

                <li class="onhover-dropdown">
                    <a class="notification-box" href="{{route('administrator.user_flights.index', ['user_flight_status_id' => 5])}}" title="Vé máy bay cần xử lý">
                        <i class="fa-solid fa-plane"></i>

                        @php
                            $numberFlightNeedProcess = \App\Models\UserFlight::where('user_flight_status_id', 5)->count();
                        @endphp

                        @if($numberFlightNeedProcess > 0)
                            <span style="top: -12px;" class="badge rounded-pill badge-warning">{{$numberFlightNeedProcess}} </span>
                        @endif
                    </a>
                </li>

                <li class="onhover-dropdown">
                    <a class="notification-box" href="{{route('administrator.user_hotels.index', ['user_hotel_status_id' => 2])}}" title="Khách sạn cần xử lý">
                        <i class="fa-solid fa-hotel"></i>
                        @php
                            $numberHotelNeedProcess = \App\Models\UserHotel::where('user_hotel_status_id', 2)->count();
                        @endphp

                        @if($numberHotelNeedProcess > 0)
                            <span style="top: -12px;" class="badge rounded-pill badge-warning">{{$numberHotelNeedProcess}} </span>
                        @endif

                    </a>
                </li>

                <li class="onhover-dropdown">
                    <a class="notification-box" href="{{route('administrator.user_combos.index', ['user_combo_status_id' => 2])}}" title="Combo cần xử lý">
                        <i class="fa-solid fa-group-arrows-rotate"></i>
                        @php
                            $numberComboNeedProcess = \App\Models\UserCombo::where('user_combo_status_id', 2)->count();
                        @endphp

                        @if($numberComboNeedProcess > 0)
                            <span style="top: -12px;" class="badge rounded-pill badge-warning">{{$numberComboNeedProcess}} </span>
                        @endif

                    </a>
                </li>



                <li class="onhover-dropdown">

                    @php
                        $statusWeb2M = \App\Models\StatusWeb2M::first();
                    @endphp
                    @if($statusWeb2M->is_success == 1)
                        <a class="notification-box">
                            <div title="Hệ thống nạp tiền tự động: {{$statusWeb2M->description}} - {{$statusWeb2M->updated_at}}" class="progress-gradient-success" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                        </a>
                    @else
                        <a class="notification-box" title="Hệ thống nạp tiền tự động: {{$statusWeb2M->description}} - {{$statusWeb2M->updated_at}}">
                            <div class="progress-gradient-danger" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                        </a>
                    @endif
                </li>

                <li class="maximize"><a class="text-dark" href="#!">
                        {{auth()->user()->name}}
                    </a></li>
                <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path d="M2.99609 8.71995C3.56609 5.23995 5.28609 3.51995 8.76609 2.94995"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path
                                        d="M8.76616 20.99C5.28616 20.41 3.56616 18.7 2.99616 15.22L2.99516 15.224C2.87416 14.504 2.80516 13.694 2.78516 12.804"
                                        stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M21.2446 12.804C21.2246 13.694 21.1546 14.504 21.0346 15.224L21.0366 15.22C20.4656 18.7 18.7456 20.41 15.2656 20.99"
                                        stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M15.2661 2.94995C18.7461 3.51995 20.4661 5.23995 21.0361 8.71995"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                    </a></li>
                <li class="profile-nav onhover-dropdown pe-0 py-0 me-0">
                    <div class="media profile-media">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.55851 21.4562C5.88651 21.4562 2.74951 20.9012 2.74951 18.6772C2.74951 16.4532 5.86651 14.4492 9.55851 14.4492C13.2305 14.4492 16.3665 16.4342 16.3665 18.6572C16.3665 20.8802 13.2505 21.4562 9.55851 21.4562Z"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.55849 11.2776C11.9685 11.2776 13.9225 9.32356 13.9225 6.91356C13.9225 4.50356 11.9685 2.54956 9.55849 2.54956C7.14849 2.54956 5.19449 4.50356 5.19449 6.91356C5.18549 9.31556 7.12649 11.2696 9.52749 11.2776H9.55849Z"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path
                                        d="M16.8013 10.0789C18.2043 9.70388 19.2383 8.42488 19.2383 6.90288C19.2393 5.31488 18.1123 3.98888 16.6143 3.68188"
                                        stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M17.4608 13.6536C19.4488 13.6536 21.1468 15.0016 21.1468 16.2046C21.1468 16.9136 20.5618 17.6416 19.6718 17.8506"
                                        stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
{{--                        <li><a href="user-profile.html"><i data-feather="user"></i><span>Account </span></a></li>--}}
{{--                        <li><a href="email-application.html"><i data-feather="mail"></i><span>Inbox</span></a></li>--}}
{{--                        <li><a href="kanban.html"><i data-feather="file-text"></i><span>Taskboard</span></a></li>--}}
                        <li><a href="{{route('administrator.settings.edit' , ['id'=> 1 ])}}"><i data-feather="settings"></i><span>Cài đặt</span></a></li>
                        <li><a href="{{route('administrator.password.index')}}"><i data-feather="file-text"></i><span>Đổi mật khẩu</span></a></li>
                        <li><a class="color-danger" href="{{route('administrator.logout')}}"><i data-feather="log-in"> </i><span class="color-danger">Đăng xuất</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
                <div class="ProfileCard-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-airplay m-0">
                        <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                        <polygon points="12 15 17 21 7 21 12 15"></polygon>
                    </svg>
                </div>
                <div class="ProfileCard-details">
                    <div class="ProfileCard-realName"></div>
                </div>
            </div>
        </script>
        <script class="empty-template" type="text/x-handlebars-template">
            <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down,
                yikes!
            </div></script>
    </div>
</div>
<!-- Page Header Ends                              -->
