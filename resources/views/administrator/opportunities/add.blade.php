@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')


@endsection

@section('content')

    <div class="container-fluid list-products"><div class="row">
            <form action="{{route('administrator.'.$prefixView.'.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="card-body">

                            <input name="user_id" value="{{auth()->id()}}" style="display: none;">

                            @include('administrator.components.require_input_text' , ['name' => 'client_name' , 'label' => 'Tên khách hàng'])

                            @include('administrator.components.require_input_text' , ['name' => 'client_phone' , 'label' => 'Số điện thoại'])

                            @include('administrator.components.textarea' , ['name' => 'client_note' , 'label' => 'Lưu ý'])

                            @include('administrator.components.select2' , ['name' => 'opportunity_status_id' , 'label' => 'Trạng thái','select2Items' => \App\Models\OpportunityStatus::all()])

                            @include('administrator.components.select2' , ['name' => 'opportunity_category_id' , 'label' => 'Ngành nghề','select2Items' => \App\Models\OpportunityCategory::where('parent_id','!=',0)->latest()->get()])

                            @include('administrator.components.require_input_number' , ['name' => 'cost' , 'label' => 'Giá trị HĐ'])

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

{{--                            @include('administrator.components.textarea_description', ['name' => 'description' , 'label' => 'Mô tả'])--}}

                            @include('administrator.components.button_save')
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@section('js')


@endsection

