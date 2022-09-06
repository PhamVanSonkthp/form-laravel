@extends('user.layouts.master')

@php
    $title = config('app.name', 'Laravel');
@endphp

@section('title')
    <title>{{$title}}</title>

    <meta name="keyword" content="Mau Bui Finance">
    <meta name="promotion" content="Mau Bui Finance">
    <meta name="Description" content="Mau Bui Finance - Khóa học về Crypto">

    <meta property="og:url" content="{{env('APP_URL')}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Mau Bui Finance" />
    <meta property="og:description" content="Mau Bui Finance - Khóa học về Crypto" />
    <meta property="og:image" content="{{env('APP_URL') . optional(\App\Models\Logo::first())->image_path }}" />

@endsection

@section('name')
    <h4 class="page-title">{{$title}}</h4>
@endsection

@section('css')
    <link rel="stylesheet" href="{{'vendor/owlcarousel/assets/owl.carousel.css'}}" />

    <style>

        @media only screen and (max-width: 1023px) {
            .route__course-item.trading {
                padding-bottom: 0px;
                margin-bottom: 10px;
            }

            .col-lg-4.col-md-6.col-sm-6.col-12 {
                margin-bottom: 20px;
            }
        }

        .route__course-title {
            font-weight: bold;
        }

        .banner__slide-img {
            max-height: 500px !important;
        }

        @media only screen and (max-width: 991px) {
            .route__course-pack-content {
                margin-bottom: 165px !important;
            }
        }

        @media only screen and (min-width: 992px) {
            .route__course-pack-content {
                margin-bottom: 70px !important;
            }
        }

        @media only screen and (min-width: 1115px) {
            .route__course-pack-content {
                margin-bottom: 40px !important;
            }
        }


    </style>
@endsection

@section('content')

    <div class="banner">
        <div class="owl-carousel owl-theme" id="slideProduct">
            @foreach($sliders as $sliderItem)
                <a @if(!empty($sliderItem->link)) href="{{$sliderItem->link}}" @endif class="banner__slide-img">
                    <img src="{{$sliderItem->image_path}}"
                         alt="{{$sliderItem->image_name}}" class="banner__slide-img"></img>
                </a>
            @endforeach
        </div>
    </div>

    @auth()
        @php
            $tradingOfUser = \App\Models\TradingOfUser::where('user_id' , auth()->id())->first();
        @endphp
    @endauth

    <div class="route">
        <h3 class="route__nav-heading">CÁC KHÓA HỌC</h3>
        <div class="route__course">
            <div class="row gx-4">

                @foreach($products as $productItem)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="route__course-item">
                            <div class="route__course-img"
                                 style="background-image: url({{$productItem->feature_image_path}})">
                                <div class="overlay"></div>
                                <div class="button">
                                    <a href="{{ route('welcome.product', ['slug' => $productItem->slug]) }}">Xem Khóa
                                        học</a>
                                </div>
                            </div>
                            <h4 class="route__course-title">{{$productItem->name}}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="route">
        <div class="container">
            <div class="route__nav">
                <h3 class="route__nav-heading">MAU BUI VIP PLANS</h3>
            </div>

            <div class="route__course">
                <div class="row gx-4 justify-content-center">
                    @php
                        $isUpgrade = false;
                    @endphp

                    @foreach($tradings as $index=> $tradingItem)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12"

                             @auth()
                             @if(\App\Models\TradingOfUser::where('user_id', \Illuminate\Support\Facades\Auth::id())->first())

                             @php
                                 $isUpgrade = true;
                             @endphp
                             style="{{ \App\Models\TradingOfUser::where('user_id', \Illuminate\Support\Facades\Auth::id())->first()->trading_id == $tradingItem->id ? 'opacity: 0.5;pointer-events: none;' : '' }}"
                            @endif
                            @endauth
                        >
                            <div class="route__course-item trading route__course-pack-content">
                                <div class="route__course-img"
                                     style="background-image: url({{$tradingItem->feature_image_path}})">
                                    <div class="overlay"></div>
                                    <div class="button">

                                        @auth()
                                            <a
                                                {{$isUpgrade ? ('href=' . route('user.tradings.upgrade_trading' , ['trading_id_now' => \App\Models\TradingOfUser::where('user_id', auth()->id())->first()->trading_id , 'trading_id_feature' => $tradingItem->id]) ) : ('href=' . route('user.paymentTrading' , ['id'=> $tradingItem->id]) ) }}>
                                                {{$isUpgrade ? 'Nâng Cấp Ngay' : 'Đăng Ký Ngay'}}
                                            </a>
                                        @else
                                            <a data-bs-toggle=modal data-bs-target="#Modal{{$tradingItem->id}}" data-bs-whatever="@mdo">
                                                Đăng Ký Ngay
                                            </a>
                                        @endauth

{{--                                        <a href="{{route('welcome.trading' , ['slug'=>$tradingItem->slug])}}">Xem chi--}}
{{--                                            tiết</a>--}}
                                    </div>
                                </div>
{{--                                <h4 class="route__course-title ms-3">{{$tradingItem->name}}</h4>--}}

                                <div class="route__course-pack">
                                    <div class="route__course-pack-header color-prime">
                                        {{--                                        <h4 class="route__course-pack-name">GOLD</h4>--}}
                                        <h4 class="route__course-title">{{$tradingItem->name}}</h4>
                                        <p class="route__course-pack-duration">{{$tradingItem->time_payment_again}}
                                            -month subscription</p>
                                        @if( \Illuminate\Support\Str::contains(strtoupper($tradingItem->name) , "DIAMOND" ))
                                            <span class="route__course-pack-discount">BEST PLAN</span>
                                        @endif

                                    </div>
                                    <div class="route__course-pack-content">
                                        <div class="route__course-pack-price">
                                            <div class="route__course-pack-money">
                                                ${{number_format($tradingItem->price / $tradingItem->time_payment_again)}}</div>
                                            <div class="route__course-pack-limit" style="font-size: 40px;">
                                                <span>${{number_format($tradingItem->realPrice($tradingItem->id) / $tradingItem->time_payment_again)}}/mo</span>
                                            </div>
                                        </div>

                                        {!! $tradingItem->content !!}

                                        <div class="route__course-pack-footer">

                                            @auth()
                                                <a class="btn btn-warning route__course-pack-btn color-prime" style="width: 70%;"
                                                    {{$isUpgrade ? ('href=' . route('user.tradings.upgrade_trading' , ['trading_id_now' => \App\Models\TradingOfUser::where('user_id', auth()->id())->first()->trading_id , 'trading_id_feature' => $tradingItem->id]) ) : ('href=' . route('user.paymentTrading' , ['id'=> $tradingItem->id]) ) }}
                                                    @if($isUpgrade)
                                                    data-bs-toggle=modal data-bs-target="#Modal{{$tradingItem->id}}"
                                                   data-bs-whatever="@mdo"
                                                    @endif
                                                >
                                                    {{$isUpgrade ? 'Nâng Cấp Ngay' : 'Đăng Ký Ngay'}}
                                                </a>

                                                @if($isUpgrade)
                                                    <p class="text-center mt-3" style="font-weight: bold;{{ \App\Models\TradingOfUser::where('user_id', \Illuminate\Support\Facades\Auth::id())->first()->trading_id == $tradingItem->id ? 'opacity: 0.0;' : '' }}">Tiết kiệm:
                                                        <strong style="color:#fb4; ">
                                                            ${{ number_format($tradingItem->saveOnUpgrade($tradingItem->id) , 1)  }}
                                                        </strong>
                                                        khi nâng cấp</p>
                                                @endif
                                            @else
                                                <a class="btn btn-warning route__course-pack-btn color-prime" style="width: 70%;" data-bs-toggle=modal data-bs-target="#Modal{{$tradingItem->id}}" data-bs-whatever="@mdo">
                                                    Đăng Ký Ngay
                                                </a>
                                            @endauth


                                            <p class="route__course-pack-description">
                                                ${{number_format($tradingItem->realPrice($tradingItem->id))}} total
                                                for {{$tradingItem->time_payment_again}}-mo subscription
                                            </p>
                                        </div>

                                        @if($isUpgrade)
                                            <div class="modal fade" id="Modal{{$tradingItem->id}}" tabindex="-1"
                                                 aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ModalLabel">
                                                                Nâng cấp VIP Plan</h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="">
                                                                <div class="row justify-content-center">
                                                                    <div>
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="p-3">
                                                                                    <div class="mt-2">
                                                                                        <p for="name"
                                                                                           class="col-form-label">Nâng cấp
                                                                                            từ gói
                                                                                            <strong>{{ str_replace("PLAN" , "" , optional($tradingOfUser->trading)->name)}}</strong>
                                                                                            lên gói
                                                                                            <strong>{{ str_replace("PLAN" , "" , $tradingItem->name)}}</strong>
                                                                                        </p>
                                                                                    </div>

{{--                                                                                    <div class="form-group mt-2">--}}
{{--                                                                                        <p for="name"--}}
{{--                                                                                           class="col-form-label">Tiết kiệm--}}
{{--                                                                                            <strong>${{ number_format(($tradingItem->realPrice($tradingItem->id) - $tradingItem->realPriceUpgrade($tradingItem->id, auth()->id())) , 1) }}</strong>--}}
{{--                                                                                            khi nâng cấp--}}
{{--                                                                                        </p>--}}
{{--                                                                                    </div>--}}

                                                                                    <div class="form-group mt-2">
                                                                                        <p for="name"
                                                                                           class="col-form-label">Đóng thêm:
                                                                                            <strong>${{$tradingItem->realPriceUpgrade($tradingItem->id, auth()->id())}}</strong>
                                                                                        </p>
                                                                                    </div>

                                                                                    <div class="form-group mt-2">
                                                                                        <p class="col-form-label">
                                                                                            Gói mới sẽ bắt đầu từ
                                                                                            <strong>{{date('Y-m-d')}}</strong>
                                                                                            đến
                                                                                            <strong>{{date('Y-m-d', strtotime("+3 ".$tradingItem->time_payment_again."months", strtotime(date('Y-m-d'))))}}</strong>
                                                                                        </p>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Đóng
                                                            </button>
                                                            <a href="{{route('user.tradings.upgrade_trading' , ['trading_id_now' => $tradingOfUser->trading_id , 'trading_id_feature' => $tradingItem->id])}}"
                                                               class="btn btn-warning color-prime">Xác nhận nâng cấp
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            @if(!$isUpgrade)
                                <div class="modal fade" id="Modal{{$tradingItem->id}}" tabindex="-1"
                                     aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post"
                                                  action="{{route('user.create_account_to_buy_trading',["idTrading" => $tradingItem->id])}}">
                                                @csrf

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalLabel">
                                                        Tạo mới tài khoản / Đăng nhập</h5>
                                                    <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="">
                                                        <div class="row justify-content-center">
                                                            <div>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="p-3">
                                                                            <div class="mb-3">
                                                                                <label for="name"
                                                                                       class="col-form-label text-md-end">Họ và
                                                                                    tên </label>

                                                                                <div>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="name"
                                                                                           value="{{ old('name') }}"
                                                                                           autocomplete="name">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group mt-3">
                                                                                <div>
                                                                                    <label>Nhập email<span class="text-danger">*</span></label>
                                                                                    <input name="email" type="email" class="form-control">
                                                                                </div>

                                                                                <div class="mt-3">
                                                                                    <label>Nhập password<span class="text-danger">*</span></label>
                                                                                    <input name="password" type="password" class="form-control">
                                                                                </div>

                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="refer"
                                                                                       class="col-form-label text-md-end">Mã giới thiệu</label>
                                                                                <div>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="refer"
                                                                                           value="{{ old('refer') }}"
                                                                                           autocomplete="refer">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-0 row">
                                                                                <div class="col-12 mt-4">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="checkbox" value=""
                                                                                               id="flexCheckDefault" checked>
                                                                                        <label class="form-check-label"
                                                                                               for="flexCheckDefault">
                                                                                            <p class=" text-muted mb-0">Bằng
                                                                                                cách xác nhận, bạn đồng ý
                                                                                                với <a href="">điều khoản thanh toán</a> của chúng tôi
                                                                                        </label>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng
                                                    </button>
                                                    <button type="submit" class="btn btn-warning">Xác nhận
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>

    @auth()

        @if(count($postTradings) > 0)
            <div class="route">
                <div class="container">
                    <div class="route__nav">
                        <h3 class="route__nav-heading">Bài viết trading</h3>
                        <a href="{{route('welcome.postTradings')}}" class="route__nav-link">
                            Xem tất cả
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right"
                                 class="svg-inline--fa fa-chevron-right fa-w-10 " role="img"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 320 512">
                                <path fill="currentColor"
                                      d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <div class="route__course">
                        <div class="row gx-4">
                            @foreach($postTradings as $postTradingItem)

                                @php
                                    $isHave = false;
                                    if(count(json_decode($postTradingItem->require_trading_id, true)) > 0){
                                        foreach (json_decode($postTradingItem->require_trading_id, true) as $requireTradingIdItem){
                                            if(!empty(\App\Models\TradingOfUser::where('trading_id' , $requireTradingIdItem)->where('user_id' , \Illuminate\Support\Facades\Auth::id())->first())){
                                                $isHave = true;
                                                break;
                                            }
                                        }
                                    }else{
                                        $isHave = true;
                                    }
                                @endphp

                                @if($isHave)
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="route__course-item">
                                            <div class="route__course-img"
                                                 style="background-image: url({{$postTradingItem->image_path}})">
                                                <div class="overlay"></div>
                                                <div class="button">
                                                    <a href="{{route('welcome.postTrading' , ['slug'=>$postTradingItem->slug])}}">Xem bài viết</a>
                                                </div>
                                            </div>
                                            <h4 class="route__course-title">{{$postTradingItem->title}}</h4>
                                        </div>
                                    </div>
                                @endif

                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        @endif

    @endauth

    @if(count($posts) > 0)
        <div class="route">
            <div class="container">
                <div class="route__nav">
                    <h3 class="route__nav-heading">Tin tức</h3>
                    <a href="{{route('welcome.posts')}}" class="route__nav-link">
                        Xem tất cả
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right"
                             class="svg-inline--fa fa-chevron-right fa-w-10 " role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 320 512">
                            <path fill="currentColor"
                                  d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z">
                            </path>
                        </svg>
                    </a>
                </div>

                <div class="route__course">
                    <div class="row gx-4">
                        @foreach($posts as $postItem)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="route__course-item">
                                    <div class="route__course-img"
                                         style="background-image: url({{$postItem->image_path}})">
                                        <div class="overlay"></div>
                                        <div class="button">
                                            <a href="{{route('welcome.post' , ['slug'=>$postItem->slug])}}">Xem tin</a>
                                        </div>
                                    </div>
                                    <h4 class="route__course-title">{{$postItem->title}}</h4>
                                    {{--                                <div class="route__course-number">--}}
                                    {{--                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye"--}}
                                    {{--                                         class="svg-inline--fa fa-eye fa-w-18 " role="img"--}}
                                    {{--                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">--}}
                                    {{--                                        <path fill="currentColor"--}}
                                    {{--                                              d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">--}}
                                    {{--                                        </path>--}}
                                    {{--                                    </svg>--}}
                                    {{--                                    <span>{{$postItem->views_count}}</span>--}}
                                    {{--                                </div>--}}
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    @endif

@endsection

@section('js')
    <script src="{{asset('vendor/sweet-alert-2/sweetalert2@11.js')}}"></script>
    <script type="text/javascript" src="{{'vendor/owlcarousel/owl.carousel.js'}}"></script>

    <script>
        // Slide banner Image
        $(document).ready(function () {
            var owl = $("#slideProduct");
            owl.owlCarousel({
                loop: true,
                margin: 0,
                autoplay: true,
                slideSpeed: 2000,
                nav: false,
                navText: ["<span>‹</span>", "<span>›</span>"],
                dots: false,
                items: 1,
            });
        });
    </script>

    @if (Session::has('message'))
        <script>
            Swal.fire({
                text:"{{Session::get('message')}}",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Xác nhận'
            })
        </script>
    @endif
@endsection
