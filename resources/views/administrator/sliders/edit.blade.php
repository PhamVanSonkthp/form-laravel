@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">

            <form action="{{route('administrator.'.$prefixView.'.update', ['id'=> $item->id]) }}" method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{$item->link}}" required>
                        @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
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

                    <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>

                </div>
            </form>

        </div>
    </div>
@endsection

@section('js')

@endsection
