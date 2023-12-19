<tr id="container_row_{{$item->id}}">
    <td class="text-center">
        <input type="checkbox" class="checkbox-delete-item" value="{{$item->id}}">
    </td>
    <td>{{$item->id}}</td>
    <td>{{\App\Models\Formatter::getShortDescriptionAttribute($item->name)}}</td>
    <td>{{$item->client_name ?? $item->name}}</td>
    <td>{{$item->client_phone}}</td>
    <td>{{ optional($item->status)->name}}</td>
    <td>{{ optional($item->category)->name}}</td>
    <td>{{optional($item->user)->name}}</td>
    <td>{{\App\Models\Formatter::formatMoney($item->cost)}}</td>
    <td>{{\App\Models\Formatter::getDateTime($item->created_at)}}</td>
    <td>

        <a href="{{route('administrator.'.$prefixView.'.edit' , ['id'=> $item->id ])}}" title="Sửa"
           class="btn btn-outline-secondary btn-sm edit" title="Edit">
            <i class="fa-solid fa-pen"></i>
        </a>

        <a href="{{route('administrator.'.$prefixView.'.detail' , ['id'=> $item->id])}}" title="Chi tiết"
           data-url="{{route('administrator.'.$prefixView.'.detail' , ['id'=> $item->id])}}"
           class="btn btn-outline-info btn-sm action_detail">
            <i class="fa-solid fa-circle-info"></i>
        </a>

        <a href="{{route('administrator.'.$prefixView.'.delete' , ['id'=> $item->id])}}" title="Xóa"
           data-url="{{route('administrator.'.$prefixView.'.delete' , ['id'=> $item->id])}}"
           class="btn btn-outline-danger btn-sm delete action_delete"
           title="Delete">
            <i class="fa-solid fa-x"></i>
        </a>

{{--        <a href="{{route('administrator.'.$prefixView.'.audit' , ['id'=> $item->id])}}" title="Lịch sử tác động"--}}
{{--           data-url="{{route('administrator.'.$prefixView.'.audit' , ['id'=> $item->id])}}"--}}
{{--           class="btn btn-outline-info btn-sm action_audit">--}}
{{--            <i class="fa-solid fa-circle-info"></i>--}}
{{--        </a>--}}
    </td>
</tr>
