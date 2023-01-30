@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.'.$prefixView.'.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">

            @include('administrator.components.require_input_text' , ['name' => 'name' , 'label' => 'Tên'])

            @if($isSingleImage)
                <div class="mt-3 mb-3">
                    @include('administrator.components.upload_image', ['post_api' => $imagePostUrl, 'table' => $table, 'image' => $imagePathSingple , 'relate_id' => $relateImageTableId])
                </div>
            @endif

            @if($isMultipleImages)
                <div class="mt-3 mb-3">
                    @include('administrator.components.upload_multiple_images', ['post_api' => $imageMultiplePostUrl, 'delete_api' => $imageMultipleDeleteUrl , 'sort_api' => $imageMultipleSortUrl, 'table' => $table , 'images' => $imagesPath,'relate_id' => $relateImageTableId])
                </div>
            @endif

            @include('administrator.components.require_input_text' , ['name' => 'short_description' , 'label' => 'Mô tả ngắn'])

            @include('administrator.components.textarea_description')

            @include('administrator.components.select_category' , ['name' => 'category_id' ,'html_category' => \App\Models\Category::getCategory(isset($item) ? optional($item)->category_id : ''), 'can_create' => true])

            <div id="container_infor_attributes" class="p-3">
                <label>
                    Sản phẩm có biển thể
                </label>
                <button onclick="addValueAttribute1()" type="button" class="btn btn-outline-success"><i
                        class="fa-solid fa-plus"></i></button>
            </div>

            <div id="bassic_price">

                @include('administrator.components.require_input_number' , ['name' => 'price_import' , 'label' => 'Giá nhập'])

                @include('administrator.components.require_input_number' , ['name' => 'price_client' , 'label' => 'Giá bán lẻ'])

                @include('administrator.components.require_input_number' , ['name' => 'price_agent' , 'label' => 'Giá bán buôn'])

                @include('administrator.components.require_input_number' , ['name' => 'inventory' , 'label' => 'Tồn kho'])

            </div>

            @include('administrator.components.button_save')

        </div>
    </form>

@endsection


@section('js')
    <script>
        function addAttribute2() {
            $('#attribute_1').after()
        }

        function addValueAttribute1() {
            $('#container_infor_attributes').html('')

            $('#bassic_price').html(`<div class="p-3">

                <div id="attribute_1" class="card p-3">

                    <div class="text-end">
                        <button onclick="removeAllAttribute(this)" type="button" class="btn btn-danger"><i
                                class="fa-solid fa-x"></i></button>
                    </div>

                    <div class="d-flex mt-3">
                        <input type="text" autocomplete="off" class="form-control number " value=""
                               placeholder="Thuộc tính (VD: Kích thước)">
                        <button type="button" onclick="addValueAttribute1()" class="btn btn-success ms-1"
                                data-bs-original-title="" title=""><i class="fa-solid fa-plus"></i></button>
                    </div>

                    <div id="container_value_attributes" class="ms-3 mt-3 me-3">
                        <div class="d-flex mt-1">
                            <input type="text" autocomplete="off" class="form-control" required
                                   placeholder="Giá trị (VD: 50cm)">
                        </div>
                    </div>
                </div>

                <div>
                    <label>
                        Thêm thuộc tính
                    </label>
                    <button onclick="addAttribute2()" type="button" class="btn btn-outline-success"
                            data-bs-original-title="" title=""><i class="fa-solid fa-plus"></i></button>
                </div>

            </div>`)
        }

        function removeValueAttribute(e) {
            const ele = $(e)
            ele.parent().remove()
        }

        function removeAllAttribute(e) {
            const ele = $(e)
            ele.parent().parent().remove()
        }
    </script>
@endsection
