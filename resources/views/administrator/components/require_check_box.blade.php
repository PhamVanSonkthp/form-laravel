@php
    if(isset($value)){

    }else if(isset($item)){
        $value = $item->$name;
    }else{
        $value = old($name);
    }
@endphp

<div class="form-check mt-3">

    <input type="checkbox" autocomplete="off" name="{{$name}}" class="form-check-input @error($name) is-invalid @enderror"
           value="1" {{$value ? 'checked' : ''}}>
    @error($name)
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <label>{{$label}} @include('administrator.components.lable_require') </label>
</div>
