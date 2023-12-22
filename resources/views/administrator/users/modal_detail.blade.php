<div class="user-profile">
    <div class="row">

        <div class="col-xl-4 col-lg-12 col-md-5 xl-35">
            <div class="card profile-header bg-size" style="background-image: url(&quot;../assets/images/user-profile/bg-profile.jpg&quot;); background-size: cover; background-position: center center; display: block;"><img class="img-fluid bg-img-cover" src="../assets/images/user-profile/bg-profile.jpg" alt="" style="display: none;">
                <div class="profile-img-wrrap bg-size" style="background-image: url(&quot;../assets/images/user-profile/bg-profile.jpg&quot;); background-size: cover; background-position: center center; display: block;"><img class="img-fluid bg-img-cover" src="../assets/images/user-profile/bg-profile.jpg" alt="" style="display: none;"></div>
                <div class="userpro-box">
                    <div class="img-wrraper">
                        <div class="avatar"><img class="img-fluid" alt="" src="{{$item->avatar()}}"></div>
                    </div>
                    <div class="user-designation">
                        <div class="title"><a >
                                <h4>{{$item->name}}</h4>
                                <h6>{{ optional($item->opportunyCategory)->name}}</h6></a></div>
                        <div class="social-media">
                            <ul class="user-list-social">
                                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://accounts.google.com/"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="https://dashboard.rss.com/auth/sign-in/"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>
                        <div class="follow">
                            <ul class="follow-list">
                                <li>
                                    <div class="follow-num counter">{{$item->opportunities->count()}}</div><span>Dự án đã trao</span>
                                </li>
                                <li>
                                    <div class="follow-num counter">{{$item->takenOpportunities->count()}}</div><span>Dự án đã nhận</span>
                                </li>
                                <li>
                                    <div class="follow-num counter">{{$item->opportunities->sum('cost')}}</div><span>Giá trị HĐ đã trao</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-12 col-md-7 xl-65">
            <div class="row">
                <!-- profile post start-->

                @foreach($opportunities as $opportunitiy)
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="profile-post">
                                <div class="post-header">
                                    <div class="media"><img class="img-thumbnail rounded-circle me-3" style="width: 40px;" src="{{$item->avatar()}}" alt="Generic placeholder image">
                                        <div class="media-body align-self-center"><a>
                                                <h5 class="user-name">{{$opportunitiy->client_name}}</h5></a>
                                            <h6>{{$opportunitiy->client_phone}} - {{$opportunitiy->category->name}} - {{\App\Models\Formatter::formatTimeToNow($opportunitiy->created_at)}}</h6>
                                        </div>
                                    </div>

                                </div>
                                <div class="post-body">
                                    <h4>
                                        {{$opportunitiy->name}}
                                    </h4>
                                    <p>{{$opportunitiy->content}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- profile post end-->                        -->
            </div>
        </div>
        <!-- user profile fifth-style end-->
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap">
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
                <div class="pswp__ui pswp__ui--hidden">
                    <div class="pswp__top-bar">
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--share" title="Share"></button>
                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>
                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>
</div>
