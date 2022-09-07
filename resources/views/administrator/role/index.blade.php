@extends('administrator.layouts.master')

@include('administrator.role.header')

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
                                    <a class="btn btn-primary float-end m-2" href="{{route('administrator.roles.create')}}">Thêm mới
                                    </a>
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
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Mô tả</th>
                                        <th style="min-width: 200px;">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($items as $index => $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->display_name}}</td>
                                            <td>
                                                <a class="btn btn-outline-secondary btn-sm edit"
                                                   href="{{route('administrator.roles.edit' , ['id'=> $item->id])}}"
                                                   data-id="{{$item->id}}">Sửa</a>

                                                <a href="{{route('administrator.roles.delete' , ['id'=> $item->id])}}"
                                                   data-url="{{route('administrator.roles.delete' , ['id'=> $item->id])}}"
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
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>

@endsection

@section('js')

    <script>

        function exportExcel() {
            window.location.href = "{{route('administrator.users.export')}}" + window.location.search
        }

        $( document ).ready(function() {

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

    <script>
        $('.checkbox_wrapper').on('click' , function (){
            $(this).parents('.card').find('.checkbox_children').prop('checked', $(this).prop('checked'))
        })
    </script>

@endsection
