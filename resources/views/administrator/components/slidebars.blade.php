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
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/chats">
                        <i class="fa-regular fa-comment"></i>
                        <span>Chat</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            <li class="sidebar-list">
                <a class="sidebar-link sidebar-title" href="javascript:void(0)" data-bs-original-title="" title="">
                    <i class="fa-solid fa-scale-unbalanced-flip"></i>
                    <span class="">Bán hàng</span>
                </a>
                <ul class="sidebar-submenu" style="display: none;">

                    @can('job_emails-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/categories">
                                <i class="fa-solid fa-stairs"></i>
                                <span>Danh mục sản phẩm</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('products-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/products">
                                <i class="fa-solid fa-shapes"></i>
                                <span>Sản phẩm</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('orders-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/orders">
                                <i class="fa-solid fa-file-invoice"></i>
                                <span>Đơn hàng</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('vouchers-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/vouchers">
                                <i class="fa-solid fa-percent"></i>
                                <span>Mã giảm giá</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('product_comments-list')
                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/product-comments">
                                <i class="fa-solid fa-percent"></i>
                                <span>Bình luận sản phẩm</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

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
                                <i class="fa-regular fa-star"></i>
                                <span>Điểm</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/banks">
                                <i class="fa-solid fa-building-columns"></i>
                                <span>Ngân hàng</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/bank-cash-ins">
                                <i class="fa-solid fa-wallet"></i>
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
                                <i class="fa-solid fa-sliders"></i>
                                <span>Slider</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('sliders-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/system-branches">
                                <i class="fa-solid fa-code-branch"></i>
                                <span>Hệ thống cửa hàng</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('logos-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/logos">
                                <i class="fa-brands fa-laravel"></i>
                                <span>Logo</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('news-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/category-news">
                                <i class="fa-solid fa-earth-oceania"></i>
                                <span>Danh mục tin tức</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                    @can('news-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav"
                                href="/administrator/news">
                                <i class="fa-regular fa-newspaper"></i>
                                <span>Tin tức</span>
                                <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

            @can('medias-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/medias">
                        <i class="fa-regular fa-folder-open"></i>
                        <span>Quản lý file</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

            @can('medias-list')
                <li class="sidebar-list">
                    <a
                        class="sidebar-link sidebar-title link-nav" href="/administrator/payment-methods">
                        <i class="fa-regular fa-credit-card"></i>
                        <span>Quản lý thanh toán</span>
                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                </li>
            @endcan

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

                    @can('shipping_methods-list')
                        <li>
                            <a
                                class="sidebar-link sidebar-title link-nav" href="/administrator/shipping-methods">
                                <span>Phương thức vận chuyển</span>
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
