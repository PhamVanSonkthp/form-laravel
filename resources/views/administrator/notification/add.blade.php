@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
@endsection

@section('name')
    <h4 class="page-title">Rương quà</h4>
@endsection
@section('css')
    <link href="{{asset('vendor/select2/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{asset('admins/products/add/add.css') }}" rel="stylesheet"/>
@endsection

@include('administrator.notification.active_slidebar')

@section('content')

    <form action="{{route('administrator.gifts.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">

            <div class="form-group">
                <label>Nhập tên rương quà</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên" value="{{old('name')}}">
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label>Nhập nội dung rương quà</label>
                <input type="text" name="contents_parent" class="form-control @error('contents_parent') is-invalid @enderror" placeholder="Nhập nội dung" value="{{old('contents')}}">
                @error('contents_parent')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="container_sources mt-3">
                <div class="row">
                    <div class="col-md-6 mt-1">
                        <div class="form-group">
                            <label>Tên món quà</label>
                        </div>
                    </div>

                    <div class="col-md-6 mt-1">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Xác xuất (%)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-1">
                        <div class="form-group">
                            <input name="contents[]" type="text"
                                   class="name form-control @error('contents') is-invalid @enderror"
                                   placeholder="Tên món quà">
                            @error('contents')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-5 mt-1">
                        <div class="form-group">
                            <input name="probabilities[]" type="text"
                                   class="link form-control @error('probabilities') is-invalid @enderror"
                                   placeholder="Xác xuất %">
                            @error('probabilities')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-1 mt-1">
                        <button type="button"
                                class="btn btn-danger waves-effect waves-light action_delete_source">
                            x
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <button type="button"
                        class="btn btn-success waves-effect waves-light action_add_source mt-1">
                    (+)
                </button>
            </div>

            <div class="form-group mt-3">
                <label>Chọn cấp độ để đạt được rương quà</label>
                <select name="level_id" class="form-control select2_init @error('level_id') is-invalid @enderror">
                    <option value=""></option>
                    @foreach($levels as $levelItem)
                        <option value="{{$levelItem->id}}">{{$levelItem->level}}</option>
                    @endforeach
                </select>
                @error('level_id')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </div>
    </form>

@endsection


@section('js')
    <script src="{{asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{asset('admins/products/add/add.js') }}"></script>

    <script>

        function actionAddSource(event) {
            event.preventDefault()
            $('.container_sources').append(`<div class="row">
                    <div class="col-md-6 mt-1">
                        <div class="form-group">
                            <input name="contents[]" type="text"
                                   class="name form-control @error('contents') is-invalid @enderror"
                                   placeholder="Tên món quà">
                            @error('contents')
            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
            </div>
        </div>

        <div class="col-md-5 mt-1">
            <div class="form-group">
                <input name="probabilities[]" type="text"
                       class="link form-control @error('probabilities') is-invalid @enderror"
                                   placeholder="Xác xuất %">
                            @error('probabilities')
            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
            </div>
        </div>

        <div class="col-md-1 mt-1">
            <button type="button"
                    class="btn btn-danger waves-effect waves-light action_delete_source">
                x
            </button>
        </div>
    </div>`)
        }

        function actionDeleteSource(event) {
            event.preventDefault()
            $(this).parent().parent().remove()
        }

        $(function () {
            $(document).on('click', '.action_add_source', actionAddSource);
            $(document).on('click', '.action_delete_source', actionDeleteSource);
        })
    </script>
@endsection
