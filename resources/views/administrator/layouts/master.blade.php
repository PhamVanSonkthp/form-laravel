<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Infinity Ltd" name="description">
    <meta content="Pham Son" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ optional(\App\Models\Logo::first())->image_path }}">

@yield('title')

<!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/date-picker.css">
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/prism.css">
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/whether-icon.css">
    <link rel="stylesheet" type="text/css" href="/vendor/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="/vendor/owlcarousel/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="/vendor/rating/rating.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('vendor/datetimepicker/daterangepicker.css')}}"/>
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/style.css">
    <link id="color" rel="stylesheet" href="/assets/administrator/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="/assets/administrator/css/responsive.css">

    @yield('css')
</head>

<body>

<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="loader">
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-ball"></div>
    </div>
</div>
<!-- Loader ends-->

<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">

@include('administrator.components.header')

<!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper">
            <div>
                <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light"
                                                                    src="../assets/images/logo/small-logo.png"
                                                                    alt=""><img class="img-fluid for-dark"
                                                                                src="../assets/images/logo/small-white-logo.png"
                                                                                alt=""></a>
                    <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                </div>
                <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                                                                         src="../assets/images/logo-icon.png"
                                                                         alt=""></a></div>
                @include('administrator.components.slidebars')
            </div>
        </div>
        <!-- Page Sidebar Ends-->

        @yield('content')


        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright 2022 © Zeta theme by pixelstrap </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
{{--@include('administrator.components.slidebars')--}}

{{--@include('administrator.components.footer')--}}

<!-- latest jquery-->
<script src="/assets/administrator/js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap js-->
<script src="/assets/administrator/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- feather icon js-->
<script src="/assets/administrator/js/icons/feather-icon/feather.min.js"></script>
<script src="/assets/administrator/js/icons/feather-icon/feather-icon.js"></script>
<!-- scrollbar js-->
<script src="/assets/administrator/js/scrollbar/simplebar.js"></script>
<script src="/assets/administrator/js/scrollbar/custom.js"></script>
<!-- Sidebar jquery-->
<script src="/assets/administrator/js/config.js"></script>
<!-- Plugins JS start-->
<script src="/assets/administrator/js/sidebar-menu.js"></script>
<script src="/assets/administrator/js/prism/prism.min.js"></script>
<script src="/assets/administrator/js/counter/jquery.waypoints.min.js"></script>
<script src="/assets/administrator/js/counter/jquery.counterup.min.js"></script>
<script src="/assets/administrator/js/counter/counter-custom.js"></script>
<script src="/assets/administrator/js/datepicker/date-picker/datepicker.js"></script>
<script src="/assets/administrator/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="/assets/administrator/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="/assets/administrator/js/owlcarousel/owl.carousel.js"></script>
<script src="/assets/administrator/js/general-widget.js"></script>
<script src="/assets/administrator/js/tooltip-init.js"></script>
<script src="/vendor/datatable/datatables.min.js"></script>
<script src="{{asset('vendor/sweet-alert-2/sweetalert2@11.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/datetimepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/datetimepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/helper/helper.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/helper/main_helper.js')}}"></script>
<!-- Plugins JS Ends-->

<!-- Plugin used-->
<script src="/vendor/rating/jquery.barrating.js"></script>
<script src="/vendor/rating/rating-script.js"></script>
<script src="/vendor/ecommerce.js"></script>
<script src="/vendor/product-list-custom.js"></script>
<script src="/vendor/script.js"></script>
<script src="/vendor/theme-customizer/customizer.js"></script>

<!-- Theme js-->
<script src="/assets/administrator/js/script.js"></script>
<script src="/assets/administrator/js/theme-customizer/customizer.js"></script>

<script>

    // function getFormattedDate(date) {
    //     var year = date.getFullYear();
    //
    //     var month = (1 + date.getMonth()).toString();
    //     month = month.length > 1 ? month : '0' + month;
    //
    //     var day = date.getDate().toString();
    //     day = day.length > 1 ? day : '0' + day;
    //
    //     return month + '/' + day + '/' + year;
    // }

    function addUrlParameterObjects($params) {
        const searchParams = new URLSearchParams(window.location.search)

        for (let i = 0; i < $params.length; i++) {
            searchParams.set($params[i].name, $params[i].value)
        }

        window.location.search = searchParams.toString()
    }

    function updateConfig() {
        const url = new URL(decodeURIComponent(window.location.href));

        $('#select_type_user').val(url.searchParams.get("type_user")).change();

        const options = {}
        options.autoApply = false;

        if (url.searchParams.get("start")) {
            options.startDate = getOnlyDate(new Date(url.searchParams.get("start")), "mm/dd/yyyy")
        }

        if (url.searchParams.get("end")) {
            options.endDate = getOnlyDate(new Date(url.searchParams.get("end")), "mm/dd/yyyy")
        }

        $('#config-demo').daterangepicker(options, function (start, end, label) {
            addUrlParameterObjects([{name: "start", value: start.format('YYYY-MM-DD')}, {
                name: "end",
                value: end.format('YYYY-MM-DD')
            }])
        });
    }

    updateConfig()

    function viewBirthOfDay() {

        const searchParams = new URLSearchParams(window.location.search)
        searchParams.set('date_of_birth', new Date().toISOString().slice(0, 10))
        window.location.search = searchParams.toString()
    }

    function isEmptyInput(id, is_alert = false, message_alert = "", is_focus = false){
        if (!$('#' + id).val().trim()) {
            if(is_alert){
                alert(message_alert)
            }

            if(is_focus){
                $('#' + id).focus()
            }

            return true
        }
        return false
    }

    function callAjax(method = "GET", url, data, success, error){
        $.ajax({
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            data: data,
            url: url,
            beforeSend: function () {
                showLoading()
            },
            success: function (response) {
                hideLoading()
                success(response)
            },
            error: function (err) {
                hideLoading()
                Swal.fire(
                    {
                        icon: 'error',
                        title: err.responseText,
                    }
                );
                error(err)
            },
        });
    }

    function hideModal(id){
        $('#' + id).modal('hide');
    }

    function showModal(id){
        $('#' + id).modal('show');
    }

    function isCheckedInput(id){
        return $("#" + id).is(":checked") == "true" || $("#" + id).is(":checked") == true
    }

</script>

@yield('js')

</body>


</html>
