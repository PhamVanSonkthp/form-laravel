@extends('administrator.layouts.master')

@include('administrator.news.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <div class="col-md-12">
                            <a href="{{route('administrator.news.create')}}"
                               class="btn btn-success float-end m-2">Thêm mới</a>
                        </div>
                        <div class="clearfix"></div>

                        <div class="table-responsive product-table">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tiêu đề</th>
                                    <th>Hình ảnh</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>
                                            <img class="rounded-circle" src="{{$item->avatar()}}" alt="">
                                        </td>
                                        <td>

                                            <a href="{{route('administrator.news.edit' , ['id'=> $item->id ])}}"
                                               class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                Sửa
                                            </a>

                                            <a href="{{route('administrator.news.delete' , ['id'=> $item->id])}}"
                                               data-url="{{route('administrator.news.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-danger btn-sm delete action_delete" title="Delete">
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

    <script>

        function exportExcel() {
            window.location.href = "{{route('administrator.users.export')}}" + window.location.search
        }

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

