@extends('administrator.layouts.master')

@include('administrator.user.header')

@section('css')

@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
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
                                <a class="btn btn-primary float-end m-2" href="{{route('administrator.users.create')}}">Thêm
                                    mới
                                </a>
                                <button onclick="exportExcel()" class="btn btn-success float-end m-2">Export
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>Mã KH</th>
                                    <th>Avatar</th>
                                    <th>Tên KH</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sử dụng</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>
                                            <img class="rounded-circle" src="{{$item->avatar()}}" alt="">
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{\App\Models\Formatter::getOnlyDate($item->date_of_birth)}}</td>
                                        <td>{{ optional($item->gender)->name}}</td>
                                        <td>{{\App\Models\Formatter::getDateTime($item->created_at)}}</td>
                                        <td>
                                            <a href="{{route('administrator.users.edit' , ['id'=> $item->id])}}"
                                               class="btn btn-outline-secondary btn-sm edit">Sửa</a>

                                            <a href="{{route('administrator.users.delete' , ['id'=> $item->id])}}"
                                               data-url="{{route('administrator.users.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-danger btn-sm action_delete">
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $items->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Individual column searching (text inputs) Ends-->
    <!-- Container-fluid Ends-->

@endsection

@section('js')

@endsection
