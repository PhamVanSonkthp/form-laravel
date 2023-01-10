<div class="form-group mt-3">
    <label>Danh mục</label>
    <select class="form-control select2_init @error('category_id') is-invalid @enderror"
            name="category_id">
        <option value="0">-Không có danh mục-</option>
        {!! $html_category !!}
    </select>
    @error('category_id')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>
