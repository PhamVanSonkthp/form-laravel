@extends('administrator.layouts.master')

@include('administrator.slider.header')

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

                <form action="{{route('administrator.users.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group mt-3">
                                    <label>Tên khách hàng<span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{old('name')}}" required>
                                    @error('name')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mt-3">
                                    <label>Số điện thoại<span class="text-danger">*</span></label>
                                    <input type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{old('phone')}}" required>
                                    @error('phone')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-3">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{old('email')}}" required>
                                    @error('email')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-3">
                                    <label>Mật khẩu<span class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           value="{{old('password')}}" required>
                                    @error('password')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            @include('administrator.components.upload_image', ['post_api' => route('ajax,administrator.upload_image.store'), 'relate_id' => \App\Models\Helper::getNextIdTable('users') , 'table' => 'users'])
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

