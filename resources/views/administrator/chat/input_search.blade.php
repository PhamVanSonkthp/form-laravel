<div>
    <div class="text-center">
        <p>Kết quả đang hiển thị:</p>
        <p>{{count($items)}}</p>

        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="searchButton()">Tìm kiếm</button>
    </div>

    <div class="border-search mt-3">
        <p>Khoảng thời gian trả kết</p>
        <div>
            <label>Từ ngày</label>
            <span>
                    <input name="start" type="date" class="form-control" value="{{request('start')}}">
                </span>

            <label>Đến ngày</label>
            <span>
                    <input name="end" type="date" class="form-control" value="{{request('end')}}">
                </span>

        </div>
    </div>

    <div class="border-search mt-3">
        <p>Tìm theo hồ sơ</p>

        <div class="form-check">
            <input name="date_created" class="form-check-input" type="checkbox" value="" id="flexCheckChecked" {{request('date_created') == 'true' ? 'checked' : ''}}>
            <label class="form-check-label" for="flexCheckChecked">
                Date được tạo
            </label>
        </div>

        <div class="form-check">
            <input name="date_accept" class="form-check-input" type="checkbox" value="" id="flexCheckChecked1" {{request('date_accept') == 'true' ? 'checked' : ''}}>
            <label class="form-check-label" for="flexCheckChecked1">
                Date được đồng ý
            </label>
        </div>

        <div class="form-check">
            <input name="date_active" class="form-check-input" type="checkbox" value="" id="flexCheckChecked2" {{request('date_active') == 'true' ? 'checked' : ''}}>
            <label class="form-check-label" for="flexCheckChecked2">
                Date được thực hiện
            </label>
        </div>

    </div>
</div>


<script>
    function searchButton(searchParams) {
        if(!searchParams){
            searchParams = new URLSearchParams(window.location.search)
        }
        searchParams.set('start', $('input[name="start"]').val())
        searchParams.set('end', $('input[name="end"]').val())
        searchParams.set('date_created', $('input[name="date_created"]').is(":checked"))
        searchParams.set('date_accept', $('input[name="date_accept"]').is(":checked"))
        searchParams.set('date_active', $('input[name="date_active"]').is(":checked"))
        window.location.search = searchParams.toString()
    }
</script>
