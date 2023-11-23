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

                        <div class="row">
                            <div class="d-flex">

                                <div class="flex-grow-1">
                                    <a href="#">
                                        <div class="text-center">
                                            <strong>
                                                0
                                            </strong>
                                        </div>

                                        <div class="text-center">
                                            Chờ xác nhận
                                        </div>
                                    </a>

                                </div>

                                <div class="flex-grow-1">
                                    <div>
                                        <strong>
                                            0
                                        </strong>
                                    </div>

                                    <div>
                                        Đang giao
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <strong>
                                            0
                                        </strong>
                                    </div>

                                    <div>
                                        Hủy
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <strong>
                                            0
                                        </strong>
                                    </div>

                                    <div>
                                        Hoàn tiền
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
