@extends('administrator.layouts.master')

@include('administrator.test.header')

@section('css')


@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">

            <form action="{{route('administrator.test.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">

                    <div class="form-group mt-3">
                        <label>Tiêu đề</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{old('title')}}" required>
                        @error('title')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">

                        @if($isSingleImage)
                            <div class="mt-3 mb-3">
                                @include('administrator.components.upload_image', ['post_api' => $imagePostUrl, 'table' => 'news', 'image' => optional(\App\Models\SingpleImage::where('relate_id', \App\Models\Helper::getNextIdTable('news'))->where('table','news')->first())->image_path , 'relate_id' => \App\Models\Helper::getNextIdTable('news')])
                            </div>
                        @endif

                        @if($isMultipleImages)
                            <div class="mt-3 mb-3">
                                @include('administrator.components.upload_multiple_images', ['post_api' => route('ajax,administrator.upload_multiple_images.store'), 'delete_api' => route('ajax,administrator.upload_multiple_images.delete') , 'sort_api' => route('ajax,administrator.upload_multiple_images.sort'), 'table' => 'news' , 'images' => \App\Models\Image::where('relate_id', \App\Models\Helper::getNextIdTable('news'))->where('table','news')->orderBy('index')->get(),'relate_id' => \App\Models\Helper::getNextIdTable('news')])
                            </div>
                        @endif

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

        </div>

    </div>

@endsection

@section('js')


@endsection
