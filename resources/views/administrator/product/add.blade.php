@extends('administrator.layouts.master')

@include('administrator.product.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.product.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">

            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" autocomplete="off" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{old('name')}}" required>
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Mã sản phẩm</label>
                <input type="text" autocomplete="off" name="code" class="form-control"
                       value="{{old('code')}}" placeholder="Không điền sẽ tự sinh">
            </div>

            <div class="form-group mt-3">
                <label>Mã vạch</label>
                <input type="text" autocomplete="off" name="bar_code" class="form-control"
                       value="{{old('bar_code')}}">
            </div>

            <div class="form-group mt-3">
                <label>Chọn danh mục</label>
                <select class="form-control select2_init @error('category_id') is-invalid @enderror"
                        name="category_id">
                    <option value="0">Chọn danh mục</option>
                    {!! \App\Models\Category::getCategory() !!}
                </select>
                @error('category_id')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="feature_image_path" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group mt-3">
                <label>Ảnh chi tiết</label>
                <input type="file" multiple name="image_path[]" class="form-control-file" accept="image/*">
            </div>

            <div class="form-group mt-3">
                <label>Giá nhập</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{old('price')}}" required>
                @error('price')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Tồn kho</label>
                <input type="number" name="inventory" class="form-control @error('inventory') is-invalid @enderror"
                       value="{{old('inventory')}}" required>
                @error('inventory')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Đơn vị tính</label>
                <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                       value="{{old('unit')}}" required>
                @error('unit')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Nhập nội dung</label>
                <textarea style="min-height: 400px;" name="contents"
                          class="form-control tinymce_editor_init @error('contents') is-invalid @enderror"
                          rows="8">{{old('contents')}}</textarea>
                @error('contents')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Thêm sản phẩm</button>
        </div>
    </form>

@endsection


@section('js')

@endsection
