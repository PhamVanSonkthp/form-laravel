<nav class="sidebar-main">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                                           src="../assets/images/logo-icon.png" alt=""></a>
                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                      aria-hidden="true"> </i></div>
            </li>

            <li class="sidebar-list">
                <label class="badge badge-light-danger">Latest </label>
                <a
                    class="sidebar-link sidebar-title link-nav @yield('dashboard')" href="/administrator/dashboard">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Tổng quan</span>
                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                </a>
            </li>

            @can('user-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav @yield('user')" href="/administrator/users">
                        <i class="fas fa-thin fa-users"></i>
                        <span>Khách hàng</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('chat-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav @yield('chat')" href="/administrator/chats">
                        <i class="fas fa-thin fa-comment"></i>
                        <span>Chat</span>
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

                    @can('job_email-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('job_email')"
                                href="/administrator/job-email">
                                <i class="fas fa-thin fa-envelope"></i>
                                <span>Gửi Email</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('jobnotification-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('jobnotification')"
                                href="/administrator/job-notification">
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
                    @can('employee-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('employee')"
                                href="/administrator/employees">
                                <i class="fas fa-sharp fa-solid fa-person"></i>
                                <span>Nhân viên</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('role-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('role')" href="/administrator/roles">
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

                    @can('slider-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('role')" href="/administrator/slider">
                                <i class="fas fa-thin fa-pager"></i>
                                <span>Slider</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('logo-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('role')" href="/administrator/logo">
                                <i class="fas fa-brands fa-pied-piper"></i>
                                <span>Logo</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('news-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav @yield('news')"
                                href="/administrator/news">
                                <i class="fas fa-solid fa-newspaper"></i>
                                <span>Tin tức</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

            @can('history-data-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav @yield('history-data')"
                        href="/administrator/history-data">
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
