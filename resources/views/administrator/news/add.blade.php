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

                {{--                <form action="{{route('administrator.news.store')}}" method="post" enctype="multipart/form-data">--}}
                {{--                    @csrf--}}
                {{--                    <div class="col-md-12">--}}


                {{--                        <div class="form-group mt-3">--}}
                {{--                            <label>Tiêu đề</label>--}}
                {{--                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"--}}
                {{--                                   value="{{old('title')}}" required>--}}
                {{--                            @error('title')--}}
                {{--                            <div class="alert alert-danger">{{$message}}</div>--}}
                {{--                            @enderror--}}
                {{--                        </div>--}}

                {{--                        <div class="form-group mt-3">--}}
                {{--                            <label>Ảnh đại diện</label>--}}
                {{--                            <input type="file" name="feature_image_path" class="form-control-file" accept="image/*"--}}
                {{--                                   required>--}}


                {{--                            <div class="form-group mt-3">--}}
                {{--                                <label>Nhập nội dung</label>--}}
                {{--                                <textarea style="min-height: 400px;" name="contents"--}}
                {{--                                          class="form-control tinymce_editor_init @error('contents') is-invalid @enderror"--}}
                {{--                                          rows="8">{{old('contents')}}</textarea>--}}
                {{--                                @error('contents')--}}
                {{--                                <div class="alert alert-danger">{{$message}}</div>--}}
                {{--                                @enderror--}}
                {{--                            </div>--}}

                {{--                            <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </form>--}}

                <div>

                    @include('administrator.components.upload_multiple_images', ['post_api' => route('ajax,administrator.upload_multiple_images.store'), 'delete_api' => 'https://api.imgbb.com/1/upload'])

                </div>
            </div>

        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>

@endsection

@section('js')


@endsection

