<div>
    @include('administrator.components.search')

    <a href="{{route('administrator.'.$prefixView.'.create')}}" class="btn btn-outline-success float-end"><i
            class="fa-solid fa-plus"></i></a>

    <a href="{{route('administrator.'.$prefixView.'.export')}}" class="btn btn-outline-primary float-end me-2" data-bs-original-title="" title="Export excel"><i class="fa-sharp fa-solid fa-file-excel"></i></a>

    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-3">
            <div class="mt-3">
                <label>Trạng thái</label>
                <select name="opportunity_status_id" class="form-control select2_init_allow_clear">
                    <option value="">Chọn</option>
                    @foreach(\App\Models\OpportunityStatus::all() as $opportunityStatus)
                        <option value="{{$opportunityStatus->id}}" {{request('opportunity_status_id') == $opportunityStatus->id ? 'selected' : ''}}>{{$opportunityStatus->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="mt-3">
                <label>Danh mục</label>
                <select name="opportunity_category_id" class="form-control select2_init_allow_clear">
                    <option value="">Chọn</option>
                    @foreach(\App\Models\OpportunityCategory::all() as $opportunityCategory)
                        <option value="{{$opportunityCategory->id}}" {{request('opportunity_category_id') == $opportunityCategory->id ? 'selected' : ''}}>{{$opportunityCategory->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

</div>



<script>

    // function onSearchQuery() {
    //     addUrlParameterObjects([
    //         {name: "search_query", value: $('#input_search_query').val()},
    //         {name: "from", value: input_query_from},
    //         {name: "to", value: input_query_to},
    //     ])
    // }
    $('select[name="opportunity_status_id"]').on('change', function () {
        addUrlParameter('opportunity_status_id', this.value)
    });

    $('select[name="opportunity_category_id"]').on('change', function () {
        addUrlParameter('opportunity_category_id', this.value)
    });


</script>
