
<div class="form-group mt-3">
    <label>Mô tả @include('administrator.components.lable_require')</label>
    <textarea style="min-height: 300px;" name="description"
              class="form-control tinymce_editor_init @error('description') is-invalid @enderror"
              rows="5">{{old('description')}}</textarea>
    @error('contents')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>
