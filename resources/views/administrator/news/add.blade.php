@extends('administrator.layouts.master')

@include('administrator.news.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.news.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col">--}}
{{--                        <input type="radio" value="1" name="type">--}}
{{--                        <label>Tin mới</label>--}}
{{--                    </div>--}}
{{--                    <div class="col">--}}
{{--                        <input type="radio" value="2" name="type">--}}
{{--                        <label>Tin khuyến mãi</label>--}}
{{--                    </div>--}}
{{--                    <div class="col"></div>--}}
{{--                    <div class="col"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="form-group mt-3">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{old('title')}}" required>
                @error('title')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Chọn danh mục</label>
                <select class="form-control select2_init @error('category_id') is-invalid @enderror"
                        name="category_id">
                    <option value="0">Chọn danh mục</option>
                    {!! \App\Models\CategoryNews::getCategory() !!}
                </select>
                @error('category_id')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="feature_image_path" class="form-control-file" accept="image/*" required>


                <div class="form-group mt-3">
                    <label>Nhập nội dung</label>
                    <textarea style="min-height: 400px;" name="contents"
                              class="form-control tinymce_editor_init @error('contents') is-invalid @enderror"
                              rows="8">{{old('contents')}}</textarea>
                    @error('contents')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
            </div>
        </div>
    </form>

@endsection


@section('js')

@endsection
