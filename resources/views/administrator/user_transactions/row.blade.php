<tr id="container_row_{{$item->id}}" class="border mb-4">


    <td>
        <h4>
            {{$item->id}}
        </h4>
    </td>
    <td>
        <h4>
            {{ optional($item->user)->id}}
        </h4>
    </td>


    <td>
        <h4 style="color: {{$item->amount >= 0 ? "#008943;" : "#f54848;"}}">
            {{\App\Models\Formatter::formatMoney( $item->amount)}}
        </h4>
    </td>

    <td>
        <div>
            {{ $item->description}}
        </div>
    </td>

    <td>
        <div>
            #{{ optional($item->user)->id}} - {{ optional($item->user)->name}} - {{ optional($item->user)->phone}}
        </div>
    </td>

    <td>
        <div>
            {{\App\Models\Formatter::formatMoney( $item->amount_now)}}
        </div>
    </td>

    <td>
        <div>
            {{\App\Models\Formatter::getDateTime( $item->created_at)}}
        </div>
    </td>
</tr>
