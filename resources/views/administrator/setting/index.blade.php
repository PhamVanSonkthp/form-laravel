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
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive product-table">
                                <table class="display table-users" id="basic-1" data-order='[[ 0, "desc" ]]'>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Số ngày dùng thử</th>
                                        <th class="text-center" style="width: 100px;">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->number_trail}}</td>
                                            <td>

                                                <a href="{{route('administrator.setting.edit' , ['id'=> $item->id ])}}"
                                                   class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                    Sửa
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->
        <!-- Container-fluid Ends-->
    </div>

@endsection

@section('js')

@endsection
