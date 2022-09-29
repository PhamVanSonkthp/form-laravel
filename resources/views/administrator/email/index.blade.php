@extends('administrator.layouts.master')

@include('administrator.employees.header')

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
                <div class="col-12">

                    <form action="{{route('administrator.email.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="col-form-label">Đến:</label>
                            <select class="form-control select2_init" multiple>
                                <option value=""></option>
                                @foreach(\App\Models\User::all() as $item)
                                    <option value="{{$item->id}}">{{$item->name}} - {{$item->email}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message-subject" class="col-form-label">Tiêu đề:</label>
                            <input name="subject" type="text" class="form-control" id="message-subject" required>
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Nội dung:</label>
                            <textarea name="contents" style="height: 300px;"
                                      class="form-control tinymce_editor_init @error('contents') is-invalid @enderror"
                                      id="message-text" rows="8"></textarea>
                            @error('contents')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>

                    </form>

                </div>
            </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>
@endsection

@section('js')

@endsection
