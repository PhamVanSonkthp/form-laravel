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
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="col-md-12">
                                <a href="{{route('administrator.slider.create')}}"
                                   class="btn btn-success float-end m-2">Thêm mới</a>
                            </div>
                            <div class="clearfix"></div>

                            <div class="table-responsive product-table">
                                <table class="display table-users" id="basic-1" data-order='[[ 0, "desc" ]]'>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hình ảnh</th>
                                        <th>Link</th>
                                        <th style="min-width: 200px;">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $index => $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>
                                                <img src="{{ \App\Models\Formatter::getThumbnailImage($item->feature_image_path)}}">
                                            </td>
                                            <td>
                                                <a href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-secondary btn-sm edit"
                                                   href="{{route('administrator.slider.edit' , ['id'=> $item->id])}}"
                                                   data-id="{{$item->id}}">Sửa</a>

                                                <a href="{{route('administrator.slider.delete' , ['id'=> $item->id])}}"
                                                   data-url="{{route('administrator.slider.delete' , ['id'=> $item->id])}}"
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

