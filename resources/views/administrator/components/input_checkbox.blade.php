@php
    if(isset($item)){
        $value = $item->$name;
    }else{
        $value = old($name);
    }
@endphp

<div class="form-group mt-3">
    <label>
        <input name="{{$name}}" class="checkbox_wrapper" type="checkbox" {{$value ? 'checked' : ""}}>
        {{$label}}
    </label>
</div>
