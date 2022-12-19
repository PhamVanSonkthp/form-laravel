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

                <form action="{{route('administrator.news.store')}}" method="post" enctype="multipart/form-data">
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
                            <label>Ảnh đại diện</label>
                            <input type="file" name="feature_image_path" class="form-control-file" accept="image/*"
                                   required>


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

                <div>

                    <div id="gallery">

                        <div id="image-container">
                            <div>
                                <label>
                                    Thư viện ảnh
                                </label>
                            </div>
                            <div id="txtresponse" > </div>
                            <ul id="image-list" >
{{--                                <li id="image_1" >--}}
{{--                                    <div class="col-md-3" style="position: relative;"  id="btn_delete_detail_image_{{$productImageItem->id}}">--}}
{{--                                        <img class="image_detail_product" src="{{$productImageItem->image_path}}">--}}

{{--                                        <button type="button" onclick="onDeleteDetailImage('{{$productImageItem->id}}','{{route('administrator.product.detail_image.delete', ['id' => $productImageItem->id])}}')" class="btn btn-danger" style="position: absolute;top: 0;right: 0;margin: 0;padding: 5px 10px 5px 10px;">X</button>--}}
{{--                                    </div>--}}
{{--                                    <img style="object-fit: cover;width: 100px;height: 100px;" src="https://scr.vn/wp-content/uploads/2020/08/%E1%BA%A2nh-hot-girl-l%C3%A0m-avt.jpg" alt="">--}}
{{--                                    <button type="button" onclick="onDeleteDetailImage('{{$productImageItem->id}}','{{route('administrator.product.detail_image.delete', ['id' => $productImageItem->id])}}')" class="btn btn-danger" style="position: absolute;top: 0;right: 0;margin: 0;padding: 5px 10px 5px 10px;">X</button>--}}
{{--                                </li>--}}
                                <li id="image_2" ><img src="https://icdn.dantri.com.vn/thumb_w/640/2020/12/16/ngam-dan-hot-girl-xinh-dep-noi-bat-nhat-nam-2020-docx-1608126694049.jpeg" alt=""></li>
                            </ul>

                        </div>
                    </div>


                    <script>
                        $(document).ready(function () {
                            var dropIndex;
                            $("#image-list").sortable({
                                update: function(event, ui) {
                                    dropIndex = ui.item.index();

                                    var imageIdsArray = [];
                                    $('#image-list li').each(function (index) {
                                        if(index <= dropIndex) {
                                            var id = $(this).attr('id');
                                            var split_id = id.split("_");
                                            imageIdsArray.push(split_id[1]);
                                        }
                                    });

                                    console.log(imageIdsArray)

                                },
                            });
                        });

                    </script>

                </div>
            </div>

        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>


@endsection

@section('js')

@endsection

