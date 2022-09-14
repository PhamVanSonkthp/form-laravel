@extends('administrator.layouts.master')

@include('administrator.notification.header')

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
                <!-- Individual column searching (text inputs) Starts-->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive product-table">
                                <table class="display table-users" id="basic-1">
                                    <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Nội dung</th>
                                        <th></th>
                                        <th>Email</th>
                                        <th>Thời gian</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $notificationItem)
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

            </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function () {

            $(".table-users").dataTable().fnDestroy();

            var table = $('.table-users').DataTable({
                scrollX: true,
            });
            $('.table-users tbody').on('click', 'a.delete', function (e) {
                event.preventDefault()
                actionDelete(e, $(this).data('url'), table, $(this).parents('tr'))
            });

        });
    </script>
@endsection
