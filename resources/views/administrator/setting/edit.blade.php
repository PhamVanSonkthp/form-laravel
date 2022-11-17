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

                <form action="{{route('administrator.setting.update', ['id'=> $item->id]) }}" method="post"
                      enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Số ngày dùng thử</label>
                            <input type="text" name="number_trail" class="form-control @error('number_trail') is-invalid @enderror"
                                   value="{{$item->number_trail}}" required>
                            @error('number_trail')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
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
