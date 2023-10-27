<nav class="sidebar-main">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn"><a href="index.html"><img class="img-fluid" alt=""></a>
                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                      aria-hidden="true"> </i></div>
            </li>

            <li class="sidebar-list">
                <label class="badge badge-light-danger">Latest </label>
                <a
                    class="sidebar-link sidebar-title link-nav" href="/administrator/dashboard">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Tổng quan</span>
                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                </a>
            </li>

            @can('users-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/users">
                        <i class="fa-regular fa-user"></i>
                        <span>Khách hàng</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('chats-list')
                <li class="sidebar-list">
                    <label style="color: #000000;background-color: #ffc500;"
                           class="badge badge-light-danger"></label>
                    <a target="_blank"
                       class="sidebar-link sidebar-title link-nav"
                       href="https://svg1-613625916103304673.myfreshworks.com/crm/messaging/a/777606845074898/inbox/0/0">
                        <i class="fa-regular fa-comment"></i>
                        <span>Tư vấn khách hàng</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            <li class="sidebar-list">
                <label style="color: #000000;background-color: #ffc500;"
                       class="badge badge-light-danger">{{\App\Models\UserHotel::where('user_hotel_status_id', 1)->count()}} </label>
                <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                    <i class="fa-solid fa-hotel"></i>
                    <span class="">Khách sạn</span>
                </a>
                <ul class="sidebar-submenu" style="display: none;">

                    @can('hotels-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/hotels">
                                <i class="fa-solid fa-bell-concierge"></i>
                                <span>Danh sách</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('user_hotels-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/user-hotels">
                                <i class="fa-solid fa-umbrella-beach"></i>
                                <span>Đặt phòng</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

            @can('flights-list')
                <li class="sidebar-list">
                    <label style="color: #000000;background-color: #ffc500;"
                           class="badge badge-light-danger">{{\App\Models\UserFlight::where('user_flight_status_id', 5)->count()}} </label>
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/user-flights">
                        <i class="fa-solid fa-plane-departure"></i>
                        <span>Vé máy bay</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('user_combos-list')
                <li class="sidebar-list">
                    <label style="color: #000000;background-color: #ffc500;"
                           class="badge badge-light-danger">{{\App\Models\UserCombo::where('user_combo_status_id', 2)->count()}} </label>
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/user-combos">
                        <i class="fa-solid fa-ticket-simple"></i>
                        <span>Combo vé</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('user_receipts-list')
                <li class="sidebar-list">
                    <label style="color: #000000;background-color: #ffc500;"
                           class="badge badge-light-danger">{{\App\Models\UserReceipt::count()}} </label>
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/user-receipts">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Xuất hóa đơn</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            {{--            @can('reports-list')--}}
            {{--                <li class="sidebar-list">--}}
            {{--                    <label style="color: #000000;background-color: #ffc500;"--}}
            {{--                           class="badge badge-light-danger"></label>--}}
            {{--                    <a--}}
            {{--                        class="sidebar-link sidebar-title link-nav" href="/administrator/reports">--}}
            {{--                        <i class="fa-solid fa-ticket-simple"></i>--}}
            {{--                        <span>Báo cáo</span>--}}
            {{--                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            @endcan--}}

            @can('entertainments-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav"
                        href="/administrator/entertainments">
                        <i class="fa-solid fa-umbrella-beach"></i>
                        <span>vui chơi giải trí</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('user_transactions-list')
                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <span class="">Giao dịch</span>
                    </a>
                    <ul class="sidebar-submenu" style="display: none;">

                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/user-transactions">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                                <span>Giao dịch khách</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/user-points">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                                <span>Điểm</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/banks">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                                <span>Ngân hàng nạp tiền</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('memberships-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav"
                        href="/administrator/memberships">
                        <i class="fa-regular fa-star"></i>
                        <span>Hạng thành viên</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            <li class="sidebar-list">
                <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                    <i class="fas fa-thin fa-bell"></i>
                    <span class="">Email và thông báo</span>
                </a>
                <ul class="sidebar-submenu" style="display: none;">

                    @can('job_emails-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/job-emails">
                                <i class="fas fa-thin fa-envelope"></i>
                                <span>Gửi Email</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('job_notifications-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/job-notifications">
                                <i class="fas fa-light fa-clock"></i>
                                <span>Gửi thông báo</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>


            <li class="sidebar-list">
                <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                    <i class="fas fa-solid fa-ruler-combined"></i>
                    <span class="">Phân quyền</span>
                    <div class="according-menu"><i class="fas fa fa-angle-right"></i></div>
                </a>
                <ul class="sidebar-submenu" style="display: none;">
                    @can('employees-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/employees">
                                <i class="fas fa-sharp fa-solid fa-person"></i>
                                <span>Nhân viên</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('roles-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/roles">
                                <i class="fas fa-regular fa-pen-ruler"></i>
                                <span>Vai trò</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                    <i class="fas fa-solid fa-file-pen"></i>
                    <span class="">Nội dung</span>
                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                </a>
                <ul class="sidebar-submenu" style="display: none;">

                    @can('sliders-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/sliders">
                                <i class="fas fa-thin fa-pager"></i>
                                <span>Slider</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('special_events-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/special-events">
                                <i class="fas fa-thin fa-pager"></i>
                                <span>Special Event</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    {{--                    @can('sliders-list')--}}
                    {{--                        <li>--}}
                    {{--                            <a--}}
                    {{--                                class="sidebar-link sidebar-title link-nav" href="/administrator/system-branches">--}}
                    {{--                                <i class="fas fa-thin fa-pager"></i>--}}
                    {{--                                <span>Hệ thống cửa hàng</span>--}}
                    {{--                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcan--}}

                    @can('logos-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/logos">
                                <i class="fas fa-brands fa-pied-piper"></i>
                                <span>Logo</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>

                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/cities">
                                <i class="fas fa-brands fa-pied-piper"></i>
                                <span>Thành phố</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    {{--                    @can('news-list')--}}
                    {{--                        <li>--}}
                    {{--                            <a--}}
                    {{--                                class="sidebar-link sidebar-title link-nav"--}}
                    {{--                                href="/administrator/category-news">--}}
                    {{--                                <i class="fas fa-solid fa-newspaper"></i>--}}
                    {{--                                <span>Danh mục tin tức</span>--}}
                    {{--                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcan--}}

                    {{--                    @can('news-list')--}}
                    {{--                        <li>--}}
                    {{--                            <a--}}
                    {{--                                class="sidebar-link sidebar-title link-nav"--}}
                    {{--                                href="/administrator/news">--}}
                    {{--                                <i class="fas fa-solid fa-newspaper"></i>--}}
                    {{--                                <span>Tin tức</span>--}}
                    {{--                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcan--}}

                </ul>
            </li>

            <li class="sidebar-list">
                <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                    <i class="fa-solid fa-gear"></i>
                    <span class="">Cài đặt</span>
                    <div class="according-menu"><i class="fa fa-angle-right"></i>
                    </div>
                </a>
                <ul class="sidebar-submenu" style="display: none;">

                    @can('settings-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/settings/edit/1">
                                <span>Cài đặt chung</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('settings-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/airlines">
                                <span>Logo máy bay</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

            @can('history_datas-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav"
                        href="/administrator/history-datas">
                        <i class="fas fa-solid fa-database"></i>
                        <span>Lịch sử dữ liệu</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</nav>
