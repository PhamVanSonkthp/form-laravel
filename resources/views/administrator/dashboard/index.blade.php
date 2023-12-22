@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
@endsection

@section('name')
    <h4 class="page-title">Tổng quan</h4>
@endsection

@section('css')
    <style>
        .hover {
            padding: 20px;
        }

        .hover:hover {
            background-color: aliceblue;
            border-radius: 10px;
        }

        .action_detail {
            cursor: pointer;
        }

        /*.action_detail:hover{*/
        /*    -webkit-transform: scale(1.1);*/
        /*    transform: scale(1.1);*/
        /*    -webkit-transition: .5s ease-in-out;*/
        /*    transition: .5s ease-in-out;*/
        /*}*/

        .action_detail:hover:hover {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .action_detail {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-transition: .5s ease-in-out;
            transition: .5s ease-in-out;
        }
    </style>
@endsection

@section('content')

    @can('dashboard-list')
        <div class="container-fluid general-widget">

            <div class="card">

                <div class="card-header">

                    <div class="float-start ms-2">
                        <label>
                            Lọc theo ngày
                        </label>
                        <input id="input_search_datetime" type="date"
                               class="bg-white form-control open-jquery-date-range" placeholder="--/--/--"
                               value="">
                    </div>

                    <div class="float-start d-flex ms-2">
                        <div>
                            <label>Lọc theo thành viên</label>
                            <select name="user_id" class="form-control select2_init_allow_clear">
                                <option value="">Chọn</option>
                                @foreach($users as $user)
                                    <option
                                        value="{{$user->id}}" {{request('user_id') == $user->id ? 'selected' : ''}}>{{$user->name}}
                                        - {{$user->phone}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="float-start d-flex ms-2">
                        <div style="margin-top: 30px;">
                            <button class="btn btn-outline-primary ms-2" type="button" onclick="onSearchQuery()"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>

                    </div>

                </div>

                <div class="card-body">
                    <div>
                        <strong>
                            Tổng quan
                        </strong>
                    </div>

                    <div class="row mt-3">
                        <div class="row">

                            <div class="col-4 hover">
                                <a
                                    href="{{route('administrator.opportunities.index', ['opportunity_status_id' => 2, 'from'=> request('from'), 'to'=> request('to')])}}">
                                    <div class="text-center" style="font-size: 20px;">
                                        <strong>
                                            {{\App\Models\Formatter::formatNumber($counterOpportunity1)}}
                                        </strong>
                                    </div>

                                    <div class="text-center text-dark">
                                        Cơ hội đã trao
                                    </div>
                                </a>

                            </div>

                            <div class="col-4 hover">
                                <a
                                    href="{{route('administrator.opportunities.index', ['opportunity_status_id' => 1, 'from'=> request('from'), 'to'=> request('to')])}}">
                                    <div class="text-center" style="font-size: 20px;">
                                        <strong>
                                            {{\App\Models\Formatter::formatNumber($counterOpportunity2)}}
                                        </strong>
                                    </div>

                                    <div class="text-center text-dark">
                                        Cơ hội chưa trao
                                    </div>
                                </a>

                            </div>

                            <div class="col-4 hover">
                                <a
                                    href="{{route('administrator.opportunities.index',['from'=> request('from'), 'to'=> request('to')])}}">
                                    <div class="text-center" style="font-size: 20px;">
                                        <strong>
                                            {{\App\Models\Formatter::formatNumber($counterOpportunity1 + $counterOpportunity2)}}
                                        </strong>
                                    </div>

                                    <div class="text-center text-dark">
                                        Tổng
                                    </div>
                                </a>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-4 hover">
                                <a
                                    href="{{route('administrator.opportunities.index', ['opportunity_status_id' => 2])}}">
                                    <div class="text-center" style="font-size: 20px;">
                                        <strong>
                                            {{\App\Models\Formatter::formatNumber($costOpportunity1)}}
                                        </strong>
                                    </div>

                                    <div class="text-center text-dark">
                                        Giá trị HĐ đã trao
                                    </div>
                                </a>

                            </div>

                            <div class="col-4 hover">
                                <a
                                    href="{{route('administrator.opportunities.index', ['opportunity_status_id' => 1])}}">
                                    <div class="text-center" style="font-size: 20px;">
                                        <strong>
                                            {{\App\Models\Formatter::formatNumber($costOpportunity2)}}
                                        </strong>
                                    </div>

                                    <div class="text-center text-dark">
                                        Giá trị HĐ chưa trao
                                    </div>
                                </a>

                            </div>

                            <div class="col-4 hover">
                                <a
                                    href="{{route('administrator.opportunities.index')}}">
                                    <div class="text-center" style="font-size: 20px;">
                                        <strong>
                                            {{\App\Models\Formatter::formatNumber($costOpportunity1 + $costOpportunity2)}}
                                        </strong>
                                    </div>

                                    <div class="text-center text-dark">
                                        Tổng giá trị HĐ
                                    </div>
                                </a>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div>

                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="top-tabContent">
                            <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                                 aria-labelledby="top-home-tab">
                                <div class="row">

                                    @foreach($opportunities as $opportunity)
                                        <div class="col-xxl-4 box-col-6 col-lg-6 action_detail"
                                             data-url="{{route('administrator.opportunities.detail' , ['id'=> $opportunity->id])}}">
                                            <div class="project-box">
                                                <span
                                                    class="badge {{optional($opportunity->status)->id == 2 ? 'badge-secondary' : 'badge-primary'}} ">{{optional($opportunity->status)->name}}</span>

                                                <h6>{{ optional($opportunity->user)->name}}</h6>
                                                <div class="media"><img class="me-2 rounded-circle"
                                                                        src="{{ optional($opportunity->user)->avatar()}}"
                                                                        alt="" data-original-title="" title="">
                                                    <div class="media-body">
                                                        <p>{{optional($opportunity->user)->phone}}</p>
                                                    </div>
                                                </div>
                                                <p>{{ $opportunity->name }}</p>
                                                <div class="row details">
                                                    <div class="col-6"><span>Ngành nghề</span></div>
                                                    <div class="col-6 font-{{optional($opportunity->status)->id == 2 ? 'secondary' : 'primary'}}">{{ optional($opportunity->category)->name}} </div>
                                                    <div class="col-6"><span>Số người đang tham gia</span></div>
                                                    <div
                                                        class="col-6 font-{{optional($opportunity->status)->id == 2 ? 'secondary' : 'primary'}}">
                                                        {{$opportunity->opportunityUsers->count() == 0 ? 'Mọi người' : $opportunity->opportunityUsers->count()}}
                                                    </div>
                                                    <div class="col-6"><span>Giá trị hợp đồng</span></div>
                                                    <div class="col-6 font-{{optional($opportunity->status)->id == 2 ? 'secondary' : 'primary'}}">{{ \App\Models\Formatter::formatMoney($opportunity->cost) }} VNĐ </div>
                                                </div>
                                                <div class="customers">
                                                    <ul>
                                                        @foreach($opportunity->opportunityUsers as $opportunityUser)

                                                            <li class="d-inline-block"><img class="rounded-circle"
                                                                                            src="{{ optional($opportunityUser->user)->avatar()}}"
                                                                                            alt=""
                                                                                            data-original-title=""
                                                                                            title=""></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="project-status mt-4">
                                                    <div class="media mb-0">
                                                        <div class="media-body text-end"><span></span></div>
                                                    </div>
                                                    <div class="progress" style="height: 5px">
                                                        <div
                                                            class="progress-bar-animated bg-{{optional($opportunity->status)->id == 2 ? 'secondary' : 'primary'}} progress-bar-striped"
                                                            role="progressbar" style="width: 70%" aria-valuenow="10"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if(count($opportunities) == 0)
                                        <h3 class="text-center">
                                            Không có dữ liệu
                                        </h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @else
        Bạn không có quyền truy cập Dashboard
    @endcan

    <div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="changeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="content_modal_detail">


                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function onSearchQuery() {
            addUrlParameterObjects([
                {name: "search_query", value: $('#input_search_query').val()},
                {name: "from", value: input_query_from},
                {name: "to", value: input_query_to},
                {name: "page", value: 1},
            ])
        }

        $('select[name="user_id"]').on('change', function () {
            addUrlParameter('user_id', this.value)
        });

    </script>

    <script>

        function actionDetail(event, url = null, table = null, target_remove = null) {
            event.preventDefault()
            let urlRequest = $(this).data('url')
            let that = $(this)

            if (!urlRequest) {
                urlRequest = url
            }

            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlRequest,
                beforeSend: function () {
                    showLoading()
                },
                success: function (response) {
                    hideLoading()
                    $('#content_modal_detail').html(response.html)
                    showModal('modal_detail')
                },
                error: function (err) {
                    console.log(err)
                    hideLoading()
                    Swal.fire(
                        {
                            icon: 'error',
                            title: err.responseText,
                        }
                    );
                },
            })

        }

        $(document).ready(function () {

            $(document).on('click', '.action_detail', actionDetail);

        });


    </script>

@endsection
