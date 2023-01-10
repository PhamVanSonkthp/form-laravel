<div class="form-group mt-3">
    <label>{{$label}} @include('administrator.components.lable_require') </label>
    <input type="text" autocomplete="off" name="{{$name}}" class="form-control number @error($name) is-invalid @enderror"
           value="{{old($name)}}" required>
    @error($name)
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>
