@php
    if(isset($item)){
        $value = $item->$name;
    }else{
        $value = old($name);
    }
@endphp

<div class="form-group mt-3">
    <label>{{$label}}</label>
    <textarea style="min-height: 250px;" name="{{$name}}"
              class="form-control @error($name) is-invalid @enderror"
              rows="5">{{$value}}</textarea>
    @error($name)
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>
