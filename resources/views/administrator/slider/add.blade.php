@extends('administrator.layouts.master')

@include('administrator.role.header')

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

                <form action="{{route('administrator.slider.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" class="form-control @error('link') is-invalid @enderror"
                                   value="{{old('link')}}" required>
                            @error('link')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label>Ảnh đại diện</label>
                            <input type="file" name="feature_image_path" class="form-control-file" accept="image/*"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>
@endsection

@section('js')

@endsection
