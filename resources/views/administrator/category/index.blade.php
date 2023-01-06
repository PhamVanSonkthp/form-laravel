@extends('administrator.layouts.master')

@include('administrator.category.header')

@section('css')

@endsection

@section('content')
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="display: flex;align-items: center">
                        <div class="search_style" style="display: flex;align-items: center">
                            <input type="text" class="form-control" id="input_search"
                                   placeholder="Tìm kiếm"
                                   onkeydown="search(this)" data-suffix="">
                            <button class="btn btn-info" onclick="searchButton()">
                                <i class="mdi mdi-magnify" ></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md">
                        <a href="{{route('administrator.category.create')}}" class="btn btn-success float-end m-2">Thêm mới</a>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục cha</th>
                            <th class="text-center" style="width: 100px;">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>
                                    <img style="width: 60px;height: 60px;object-fit: cover;" src="{{$item->feature_image_path}}">
                                </td>
                                <td>{{ optional($item->rootParent())->name}}</td>
                                <td>

                                    <a href="{{route('administrator.category.edit' , ['id'=> $item->id ])}}"
                                       class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="{{route('administrator.category.delete' , ['id'=> $item->id])}}"
                                       data-url="{{route('administrator.category.delete' , ['id'=> $item->id])}}"
                                       class="btn btn-danger btn-sm delete action_delete" title="Delete">
                                        <i class="mdi mdi-close"></i>
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

@endsection

@section('js')

@endsection
