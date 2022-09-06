@extends('administrator.layouts.master')

@include('administrator.product.header')

@section('css')
    <style>
        ul::-webkit-scrollbar {
               display: none;
           }
    </style>
@endsection

@section('content')
    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <div class="d-flex align-items-center">
                    <span>
                        Hiển thị
                    </span>
                    <span class="ms-2 me-2">
                        <select name="limit" class="form-control select2_init" style="width: 100px;">
                            <option value="10" {{request('limit') == 10 ? 'selected' : ''}}>10</option>
                            <option value="50" {{request('limit') == 50 ? 'selected' : ''}}>50</option>
                            <option value="100" {{request('limit') == 100 ? 'selected' : ''}}>100</option>
                            <option value="500" {{request('limit') == 500 ? 'selected' : ''}}>500</option>
                            <option value="1000" {{request('limit') == 1000 ? 'selected' : ''}}>1000</option>
                        </select>
                    </span>
                    <span>
                        Dòng
                    </span>

                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-6" style="display: flex;align-items: center">
                        <div class="search_style" style="display: flex;align-items: center">
                            <input type="search" class="form-control" id="input_search"
                                   placeholder="Tìm kiếm"
                                   onkeydown="search(this)" data-suffix="">
                            <button class="btn btn-info" onclick="searchButton()">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary m-2" onclick="exportExcel()">
                                Xuất Excel
                            </button>
                            <a href="{{route('administrator.product.create')}}" class="btn btn-success m-2">Thêm mới</a>
                        </div>

                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Chọn</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn vị tính</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục</th>
                            @can('type_sale-list')
                                <th>Giá nhập</th>
                            @endcan
                            <th>Giá các loại</th>
                            <th>Tồn kho</th>
                            <th>Đã bán</th>
                            <th class="text-center" style="width: 100px;">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <input name="excel_ids[]" class="form-check-input excel_ids" value="{{$item->id}}"
                                           type="checkbox" style="width: 25px;height: 25px;">
                                </td>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->unit}}</td>
                                <td>
                                    <img style="width: 60px;height: 60px;object-fit: cover;" src="{{$item->feature_image_path}}">
                                </td>
                                <td>{{ optional($item->category)->name}}</td>
                                @can('type_sale-list')
                                    <td>{{number_format($item->price)}}</td>
                                @endcan
                                <td>
                                    <ul style="max-height: 50px;overflow-y: scroll;">
                                        @foreach($item->typeSales() as $typeSalesItem)
                                            @if($typeSalesItem['name'] != "Bán lẻ")
                                                @can('type_sale-list')
                                                    <li>
                                                        {{$typeSalesItem['name']}}
                                                        - {{number_format($typeSalesItem['price'])}}
                                                    </li>
                                                @endcan
                                            @else
                                                <li>
                                                    {{$typeSalesItem['name']}}
                                                    - {{number_format($typeSalesItem['price'])}}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{number_format($item->inventory)}}</td>
                                <td>{{number_format($item->sold())}}</td>
                                <td>

                                    <a href="{{route('administrator.product.edit' , ['id'=> $item->id ])}}"
                                       class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="{{route('administrator.product.delete' , ['id'=> $item->id])}}"
                                       data-url="{{route('administrator.product.delete' , ['id'=> $item->id])}}"
                                       class="btn btn-danger btn-sm delete action_delete" title="Delete">
                                        <i class="mdi mdi-close"></i>
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

    <div class="col-md-12">
        {{ $items->links('pagination::bootstrap-4') }}
    </div>

@endsection

@section('js')
    <script>
        function search() {
            if (event.key === 'Enter') {
                searchButton()
            }
        }

        function searchButton(searchParams) {
            if (!searchParams) {
                searchParams = new URLSearchParams(window.location.search)
            }
            searchParams.set('search_query', $('#input_search').val())
            window.location.search = searchParams.toString()
        }

        const url = new URL(decodeURIComponent(window.location.href));
        $('#input_search').val(url.searchParams.get("search_query"))

        function exportExcel(searchParams) {

            if (!searchParams) {
                searchParams = new URLSearchParams(window.location.search)
            }

            let excel_ids = '';
            $('.excel_ids:checkbox:checked').each(function () {
                excel_ids += $(this).val() + "_"
            });

            searchParams.set('excel_ids', excel_ids)

            //console.log("{{route('administrator.product.export')}}" + searchParams.toString())

            window.location.href = "{{route('administrator.product.export')}}" + "?" + searchParams.toString()
        }

    </script>
@endsection
