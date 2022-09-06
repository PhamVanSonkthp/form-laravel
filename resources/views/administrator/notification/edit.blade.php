@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
@endsection

@section('name')
    <h4 class="page-title">Email</h4>
@endsection
@section('css')
    <link href="{{asset('vendor/select2/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{asset('admins/products/add/add.css') }}" rel="stylesheet"/>
@endsection

@include('administrator.notification.active_slidebar')

@section('content')

    <form action="{{route('administrator.notification.update') }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="col-md-6">


            <div class="form-group mt-3">
                <label>Nhập nội dung email</label>
                <textarea type="text" name="thankyou" class="form-control @error('thankyou') is-invalid @enderror" rows="8">{{$notificationContent->thankyou}}</textarea>
                @error('thankyou')
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
