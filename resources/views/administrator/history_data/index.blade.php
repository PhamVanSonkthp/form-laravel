@extends('administrator.layouts.master')

@include('administrator.history_data.header')

@section('css')

@endsection

@section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>{{$title}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid list-products">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive product-table">
                                <table class="display table-users" id="basic-1" data-order='[[ 0, "desc" ]]'>
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
            </div>
        </div>

        <div class="col-md-12">
            {{ $items->links('pagination::bootstrap-4') }}
        </div>

@endsection

@section('js')

@endsection
