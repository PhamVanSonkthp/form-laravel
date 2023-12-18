<div>
    @include('administrator.components.search')

    <a href="{{route('administrator.'.$prefixView.'.create')}}" class="btn btn-outline-success float-end"><i
            class="fa-solid fa-plus"></i></a>

    <a href="{{route('administrator.'.$prefixView.'.export')}}" class="btn btn-outline-primary float-end me-2" data-bs-original-title="" title="Excel"><i class="fa-sharp fa-solid fa-file-excel"></i></a>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-3">
            <div class="mt-3">
                <label>Ngành nghề</label>
                <select name="opportuny_category_id" class="form-control select2_init_allow_clear">
                    <option>Chọn</option>
                    @foreach(\App\Models\OpportunityCategory::latest()->get() as $opportunityCategory)
                        <option value="{{$opportunityCategory->id}}" {{request('opportuny_category_id') == $opportunityCategory->id ? 'selected' : ''}}>{{$opportunityCategory->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>


<script>

    $('select[name="opportuny_category_id"]').on('change', function () {
        addUrlParameter('opportuny_category_id', this.value)
    });

</script>
