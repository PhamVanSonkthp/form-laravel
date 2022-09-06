@extends('administrator.layouts.master')

@include('administrator.product.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.product.update', ['id'=> $item->id]) }}" method="post"
          enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="col-md-6">

            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{$item->name}}" required>
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Mã sản phẩm</label>
                <input type="text" name="code" class="form-control"
                       value="{{$item->code}}">
            </div>

            <div class="form-group mt-3">
                <label>Mã vạch</label>
                <input type="text" name="bar_code" class="form-control"
                       value="{{$item->bar_code}}">
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
                <label>Ảnh chi tiết</label>
                <input type="file" multiple name="image_path[]" class="form-control-file" accept="image/*">
                <div class="col-md-12 container_image_detail">
                    <div class="row">
                        @foreach($item->images as $productImageItem)
                            <div class="col-md-3">
                                <img class="image_detail_product" src="{{$productImageItem->image_path}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Giá nhập</label>
                <input type="price" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{$item->price}}" required>
                @error('price')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Tồn kho</label>
                <input type="number" name="inventory" class="form-control @error('inventory') is-invalid @enderror"
                       value="{{$item->inventory}}" required>
                @error('inventory')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Đơn vị tính</label>
                <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                       value="{{$item->unit}}" required>
                @error('unit')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Chọn danh mục</label>
                <select class="form-control select2_init" name="category_id">
                    <option value="0">Chọn danh mục</option>
                    {!! \App\Models\Category::getCategory($item->category_id) !!}
                </select>
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
