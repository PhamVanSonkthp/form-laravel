@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
@endsection

@section('name')
    <h4 class="page-title">Email</h4>
@endsection

@section('css')
    <link href="{{asset('admins/products/index/list.css')}}" rel="stylesheet"/>
@endsection

@include('administrator.notification.active_slidebar')

@section('content')
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{route('administrator.notification.edit')}}" class="btn btn-success float-end m-2">Thay
                        đổi nội dung email</a>
                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th>Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $notificationItem)
                            <tr>
                                <td>
                                    @if(isset($notificationItem->data) && isset(json_decode($notificationItem->data , true)['body']))
                                        {{ json_decode($notificationItem->data, true)['body'] }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($notificationItem->data) && isset(json_decode($notificationItem->data , true)['text']))
                                        {{ json_decode($notificationItem->data, true)['text'] }}
                                    @endif
                                </td>
                                <td>{{ optional( $notificationItem->user)->name }}</td>
                                <td>{{ optional($notificationItem->user)->email }}</td>
                                <td>{{ $notificationItem->created_at }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-12">
        {{ $notifications->links('pagination::bootstrap-4') }}
    </div>

@endsection

@section('js')
    <script src="{{asset('vendor/sweet-alert-2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/products/index/list.js')}}"></script>
@endsection
