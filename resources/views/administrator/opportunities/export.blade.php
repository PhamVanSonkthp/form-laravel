<table>
    <td colspan="12" rowspan="2" align="center" valign="middle" class="cell">BÁO CÁO CƠ HỘI</td>
</table>
<table>
    <td colspan="4"></td>
</table>
<table>
    <thead>
    <tr>
        <th align="" valign="">STT</th>
        <th align="" valign="">ID</th>
        <th align="" valign="">Tiêu đề</th>
        <th align="" valign="">Tên khách hàng</th>
        <th align="" valign="">Số điện thoại</th>
        <th align="" valign="">Trạng thái</th>
        <th align="" valign="">Danh mục</th>
        <th align="" valign="">Người chia sẻ</th>
        <th align="" valign="">Giá trị HĐ</th>
        <th align="" valign="">Yêu cầu khách hàng</th>
        <th align="" valign="">Người nhận cơ hội</th>
        <th align="" valign="">Thời gian tạo</th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $key => $item)
        <tr>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{ $key + 1}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{$item->id}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{$item->name}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{$item->client_name}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{$item->client_phone}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{ optional($item->status)->name}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{ optional($item->category)->name}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{optional($item->user)->name}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{\App\Models\Formatter::formatMoney($item->cost)}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{$item->content}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{ optional($item->takenUser)->name}}</td>
            <td style="background-color: {{$key % 2 == 0? "": "#d3d3d3"}}" align="" valign="">{{ $item->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

