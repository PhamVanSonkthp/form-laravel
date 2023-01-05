@extends('administrator.layouts.master')

@include('administrator.sliders.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        @include('administrator.roles.search')
                    </div>

                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="table table-hover">
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

