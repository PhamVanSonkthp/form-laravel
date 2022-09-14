@extends('administrator.layouts.master')

@include('administrator.logo.header')

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

                <form action="{{route('administrator.logo.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">

                        <div class="form-group mt-3">
                            <label>Logo</label>
                            <input type="file" name="image_path"
                                   class="form-control-file @error('image_path') is-invalid @enderror" accept="image/*">
                            <div class="col-md-4 container_feature_image">
                                <div class="row">
                                    <img class="feature_image" src="{{$logo->image_path}}" alt="">
                                </div>
                            </div>
                            @error('image_path')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
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
