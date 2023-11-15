@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

    <style>
        .item-product{
            cursor: pointer;
        }

        .item-product:hover{
            background-color: aliceblue;
        }
    </style>

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">

            <form action="{{route('administrator.'.$prefixView.'.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mt-3">
                                <label>Sản phẩm <span class="text-danger">*</span></label>
                                <input id="input_search_product" type="text" autocomplete="off" name="name" class="form-control " value="" oninput="onSearchProduct()"
                                       required="" data-bs-original-title="" title="" placeholder="Tên, code, id, sku, ...">
                            </div>

                            <div id="container_result_search">

                            </div>

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

                            @include('administrator.components.button_save')

                        </div>
                    </div>
                </div>
            </form>

        </div>

    </div>

@endsection

@section('js')

    <script>

        let keywordSearch = "";

        function onSearchProduct() {
            keywordSearch = $('#input_search_product').val()

            if (keywordSearch){

                callAjax(
                    "GET",
                    "{{route('ajax.administrator.products.search')}}",
                    {
                        'search_query': keywordSearch,
                    },
                    (response) => {
                        console.log(response)
                        if (keywordSearch){
                            if (keywordSearch == response.search_query){
                                $('#container_result_search').html(response.html)

                            }
                        }else{
                            $('#container_result_search').html("")
                        }
                    },
                    (error) => {

                    },
                    false,
                )

            }else{
                $('#container_result_search').html("")
            }
        }
    </script>

@endsection

