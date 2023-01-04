@extends('administrator.layouts.master')

@include('administrator.userjobnotification.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">

                        @include('administrator.userjobnotification.search')

                    </div>

                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tiêu đề</th>
                                    <th>Hình ảnh</th>
                                    <th>Thời gian tạo</th>
                                    <th>Người tạo</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>
                                            <img class="rounded-circle" src="{{$item->avatar()}}" alt="">
                                        </td>
                                        <td>{{\App\Models\Formatter::getDateTime($item->created_at)}}</td>
                                        <td>{{ optional($item->createdBy)->name}}</td>
                                        <td>
                                            <a href="{{route('administrator.userjobnotification.edit' , ['id'=> $item->id ])}}"
                                               class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <a href="{{route('administrator.userjobnotification.delete' , ['id'=> $item->id])}}"
                                               data-url="{{route('administrator.userjobnotification.delete' , ['id'=> $item->id])}}"
                                               class="btn btn-outline-danger btn-sm delete action_delete"
                                               title="Delete">
                                                <i class="fa-solid fa-x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $items->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('js')

@endsection

