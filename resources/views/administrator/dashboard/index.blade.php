@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
@endsection

@section('name')
    <h4 class="page-title">Tổng quan</h4>
@endsection

@section('css')

@endsection

@section('content')

    @can('dashboard-list')
        <div class="container-fluid general-widget">


            <div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <strong>
                                Danh sách cần làm
                            </strong>
                        </div>

                        <div class="row mt-3">
                            <div class="d-flex">

                                <div class="flex-grow-1">
                                    <a href="{{route('administrator.orders.index', ['order_status_id' => 1])}}">
                                        <div class="text-center" style="font-size: 20px;">
                                            <strong>
                                                0
                                            </strong>
                                        </div>

                                        <div class="text-center text-dark">
                                            Chờ xác nhận
                                        </div>
                                    </a>

                                </div>

                                <div class="flex-grow-1">
                                    <a href="{{route('administrator.orders.index', ['order_status_id' => 2])}}">
                                        <div class="text-center" style="font-size: 20px;">
                                            <strong>
                                                0
                                            </strong>
                                        </div>

                                        <div class="text-center text-dark">
                                            Đang giao
                                        </div>
                                    </a>

                                </div>

                                <div class="flex-grow-1">
                                    <a href="{{route('administrator.orders.index', ['order_status_id' => 3])}}">
                                        <div class="text-center" style="font-size: 20px;">
                                            <strong>
                                                0
                                            </strong>
                                        </div>

                                        <div class="text-center text-dark">
                                            Hoàn thành
                                        </div>
                                    </a>

                                </div>

                                <div class="flex-grow-1">
                                    <a href="{{route('administrator.orders.index', ['order_status_id' => 4])}}">
                                        <div class="text-center" style="font-size: 20px;">
                                            <strong>
                                                0
                                            </strong>
                                        </div>

                                        <div class="text-center text-dark">
                                            Hủy
                                        </div>
                                    </a>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <strong>
                                Phân tích bán hàng
                            </strong>
                        </div>

                        <div class="row mt-3">
                            <div class="d-flex">

                                <div class="flex-grow-1">
                                    <div>
                                        Doanh số
                                    </div>

                                    <div>

                                    </div>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div>
                                                Lượt truy cập
                                            </div>

                                            <div>
                                                <strong style="font-size: 20px;">
                                                    0
                                                </strong>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1">
                                            <div>
                                                Lượt xem
                                            </div>
                                            <div>
                                                <strong style="font-size: 20px;">
                                                    0
                                                </strong>
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
    @else
        Bạn không có quyền truy cập Dashboard
    @endcan

@endsection

@section('js')

@endsection
