@extends('administrator.layouts.master')

@include('administrator.employees.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label>Ngày tạo</label>
                                <span>
                                        <input type="text" id="config-demo" class="form-control">
                                    </span>
                            </div>

                            <div class="col-md-9 text-end">
                                <button class="btn btn-primary float-end m-2" data-bs-toggle="modal"
                                        data-bs-target="#modal_add_user" data-bs-whatever="@mdo">Thêm mới
                                </button>
                                <button onclick="exportExcel()" class="btn btn-success float-end m-2">Export
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="display table-users" id="basic-1" data-order='[[ 0, "desc" ]]'>
                                <thead>
                                <tr>
                                    <th>Mã NV</th>
                                    <th>Vai trò</th>
                                    <th>Tên NV</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sử dụng</th>
                                    <th style="min-width: 200px;">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{optional($item->role)->name}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{\App\Models\Formatter::getOnlyDate($item->date_of_birth)}}</td>
                                        <td>{{ optional($item->gender)->name}}</td>
                                        <td>{{\App\Models\Formatter::getDateTime($item->created_at)}}</td>
                                        <td>
                                            <a class="btn btn-outline-secondary btn-sm edit"
                                               data-id="{{$item->id}}">Sửa</a>

                                            <a href="{{route('administrator.users.delete' , ['id'=> $item->id])}}"
                                               data-url="{{route('administrator.users.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-danger btn-sm delete">
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
