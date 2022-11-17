@extends('administrator.layouts.master')

@include('administrator.user.header')

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
                <!-- Individual column searching (text inputs) Starts-->
                <form action="{{route('administrator.setting.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">


                        <div class="form-group">
                            <label>Link support</label>
                            <input type="text" name="url_support" class="form-control @error('url_support') is-invalid @enderror"
                                   value="{{old('url_support')}}" required>
                            @error('url_support')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
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
