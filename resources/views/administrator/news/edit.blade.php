@extends('administrator.layouts.master')

@include('administrator.slider.header')

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

                <form action="{{route('administrator.news.update', ['id'=> $item->id]) }}" method="post"
                      enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{$item->title}}" required>
                            @error('name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

{{--                        <div class="form-group mt-3">--}}
{{--                            <label>Ảnh đại diện</label>--}}
{{--                            <input type="file" name="feature_image_path" class="form-control-file" accept="image/*">--}}
{{--                            <div class="col-md-4 container_feature_image">--}}
{{--                                <div class="row">--}}
{{--                                    <img class="feature_image" src="{{$item->feature_image_path}}" alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="mt-3 mb-3">
                            @include('administrator.components.upload_image', ['post_api' => route('ajax,administrator.upload_image.store'), 'table' => 'news' , 'image' => optional($item->image)->image_path, 'relate_id' => $item->id])
                        </div>

                        <div>
                            @include('administrator.components.upload_multiple_images', ['post_api' => route('ajax,administrator.upload_multiple_images.store'), 'delete_api' => route('ajax,administrator.upload_multiple_images.delete') , 'sort_api' => route('ajax,administrator.upload_multiple_images.sort'), 'table' => 'news' , 'images' => $item->images, 'relate_id' => $item->id])
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

            </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>
@endsection

@section('js')

@endsection
