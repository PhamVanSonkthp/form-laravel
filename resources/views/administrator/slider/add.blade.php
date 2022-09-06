@extends('administrator.layouts.master')

@include('administrator.slider.header')

@section('css')

@endsection

@section('content')

    <form action="{{route('administrator.slider.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">

            <div class="form-group">
                <label>Link</label>
                <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{old('link')}}" required>
                @error('link')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="feature_image_path" class="form-control-file" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
        </div>
    </form>

@endsection


@section('js')

@endsection
