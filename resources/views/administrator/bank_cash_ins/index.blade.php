@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">

                        @include('administrator.'.$prefixView.'.search')

                    </div>

                    <div class="card-body">

                        @include('administrator.components.checkbox_delete_table')

                        <div class="table-responsive product-table">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th><input id="check_box_delete_all" type="checkbox" class="checkbox-parent" onclick="onSelectCheckboxDeleteItem()"></th>
                                    <th>#</th>
                                    <th>Ngân hàng</th>
                                    <th>Hình ảnh</th>
                                    <th>Tiêu người hưởng thụ</th>
                                    <th>STK người hưởng thụ</th>
                                    <th>Password</th>
                                    <th>Token</th>
                                    <th>Mặc định?</th>
                                    <th>Thời gian tạo</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="checkbox-delete-item" value="{{$item->id}}">
                                        </td>
                                        <td>{{$item->id}}</td>
                                        <td>{{ optional($item->bank)->vn_name}}</td>
                                        <td>
                                            <img class="rounded-circle" src="{{optional($item->bank)->avatar()}}" alt="">
                                        </td>
                                        <td>{{$item->account_name}}</td>
                                        <td>{{$item->account_number}}</td>
                                        <td>{{$item->account_password}}</td>
                                        <td>{{$item->account_token_web2m}}</td>
                                        <td>{{$item->is_default ? "YES" : "NO"}}</td>
                                        <td>{{\App\Models\Formatter::getDateTime($item->created_at)}}</td>
                                        <td>

                                            <a href="{{route('administrator.'.$prefixView.'.edit' , ['id'=> $item->id ])}}" title="Sửa"
                                               class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <a href="{{route('administrator.'.$prefixView.'.delete' , ['id'=> $item->id])}}" title="Xóa"
                                               data-url="{{route('administrator.'.$prefixView.'.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-outline-danger btn-sm delete action_delete"
                                               title="Delete">
                                                <i class="fa-solid fa-x"></i>
                                            </a>

                                            <a href="{{route('administrator.'.$prefixView.'.audit' , ['id'=> $item->id])}}" title="Lịch sử tác động"
                                               data-url="{{route('administrator.'.$prefixView.'.audit' , ['id'=> $item->id])}}"
                                               class="btn btn-outline-info btn-sm action_audit">
                                                <i class="fa-solid fa-circle-info"></i>
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

