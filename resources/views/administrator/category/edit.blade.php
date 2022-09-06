@extends('administrator.layouts.master')

@include('administrator.category.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.category.update', ['id'=> $item->id]) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="col-md-6">

            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$item->name}}" required>
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="feature_image_path" class="form-control-file" accept="image/*">
                <div class="col-md-4 container_feature_image">
                    <div class="row">
                        <img class="feature_image" src="{{$item->feature_image_path}}" alt="">
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Chọn danh mục cha</label>
                <select class="form-control select2_init" name="parent_id">
                    <option value="0">Chọn danh mục cha</option>
                    {!! \App\Models\Category::getCategory($item->parent_id) !!}
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>

        </div>
    </form>

@endsection

@section('js')

@endsection
