

<div class="row">
    <div class="col-md-12">
        <div>
            <h3>
                Thông tin chung
            </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="mt-3">
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

                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Số điện
                            thoại (Tên đăng nhập trên app): @include('administrator.components.lable_require')</label>
                        <input id="input_phone" required type="text" class="form-control"
                               autocomplete="off" value="{{$item->phone}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Chức vụ: @include('administrator.components.lable_require')</label>
                        <input id="input_business_position" required type="text" class="form-control"
                               autocomplete="off" value="{{$item->business_position}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Tên công ty: @include('administrator.components.lable_require')</label>
                        <input id="input_business_name" required type="text" class="form-control"
                               autocomplete="off" value="{{$item->business_name}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Ngành nghề: @include('administrator.components.lable_require')</label>
                        <select id="select_opportuny_category_id" class="form-control select2_init_allow_clear" required>
                            <option>Chọn</option>
                            @foreach(\App\Models\OpportunityCategory::latest()->get() as $opportunityCategory)
                                <option
                                    value="{{$opportunityCategory->id}}" {{$item->opportuny_category_id == $opportunityCategory->id ? 'selected' : ''}}>{{$opportunityCategory->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Danh mục ngành</label>
                        <input id="input_business_field_of_activity" type="text" class="form-control" autocomplete="off" value="{{$item->business_field_of_activity}}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <label>Sơ lược về công ty</label>
                        <textarea id="input_business_about" style="min-height: 100px;" name="business_about"
                                  class="form-control"
                                  rows="5">{{$item->business_about}}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Mật
                            khẩu: @include('administrator.components.lable_require')</label>
                        <input id="input_password" required type="text" class="form-control"
                               autocomplete="off">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Email</label>
                        <input id="input_email" type="text" class="form-control" autocomplete="off" value="{{$item->email}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Ngày sinh:</label>
                        <input id="input_date_of_birth" type="date"
                               class="bg-white form-control open-jquery-date" placeholder="--/--/--" value="{{\App\Models\Formatter::getOnlyDate($item->date_of_birth)}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Địa chỉ:</label>
                        <input id="input_address" required type="text" class="form-control"
                               autocomplete="off" value="{{$item->address}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Địa chỉ công ty:</label>
                        <input id="input_business_address" required type="text" class="form-control"
                               autocomplete="off" value="{{$item->business_address}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="bold">Trạng thái: @include('administrator.components.lable_require')</label>
                        <select id="select_user_status_id" class="form-control select2_init" required>
                            @foreach($userStatuses as $itemUserStatuses)
                                <option
                                    value="{{$itemUserStatuses->id}}" {{$item->user_status_id == $itemUserStatuses->id ? 'selected' : ''}}>{{$itemUserStatuses->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>


        </div>
    </div>

{{--    <div class="col-md-6">--}}
{{--        <div>--}}
{{--            <h3>--}}
{{--                Ảnh chứng minh thư--}}
{{--            </h3>--}}

{{--            <div>--}}
{{--                <label class="bold">Ảnh mặt trước:</label>--}}
{{--                <div>--}}
{{--                    <img style="max-height: 400px;object-fit: contain;width: 100%;" id="img_id_front" src="{{$item->front_id_image_path}}">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="mt-3">--}}
{{--                <label class="bold">Ảnh mặt sau:</label>--}}
{{--                <div>--}}
{{--                    <img style="max-height: 400px;object-fit: contain;width: 100%;" id="img_id_back" src="{{$item->back_id_image_path}}">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

</div>

<script>
    $(".select2_init").select2({
        placeholder: "Chọn",
        dropdownParent: $("#editUserModal")
    });

    $(".select2_init_allow_clear").select2({
        placeholder: "Chọn",
        allowClear: true,
        dropdownParent: $("#editUserModal")
    });
</script>
