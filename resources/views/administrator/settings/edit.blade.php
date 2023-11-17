@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

@endsection

@section('content')

    <div class="container-fluid list-products">

        <!-- Individual column searching (text inputs) Starts-->

        <form action="{{route('administrator.'.$prefixView.'.update', ['id'=> $item->id]) }}" method="post"
              enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-xl-6">

                    <div class="card">
                        <div class="card-body">

                            <div>
                                <h2>
                                    Chung
                                </h2>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-5">
                                    @include('administrator.components.require_input_number', ['label' => 'Quy đổi điểm' , 'name' => 'point'])
                                </div>

                                <div class="col-2">
                                    <div class="text-center">
                                        =>
                                    </div>
                                </div>
                                <div class="col-5">
                                    @include('administrator.components.require_input_number', ['label' => 'Quy đổi số tiền' , 'name' => 'amount'])
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-6">
                                    @include('administrator.components.require_input_text', ['label' => 'Tên tài khoản nạp tiền' , 'name' => 'bank_name'])
                                </div>

                                <div class="col-6">
                                    @include('administrator.components.require_input_text', ['label' => 'Số tài khoản nạp tiền' , 'name' => 'bank_number'])
                                </div>

                            </div>

                            <div class="row align-items-end">
                                <div class="col-6">
                                    @include('administrator.components.require_input_text', ['label' => 'Số điện thoại liên hệ' , 'name' => 'phone_contact'])
                                </div>

                                <div class="col-6">
                                    @include('administrator.components.require_input_text', ['label' => 'Thông tin' , 'name' => 'about_contact'])
                                </div>

                                <div class="col-6">
                                    @include('administrator.components.require_input_text', ['label' => 'Địa chỉ' , 'name' => 'address_contact'])
                                </div>

                                <div class="col-6">
                                    @include('administrator.components.require_input_text', ['label' => 'Email' , 'name' => 'email_contact'])
                                </div>

                            </div>


                            @include('administrator.components.button_save')
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection

@section('js')

@endsection
