@extends('administrator.layouts.master')

@include('administrator.news.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.news.update', ['id'=> $item->id]) }}" method="post"
          enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="col-md-6">
{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col">--}}
{{--                        <input type="radio" value="1" name="type" {{$item->type == 1 ?'checked':''}}>--}}
{{--                        <label>Tin mới</label>--}}
{{--                    </div>--}}
{{--                    <div class="col">--}}
{{--                        <input type="radio" value="2" name="type" {{$item->type == 2 ?'checked':''}}>--}}
{{--                        <label>Tin khuyến mãi</label>--}}
{{--                    </div>--}}
{{--                    <div class="col"></div>--}}
{{--                    <div class="col"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="form-group mt-3">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{$item->title}}" required>
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Chọn danh mục</label>
                <select class="form-control select2_init" name="category_id">
                    <option value="0">Chọn danh mục</option>
                    {!! \App\Models\CategoryNews::getCategory($item->category_id) !!}
                </select>
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
                <label>Nhập nội dung</label>
                <textarea style="min-height: 400px;" name="contents"
                          class="form-control tinymce_editor_init @error('contents') is-invalid @enderror"
                          rows="8">{{$item->content}}</textarea>
                @error('contents')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>

        </div>
    </form>

@endsection

@section('js')

@endsection
