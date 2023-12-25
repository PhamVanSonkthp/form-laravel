<div class="row">
    <div class="col-md-6">
        <div>
            <h3>
                Thông tin chung
            </h3>
            <div>
                <label class="bold">Tên: @include('administrator.components.lable_require')</label>
                <input id="input_name" required type="text" class="form-control" autocomplete="off" value="{{$item->name}}">
            </div>

            <div class="mt-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_gender" value="1" {{$item->gender_id == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="radio_gender">
                        <i class="fa-solid fa-mars" style="color: cornflowerblue;"></i>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_gender_2" value="2" {{$item->gender_id == 2 ? 'checked' : ''}}>
                    <label class="form-check-label" for="radio_gender_2">
                        <i class="fa-solid fa-venus" style="color: deeppink;"></i>
                    </label>
                </div>
            </div>

            <div class="mt-3">
                <label class="bold">Số điện
                    thoại: @include('administrator.components.lable_require')</label>
                <input id="input_phone" required type="text" class="form-control"
                       autocomplete="off" value="{{$item->phone}}">
            </div>
            <div class="mt-3">
                <label class="bold">Mật
                    khẩu: @include('administrator.components.lable_require')</label>
                <input id="input_password" required type="text" class="form-control"
                       autocomplete="off">
            </div>

            <div class="mt-3">
                <label class="bold">Email</label>
                <input id="input_email" type="text" class="form-control" autocomplete="off" value="{{$item->email}}">
            </div>

            <div class="mt-3">
                <label class="bold">Ngày sinh:</label>
                <input id="input_date_of_birth" type="date"
                       class="bg-white form-control open-jquery-date" placeholder="--/--/--" value="{{\App\Models\Formatter::getOnlyDate($item->date_of_birth)}}">
            </div>

            <div class="mt-3">
                <label class="bold">Địa chỉ:</label>
                <input id="input_address" required type="text" class="form-control"
                       autocomplete="off" value="{{$item->address}}">
            </div>

            <div class="mt-3">
                <label class="bold">Loại khách
                    hàng: @include('administrator.components.lable_require')</label>
                <select id="select_user_type_id" class="form-control select2_init" required>
                    @foreach($userTypes as $itemUserTypes)
                        <option value="{{$itemUserTypes->id}}" {{$item->user_type_id == $itemUserTypes->id ? 'selected' : ''}}>{{$itemUserTypes->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <label class="bold">Trạng thái: @include('administrator.components.lable_require')</label>
                <select id="select_user_status_id" class="form-control select2_init" required>
                    @foreach($userStatuses as $itemUserStatuses)
                        <option
                            value="{{$itemUserStatuses->id}}" {{$item->user_status_id == $itemUserStatuses->id ? 'selected' : ''}}>{{$itemUserStatuses->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <label class="bold">Số tiên:</label>
                <strong id="lable_amount">{{\App\Models\Formatter::formatMoney($item->amount)}}</strong>
            </div>

            <div class="mt-3">
                <label class="bold">Điểm:</label>
                <strong id="lable_point">{{\App\Models\Formatter::formatNumber($item->point)}}</strong>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div>
            <h3>
                Ảnh chứng minh thư
            </h3>

            <div>
                <label class="bold">Ảnh mặt trước:</label>
                <div>
                    <img style="max-height: 400px;object-fit: contain;width: 100%;" id="img_id_front" src="{{$item->front_id_image_path}}">
                </div>
            </div>

            <div class="mt-3">
                <label class="bold">Ảnh mặt sau:</label>
                <div>
                    <img style="max-height: 400px;object-fit: contain;width: 100%;" id="img_id_back" src="{{$item->back_id_image_path}}">
                </div>
            </div>

        </div>
    </div>

</div>
