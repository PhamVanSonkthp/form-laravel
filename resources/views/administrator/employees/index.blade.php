@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        @include('administrator.'.$prefixView.'.search')
                    </div>

                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Avatar</th>
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
                                        <td>
                                            <img class="rounded-circle" src="{{$item->avatar()}}" alt="">
                                        </td>
                                        <td>
                                            @foreach($item->roles as $role)
                                                <span class="badge bg-primary">{{$role->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{\App\Models\Formatter::getOnlyDate($item->date_of_birth)}}</td>
                                        <td>{{ optional($item->gender)->name}}</td>
                                        <td>{{\App\Models\Formatter::getDateTime($item->created_at)}}</td>
                                        <td>
                                            <a href="{{route('administrator.'.$prefixView.'.edit' , ['id'=> $item->id])}}"
                                               class="btn btn-outline-secondary btn-sm edit">Sửa</a>

                                            <a href="{{route('administrator.'.$prefixView.'.delete' , ['id'=> $item->id])}}"
                                               data-url="{{route('administrator.'.$prefixView.'.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-danger btn-sm action_delete">
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            @include('administrator.components.footer_table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
