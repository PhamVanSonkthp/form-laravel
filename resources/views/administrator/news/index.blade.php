@extends('administrator.layouts.master')

@include('administrator.news.header')

@section('css')

@endsection

@section('content')
    <div class="col-12">

        <div class="card">
            <div class="card-body">

                <div class="col-md-12">
                    <a href="{{route('administrator.news.create')}}" class="btn btn-success float-end m-2">Thêm mới</a>
                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục</th>
                            <th class="text-center" style="width: 100px;">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{$item->title}}</td>
                                <td>
                                    <img style="width: 60px;height: 60px;object-fit: cover;" src="{{$item->feature_image_path}}">
                                </td>
                                <td>{{ optional($item->category)->name}}</td>
                                <td>

                                    <a href="{{route('administrator.news.edit' , ['id'=> $item->id ])}}"
                                       class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="{{route('administrator.news.delete' , ['id'=> $item->id])}}"
                                       data-url="{{route('administrator.news.delete' , ['id'=> $item->id])}}"
                                       class="btn btn-danger btn-sm delete action_delete" title="Delete">
                                        <i class="mdi mdi-close"></i>
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

    <div class="col-md-12">
        {{ $items->links('pagination::bootstrap-4') }}
    </div>

@endsection

@section('js')

@endsection
