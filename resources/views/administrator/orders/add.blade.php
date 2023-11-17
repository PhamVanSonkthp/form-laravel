@extends('administrator.layouts.master')

@include('administrator.'.$prefixView.'.header')

@section('css')

    <style>
        .item-product {
            cursor: pointer;
            width: 100%;
        }

        .item-product:hover {
            background-color: aliceblue;
        }

    </style>

@endsection

@section('content')

    <div class="container-fluid list-products">
        <div class="row">

            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label>Sản phẩm <span class="text-danger">*</span></label>
                            <input id="input_search_product" type="text" autocomplete="off" name="name"
                                   class="form-control " value="" oninput="onSearchProduct()"
                                   required="" data-bs-original-title="" title="" placeholder="Tên, code, id, sku, ...">
                        </div>

                        <div id="container_result_search">

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header" style="display: flex;justify-content: space-between;">

                        <div class="mt-3">
                            Danh sách sản phẩm
                        </div>

                        <div>
                            @include('administrator.components.select2_allow_clear', ['label' => 'Khách hàng', 'name' => 'user_id' , 'select2Items' => \App\Models\User::where('is_admin', 0)->latest()->get()])
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive product-table">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Thuộc tính</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="container_products">

                                </tbody>

                                <tbody>
                                <tr>
                                    <td colspan="4">
                                        <strong class="text-danger">
                                            Tổng
                                        </strong>
                                    </td>
                                    <td class="text-end">
                                        <strong id="total_number">
                                            0
                                        </strong>
                                    </td>
                                    <td class="text-end" colspan="2">
                                        <strong class="text-danger" id="total_price">
                                            0
                                        </strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer">

                        <div class="form-group mt-3">
                            <label>Mã giảm giá (Nếu có)</label>
                            <input id="" type="text" autocomplete="off"
                                   class="form-control " value="" placeholder="Mã giảm giá">
                        </div>

                        <button class="btn btn-primary mt-3" onclick="onCreateOrder()">Tạo đơn</button>

                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>

        let keywordSearch = "";

        function onSearchProduct() {
            keywordSearch = $('#input_search_product').val()

            if (keywordSearch.length) {

                callAjax(
                    "GET",
                    "{{route('ajax.administrator.products.search')}}",
                    {
                        'search_query': keywordSearch,
                    },
                    (response) => {
                        if (keywordSearch) {
                            if (keywordSearch == response.search_query) {
                                $('#container_result_search').html(response.html)

                            }
                        } else {
                            $('#container_result_search').html("")
                        }
                    },
                    (error) => {

                    },
                    false,
                )

            } else {
                $('#container_result_search').html("")
            }
        }

        function renderSTT() {
            $('.index_product').each(function(i, obj) {
                $(obj).html(i + 1)
            });


        }

        function renderTotalPrice() {

            let totalNumberProduct = 0;
            let totalPriceProduct = 0;

            var ek=[];
            $('.prices').each(function() { ek.push($(this).html()); });


            $('.input_products').each(function(i, obj) {
                totalNumberProduct += tryParseInt($(obj).val())
                totalPriceProduct += tryParseInt(ek[i])
            });

            console.log('-----')
            $('#total_number').html(totalNumberProduct)
            $('#total_price').html(formatMoney(totalPriceProduct) + "đ")
        }

        function onAddProduct(id, name, variation , price) {


            if ($('#row_product_id_' + id).html()){
                $('#input_number_product_' + id).val(tryParseInt($('#input_number_product_' + id).val()) + 1)

                onChangeNumberProduct(id)
            }else{
                $('#container_products').append(`<tr id="row_product_id_${id}">

                                    <td class="index_product">
                                        1
                                        <input class="product_ids" value="${id}"/>
                                    </td>

                                    <td>
                                        ${name}
                                    </td>
                                    <td>
                                        ${variation}
                                    </td>

                                    <td id="price_product_${id}">
                                        ${formatMoney(price)}
                                    </td>

                                    <td>
                                        <input id="input_number_product_${id}" type="text" class="form-control input_products" value="1" oninput="onChangeNumberProduct('${id}')">
                                    </td>

                                    <td>
                                        <strong id="total_row_product_${id}" class="prices">${formatMoney(price)}</strong>

                                    </td>
                                    <td>

                                        <a
                                           class="btn btn-outline-danger btn-sm" onclick="onDeleteProduct('row_product_id_${id}')">
                                            <i class="fa-solid fa-x"></i>
                                        </a>

                                    </td>
                                </tr>`)
            }



            renderSTT()
            renderTotalPrice()
        }

        function onDeleteProduct(id) {
            $('#' + id).remove()
            renderSTT()
            renderTotalPrice()
        }

        function onChangeNumberProduct(id) {
            const number = tryParseInt(getOnlyNumber($('#input_number_product_' + id).val()))

            $('#total_row_product_' + id).html(formatMoney(number * tryParseInt($('#price_product_' + id).html())))
            renderTotalPrice()
        }

        function onCreateOrder() {

            const product_ids = [];
            $('.product_ids').each(function() { ek.push($(this).val()); });

            if (product_ids.length == 0){

                
                showToastError("Vui lòng chọn sản phẩm")

                return;
            }


        }
    </script>

@endsection

