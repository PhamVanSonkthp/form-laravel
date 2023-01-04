<div>
    <div class="float-start">
        <select name="limit" class="form-control select2_init">
            @foreach(config('_my_config.items_show_in_table') as $itemShowInTable)
                <option
                    value="{{$itemShowInTable}}" {{request('limit') == $itemShowInTable ? 'selected' : ''}}>{{$itemShowInTable}}</option>
            @endforeach
        </select>
    </div>

    <div class="float-start ms-3">
        <input id="input_search_datetime" type="date"
               class="bg-white form-control open-jquery-date" placeholder="datetime">
    </div>

    <div class="float-start d-flex ms-3">
        <input id="input_search_query" type="text" class="form-control" placeholder="search..."
               value="{{request('search_query')}}">
        <button class="btn btn-outline-primary" type="button" onclick="onSearchQuery()"><i
                class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    <a href="{{route('administrator.jobnotificationrepeat.create')}}" class="btn btn-success float-end m-2"><i
            class="fa-solid fa-plus"></i></a>
</div>


<script>

    function onSearchQuery() {
        addUrlParameterObjects([
            {name: "search_query", value: $('#input_search_query').val()},
            {name: "from", value: input_query_from},
            {name: "to", value: input_query_to},
        ])
    }

</script>
