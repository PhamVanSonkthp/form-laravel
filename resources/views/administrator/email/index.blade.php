@extends('administrator.layouts.master')

@include('administrator.employees.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Danh sách email chờ gửi
                    </div>
                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>Mã KH</th>
                                    <th>Avatar</th>
                                    <th>Tên KH</th>
                                    <th>Email</th>
                                    <th>Tiêu đề</th>
                                    <th>Nội dung</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($items as $item)
                                    <tr>
                                        <td>{{optional($item->user)->id}}</td>
                                        <td>
                                            <img class="rounded-circle" src="{{ optional($item->user)->avatar()}}"
                                                 alt="">
                                        </td>
                                        <td>{{optional($item->user)->name}}</td>
                                        <td>{{optional($item->user)->email}}</td>
                                        <td>{{\App\Models\Formatter::getShortDescriptionAttribute($item->title,10)}}</td>
                                        <td>{{\App\Models\Formatter::getShortDescriptionAttribute($item->content)}}</td>
                                        <td>

                                            <a href="{{route('administrator.email.delete' , ['id'=> $item->id])}}"
                                               data-url="{{route('administrator.email.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-danger btn-sm action_delete">
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $items->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-12">

                <form action="{{route('administrator.email.store')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="col-form-label">Đến:</label>
                        <select name="user_ids[]" class="form-control select2_init" multiple>
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
@endsection

@section('js')

@endsection
