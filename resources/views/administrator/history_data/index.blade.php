@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
@endsection

@section('name')
    <h4 class="page-title">Nhân viên</h4>
@endsection

@section('css')
    <link href="{{asset('admins/products/index/list.css')}}" rel="stylesheet"/>
@endsection

@include('administrator.history_data.active_slidebar')

@section('content')
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>IP Address</th>
                            <th>Người tác động</th>
                            <th>Event</th>
                            <th>Dữ liệu cũ</th>
                            <th>Dữ liệu mới</th>
                            <th>Ngày tạo</th>
                            <th>Agent</th>
                            <th>Url</th>
                            <th>Model</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->ip_address}}</td>
                                <td>{{ optional($item->user)->name}}</td>
                                <td>{{$item->event}}</td>
                                <td>
                                    <ul>
                                        @foreach((json_decode(($item->old_values) , true)) as $key=>$value)
                                            <li>
                                                {{$key}} : {{$value}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach((json_decode(($item->new_values) , true)) as $key=>$value)
                                            <li>
                                                {{$key}} : {{$value}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->user_agent}}</td>
                                <td>{{$item->url}}</td>
                                <td>{{$item->user_type}}</td>
                                <td>{{$item->auditable_type}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-12">
        {{ $items->links('pagination::bootstrap-4') }}
    </div>

@endsection

@section('js')
    <script src="{{asset('vendor/sweet-alert-2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/products/index/list.js')}}"></script>
@endsection
