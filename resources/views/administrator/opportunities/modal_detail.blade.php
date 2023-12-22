<div class="card">
    <div class="job-search">
        <div class="card-body">
            <div class="media"><img class="img-40 img-fluid m-r-20" src="{{optional($item->user)->avatar()}}">
                <div class="media-body">
                    <h6 class="f-w-600">{{optional($item->user)->name}}</h6>
                    <p>{{optional($item->user)->phone}} - {{optional($item->category)->name}}</p>
                    <ul class="rating">
                        <li><i class="fa fa-star font-warning"></i></li>
                        <li><i class="fa fa-star font-warning"></i></li>
                        <li><i class="fa fa-star font-warning"></i></li>
                        <li><i class="fa fa-star font-warning"></i></li>
                        <li><i class="fa fa-star font-warning">                                  </i></li>
                    </ul>
                </div>
            </div>
            <div class="job-description">
                <h6>Tên cơ hội</h6>
                <p class="text-start">{{$item->name}}</p>
                <!-- <p>Front-end web designers combine design, programming, writing and organizational skills in their work. They help shape the vision for a company's online content.</p>-->
            </div>
            <div class="job-description">
                <h6>Nội dung </h6>
                <div>
                    {{$item->content}}
                </div>
            </div>


            <div class="job-description">
                <h6>Trạng thái</h6>
                <div>
                    {{ optional($item->status)->name}}
                </div>
            </div>

            <div class="job-description">
                <h6>Giá trị hợp đồng</h6>
                <div>
                    <strong>
                        {{ \App\Models\Formatter::formatNumber($item->cost)}} VNĐ
                    </strong>
                </div>
            </div>

            <div class="job-description">
                <h6>Thông tin liên hệ</h6>
                <ul>
                    <li>Họ tên: <strong>{{$item->client_name}}</strong></li>
                    <li>Số điện thoại: <strong>{{$item->client_phone}}</strong></li>
                </ul>
            </div>

            <div class="job-description">
                <h6>Người nhận cơ hội</h6>

                @if(!empty($item->takenUser))
                    <ul>
                        <li>Họ tên: <strong>{{ optional($item->takenUser)->name}}</strong></li>
                        <li>Số điện thoại: <strong>{{optional($item->takenUser)->phone}}</strong></li>
                    </ul>
                @else
                    <strong>Chưa có người nhận</strong>
                @endif

            </div>

            <div class="job-description">
                <h6>Hình ảnh dự án</h6>

                <div class="row my-gallery gallery" id="aniimated-thumbnials" itemscope="" data-pswp-uid="1">
                    @foreach($item->images as $image)
                        <figure class="col-md-3 col-6 img-hover hover-1" itemprop="associatedMedia" itemscope=""><a target="_blank" href="{{$image->image_path}}" itemprop="contentUrl" data-size="1600x950">
                                <div><img src="{{$image->image_path}}" itemprop="thumbnail" alt="Image description"></div></a>
                            <figcaption itemprop="caption description">Image caption  1</figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
{{--            <div class="job-description">--}}
{{--                <h6>Perks</h6>--}}
{{--                <ul>--}}
{{--                    <li>Competitive pay</li>--}}
{{--                    <li>Competitive medical, dental, and vision insurance plans</li>--}}
{{--                    <li>Company-provided 401(k) plan</li>--}}
{{--                    <li>Paid vacation and sick time</li>--}}
{{--                    <li>Free snacks and beverages</li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <div class="job-description">--}}
{{--                <button class="btn btn-primary" type="button"><span><i class="fa fa-check"></i></span> Save this job</button>--}}
{{--                <button class="btn btn-primary" type="button"><span><i class="fa fa-share-alt"></i></span> Share</button>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
