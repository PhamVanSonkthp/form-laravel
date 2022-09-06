<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    @yield('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pham Son" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ optional(\App\Models\Logo::first())->image_path }}">

    <!-- Bootstrap Css -->
    <link href="{{asset('administrator/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('administrator/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('administrator/assets/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('vendor/fontawesome-6.0.0/css/fontawesome.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('user/assets/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('user/assets/css/responsive.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>
        *{
            font-family: 'Montserrat', sans-serif !important;
        }

        @media (max-width: 991.98px){
            .footer {
                left: 0 !important;
            }
        }
        @media (max-width: 992px) {
            .navbar-brand-box {
                display: none !important;
            }

            #myTab > li{
                width: 100%;
            }
            .nav-tabs>li.active>a{
                border-bottom-color: #ddd !important;
            }

        }

        .search_init{
            display: inline-block !important;
        }

        i{
            font-family: 'Font Awesome 5 Free' !important;
        }
        @media (max-width: 425px){
            .search-wrap{
                width: 100% !important;
            }
        }

        /*.color-prime{*/
        /*    background-color: #D3B574 !important;*/
        /*    border: 1px solid #D3B574 !important;*/
        /*    color: white !important;*/
        /*}*/

    </style>
    @yield('css')

</head>

<body id="body" data-sidebar="dark" class="">


<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<!-- Begin page -->
<div id="layout-wrapper">

@include('user.components.header')

<!-- ========== Left Sidebar Start ========== -->
@include('user.components.slidebars')
<!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="main-content">
        <div class="page-content bg-white">
            <div class="container-fluid">
                {{--                <div class="row">--}}
                @yield('content')
                {{--                </div>--}}
            </div>
        </div>
    </div>


@include('user.components.footer')
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-end">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>

        <!-- Settings -->
        <hr class="mt-0">
        <h6 class="text-center mb-0">Choose Layouts</h6>

        <div class="p-4">
            <div class="mb-2">
                <img src="{{asset('administrator/assets/images/layouts/layout-1.jpg')}}" class="img-fluid img-thumbnail"
                     alt="Layouts-1">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                <label class="form-check-label" for="light-mode-switch">Light Mode</label>
            </div>

            <div class="mb-2">
                <img src="{{asset('administrator/assets/images/layouts/layout-2.jpg')}}" class="img-fluid img-thumbnail"
                     alt="Layouts-2">
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                       data-bsStyle="{{asset('administrator/assets/css/bootstrap-dark.min.css')}}"
                       data-appStyle="{{asset('administrator/assets/css/app-dark.min.css')}}">
                <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
            </div>

            <div class="mb-2">
                <img src="{{asset('administrator/assets/images/layouts/layout-3.jpg')}}" class="img-fluid img-thumbnail"
                     alt="Layouts-3">
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch"
                       data-appStyle="{{asset('administrator/assets/css/app-rtl.min.css')}}">
                <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
            </div>


        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>


<!-- JAVASCRIPT -->
<script src="{{asset('administrator/assets/libs/jquery/jquery.min.js')}}"></script>

<script>
    function deviceTypeMobile() {
        const ua = navigator.userAgent;
        if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
            return true
        } else if (/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
            return true
        }
        return false
    }

    if (!deviceTypeMobile()) {
        $('#body').addClass('vertical-collpsed')
    }
</script>

<script src="{{asset('administrator/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('administrator/assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('administrator/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('administrator/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('administrator/assets/js/app.js')}}"></script>

<script>
    function search(ele) {
        if (event.key === 'Enter') {
            window.location.href = "{{route("welcome.search")}}" + "?search_query=" + ele.value
        }
    }
</script>

@yield('js')

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "702514143497679");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v13.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

</body>


</html>
