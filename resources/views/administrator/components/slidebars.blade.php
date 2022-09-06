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
                <label class="badge badge-light-danger">Latest </label><a
                    class="sidebar-link sidebar-title link-nav @yield('dashboard')" href="/administrator/dashboard">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <g>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M2.75 12C2.75 18.937 5.063 21.25 12 21.25C18.937 21.25 21.25 18.937 21.25 12C21.25 5.063 18.937 2.75 12 2.75C5.063 2.75 2.75 5.063 2.75 12Z"
                                      stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                <path d="M15.39 14.018L11.999 11.995V7.63403" stroke="#130F26"
                                      stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </g>
                        </g>
                    </svg>
                    <span>Tổng quan</span>
                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                </a>
            </li>

            @can('user-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav @yield('user')" href="/administrator/users">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M2.75 12C2.75 18.937 5.063 21.25 12 21.25C18.937 21.25 21.25 18.937 21.25 12C21.25 5.063 18.937 2.75 12 2.75C5.063 2.75 2.75 5.063 2.75 12Z"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path d="M15.39 14.018L11.999 11.995V7.63403" stroke="#130F26"
                                          stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                        <span>Khách hàng</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('employee-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav @yield('employee')" href="/administrator/employees">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M2.75 12C2.75 18.937 5.063 21.25 12 21.25C18.937 21.25 21.25 18.937 21.25 12C21.25 5.063 18.937 2.75 12 2.75C5.063 2.75 2.75 5.063 2.75 12Z"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path d="M15.39 14.018L11.999 11.995V7.63403" stroke="#130F26"
                                          stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                        <span>Nhân viên</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('role-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav @yield('role')" href="/administrator/roles">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M2.75 12C2.75 18.937 5.063 21.25 12 21.25C18.937 21.25 21.25 18.937 21.25 12C21.25 5.063 18.937 2.75 12 2.75C5.063 2.75 2.75 5.063 2.75 12Z"
                                          stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path d="M15.39 14.018L11.999 11.995V7.63403" stroke="#130F26"
                                          stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                        <span>Vai trò</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

        </ul>
        <div class="sidebar-img-section">
            <div class="sidebar-img-content"><img class="img-fluid" src="../assets/images/side-bar.png"
                                                  alt="">
                <h4>Need Help ?</h4><a class="txt" href="https://pixelstrap.freshdesk.com/support/home">Raise
                    ticket at "support@pixelstrap.com"</a><a class="btn btn-secondary"
                                                             href="https://themeforest.net/user/pixelstrap/portfolio">Buy
                    Now</a>
            </div>
        </div>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</nav>

{{--<div class="vertical-menu">--}}

{{--    <div data-simplebar class="h-100">--}}

{{--        <!--- Sidemenu -->--}}
{{--        <div id="sidebar-menu">--}}
{{--            <!-- Left Menu Start -->--}}
{{--            <ul class="metismenu list-unstyled" id="side-menu">--}}

{{--                <li class=" menu-title text-warning">Vận chuyển</li>--}}

{{--                @can('shipping_type-list')--}}
{{--                    <li @yield('shipping_type')>--}}
{{--                        <a href="{{route('administrator.shipping_type.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Đơn vị vận chuyển </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Quản lý đơn hàng</li>--}}

{{--                @can('order-list')--}}
{{--                    <li @yield('order')>--}}
{{--                        <a href="{{route('administrator.order.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Tất cả </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Quản lý sản phẩm</li>--}}

{{--                @can('product-list')--}}
{{--                    <li @yield('product')>--}}
{{--                        <a href="{{route('administrator.product.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Tất cả sản phẩm </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('category-list')--}}
{{--                    <li @yield('category')>--}}
{{--                        <a href="{{route('administrator.category.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Danh mục sản phẩm </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('type_sale-list')--}}
{{--                    <li @yield('type_sale')>--}}
{{--                        <a href="{{route('administrator.type_sale.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Phân loại giá </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Chăm sóc khách hàng</li>--}}

{{--                @can('chat-list')--}}
{{--                    <li @yield('chat')>--}}
{{--                        <a href="{{route('administrator.chats.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Chat </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('user-list')--}}
{{--                    <li @yield('user')>--}}
{{--                        <a href="{{route('administrator.users.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Khách hàng </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('group_user-list')--}}
{{--                    <li @yield('group_user')>--}}
{{--                        <a href="{{route('administrator.group_users.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Đối tác </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Thống kê hệ thống</li>--}}

{{--                @can('debt-list')--}}
{{--                    <li @yield('debt')>--}}
{{--                        <a href="{{route('administrator.debt.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Công nợ </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('sales_statistics-list')--}}
{{--                    <li @yield('sales_statistics')>--}}
{{--                        <a href="{{route('administrator.sales_statistics.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Thống kê doanh thu </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('inventory_statistics-list')--}}
{{--                    <li @yield('inventory_statistics')>--}}
{{--                        <a href="{{route('administrator.inventory_statistics.index' , ['search_query' => 10])}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Thống kê số lượng sản phẩm </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('product_sold_statistics-list')--}}
{{--                    <li @yield('product_sold_statistics')>--}}
{{--                        <a href="{{route('administrator.product_sold_statistics.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Thống kê sản phẩm bán theo ngày </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('receipt-list')--}}
{{--                    <li @yield('receipt')>--}}
{{--                        <a href="{{route('administrator.receipt.index' , ['start' => date("Y-m-01", strtotime(date("Y-m-d"))), "end" => date("Y-m-t", strtotime(date("Y-m-d")))])}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Phiếu thu </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('payment-list')--}}
{{--                    <li @yield('payment')>--}}
{{--                        <a href="{{route('administrator.payment.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Phiếu chi </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('cash_book-list')--}}
{{--                    <li @yield('cash_book')>--}}
{{--                        <a href="{{route('administrator.cash_book.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Sổ quỹ </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Quản lý trang</li>--}}

{{--                @can('logo-list')--}}
{{--                    <li @yield('logo')>--}}
{{--                        <a href="{{route('administrator.logo.add')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Logo </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('slider-list')--}}
{{--                    <li @yield('slider')>--}}
{{--                        <a href="{{route('administrator.slider.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Slider </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('news-list')--}}
{{--                    <li @yield('news')>--}}
{{--                        <a href="{{route('administrator.news.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Tin tức </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('category_news-list')--}}
{{--                    <li @yield('category_news')>--}}
{{--                        <a href="{{route('administrator.category_news.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Danh mục Tin tức </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Chương trình</li>--}}

{{--                @can('flash_sale-list')--}}
{{--                    <li @yield('flash_sale')>--}}
{{--                        <a href="{{route('administrator.flash_sale.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Flash sale </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('voucher-list')--}}
{{--                    <li @yield('voucher')>--}}
{{--                        <a href="{{route('administrator.voucher.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span> Mã giảm giá </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">Phân quyền</li>--}}

{{--                @can('employee-list')--}}
{{--                    <li @yield('employee')>--}}
{{--                        <a href="{{route('administrator.employees.index')}}"--}}
{{--                           class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span>Nhân viên</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('role-list')--}}
{{--                    <li @yield('role')>--}}
{{--                        <a href="{{route('administrator.roles.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span>Vai trò</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                <li class=" menu-title text-warning">More</li>--}}

{{--                @can('history-data-list')--}}
{{--                    <li @yield('history_data')>--}}
{{--                        <a href="{{route('administrator.history_data.index')}}" class="waves-effect">--}}
{{--                            <i class="mdi mdi-cube-outline"></i>--}}
{{--                            <span>Lịch sử dữ liệu</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--        <!-- Sidebar -->--}}
{{--    </div>--}}
{{--</div>--}}
