

@foreach($results as $result)

    <div class="d-flex m-3">

        <img src="{{$result->avatar()}}" class="rounded-circle">

        <div>
            <div>
                <p class="ms-2">
                    {{\App\Models\Formatter::getShortDescriptionAttribute($result->name)}}
                </p>
            </div>

            @if($result->isProductVariation())
                @foreach($result->attributes() as $key => $itemAttribute)
                    <div class="ms-4 item-product">
                        <div>
                            <span>
                                <strong>{{\App\Models\Formatter::formatMoney(optional(\App\Models\Product::find($itemAttribute['id']))->price_client)}}</strong>
                            </span>
                            <span>
                                Phân loại: {{$itemAttribute['size']}}, {{$itemAttribute['color']}}
                            </span>

                        </div>
                        <div>
                            Kho: {{\App\Models\Formatter::formatNumber($itemAttribute['inventory'])}}
                        </div>
                    </div>

                @endforeach

            @else

                <div>
                    <p class="ms-2">
                        Tồn kho: {{\App\Models\Formatter::formatNumber($result->inventory)}}
                    </p>
                </div>

            @endif
        </div>

    </div>
@endforeach
