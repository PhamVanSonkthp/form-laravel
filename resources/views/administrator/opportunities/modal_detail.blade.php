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
                <h6>Hình ảnh</h6>

                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Hover Effect <span>1</span></h5>
                    </div>
                    <div class="card-body">
                        <div class="row my-gallery gallery" id="aniimated-thumbnials" itemscope="" data-pswp-uid="1">
                            <figure class="col-md-3 col-6 img-hover hover-1" itemprop="associatedMedia" itemscope=""><a href="../assets/images/big-lightgallry/08.jpg" itemprop="contentUrl" data-size="1600x950">
                                    <div><img src="../assets/images/lightgallry/08.jpg" itemprop="thumbnail" alt="Image description"></div></a>
                                <figcaption itemprop="caption description">Image caption  1</figcaption>
                            </figure>
                            <figure class="col-md-3 col-6 img-hover hover-1" itemprop="associatedMedia" itemscope=""><a href="../assets/images/big-lightgallry/09.jpg" itemprop="contentUrl" data-size="1600x950">
                                    <div><img src="../assets/images/lightgallry/09.jpg" itemprop="thumbnail" alt="Image description"></div></a>
                                <figcaption itemprop="caption description">Image caption  2</figcaption>
                            </figure>
                            <figure class="col-md-3 col-6 img-hover hover-1" itemprop="associatedMedia" itemscope=""><a href="../assets/images/big-lightgallry/010.jpg" itemprop="contentUrl" data-size="1600x950">
                                    <div><img src="../assets/images/lightgallry/010.jpg" itemprop="thumbnail" alt="Image description"></div></a>
                                <figcaption itemprop="caption description">Image caption  3</figcaption>
                            </figure>
                            <figure class="col-md-3 col-6 img-hover hover-1" itemprop="associatedMedia" itemscope=""><a href="../assets/images/big-lightgallry/011.jpg" itemprop="contentUrl" data-size="1600x950">
                                    <div><img src="../assets/images/lightgallry/011.jpg" itemprop="thumbnail" alt="Image description"></div></a>
                                <figcaption itemprop="caption description">Image caption  4</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-description">
                <h6>Perks</h6>
                <ul>
                    <li>Competitive pay</li>
                    <li>Competitive medical, dental, and vision insurance plans</li>
                    <li>Company-provided 401(k) plan</li>
                    <li>Paid vacation and sick time</li>
                    <li>Free snacks and beverages</li>
                </ul>
            </div>
            <div class="job-description">
                <button class="btn btn-primary" type="button"><span><i class="fa fa-check"></i></span> Save this job</button>
                <button class="btn btn-primary" type="button"><span><i class="fa fa-share-alt"></i></span> Share</button>
            </div>
        </div>
    </div>
</div>
