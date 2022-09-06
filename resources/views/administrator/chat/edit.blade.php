@extends('administrator.layouts.master')

@section('title')
    <title>Home page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('name')
    <h4 class="page-title">Chat</h4>
@endsection

@section('css')
    <link href="{{asset('admins/products/index/list.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('vendor/datetimepicker/daterangepicker.css')}}"/>

@endsection

@include('administrator.user.active_slidebar')

@section('content')
    <div class="col-md-9">

        <div class="card">

            <div class="card-header">
                Danh sách Finder > {{$user->real_name}}
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Câu hỏi</th>
                            <th>Câu trả lời</th>
                            <th>Note</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Tên đầy đủ của bạn</td>
                            <td>{{$user->real_name}}</td>
                            <td>{{$user->note_real_name}}</td>
                        </tr>
                        <tr>
                            <td>Tên hiển thị trên App</td>
                            <td>{{$user->display_name}}</td>
                            <td>{{$user->note_display_name}}</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->note_phone}}</td>
                        </tr>
                        <tr>
                            <td>Giới tính</td>
                            <td>{{ optional($user->gender)->name}}</td>
                            <td>{{ $user->note_gender}}</td>
                        </tr>
                        <tr>
                            <td>Ngày sinh</td>
                            <td>{{\App\Models\Formatter::getOnlyDate($user->date_of_birth)}}</td>
                            <td>{{$user->note_date_of_birth}}</td>
                        </tr>
                        <tr>
                            <td>Quê của Candidate</td>
                            <td>{{ optional($user->addressBorn)->name}}</td>
                            <td>{{ $user->note_address_born}}</td>
                        </tr>
                        <tr>
                            <td>Nơi bạn đang sống và làm việc</td>
                            <td>{{$user->address_working}}</td>
                            <td>{{$user->note_address_working}}</td>
                        </tr>
                        <tr>
                            <td>Trường đại học của bạn</td>
                            <td>{{$user->university}}</td>
                            <td>{{$user->note_university}}</td>
                        </tr>
                        <tr>
                            <td>Chiều cao</td>
                            <td>{{$user->heght}}</td>
                            <td>{{$user->note_heght}}</td>
                        </tr>
                        <tr>
                            <td>Nghề nghiệp</td>
                            <td>{{$user->job}}</td>
                            <td>{{$user->note_job}}</td>
                        </tr>
                        <tr>
                            <td>Chức danh</td>
                            <td>{{$user->job_title}}</td>
                            <td>{{$user->note_job_title}}</td>
                        </tr>

                        @foreach(\App\Models\TopicQuestionProfileCandidate::all() as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>
                                    <ul>
                                        @foreach($user->topicQuestionProfileCandidateUser($user->id, $item->id) as $question)
                                            <li>
                                                {{ optional($question->questionProfileCandidate)->name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach

                        <tr>
                            <td>Candidates quan tâm tới chủ đề gì?</td>
                            <td>{{$user->topic_favorite}}</td>
                            <td>{{$user->note_topic_favorite}}</td>
                        </tr>

                        <tr>
                            <td>Tải lên ảnh đại diện của Candidates</td>
                            <td>
                                <img src="{{$user->feature_image_path}}" alt="{{$user->feature_image_name}}"
                                     style="height: 100px;">
                            </td>
                            <td>

                            </td>
                        </tr>

                        <tr>
                            <td>Tải lên ảnh hồ sơ</td>
                            <td>
                                @foreach($user->identificationImages($user->id)->get() as $item)
                                    <a style="cursor: pointer" data-bs-toggle="modal"
                                       data-bs-target="#imageModal{{$item->id}}" data-bs-whatever="@mdo">
                                        <img src="{{$item->image_path}}" alt="{{$item->image_name}}"
                                             style="height: 100px;">
                                    </a>

                                    <div class="modal fade" id="imageModal{{$item->id}}" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ảnh</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>

                                                <img src="{{$item->image_path}}" alt="{{$item->image_name}}"
                                                     style="max-height: 50vh">
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </td>
                            <td>{{ $user->note_identification_images}}</td>
                        </tr>


                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-3">
        <form action="{{route('administrator.candidates.status.update' , ['id' => $user->id])}}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white p-3">

                <div class="d-flex mt-3">
                    <div class="flex-1">
                        Số Pair có:
                    </div>
                    <div class="flex-1 text-end">
                        <strong>{{ $user->number_pair}}</strong>
                    </div>
                </div>

                <div class="d-flex mt-3">
                    <div class="flex-1">
                        Số Date đã đồng ý:
                    </div>
                    <div class="flex-1 text-end">
                        <strong>{{ $user->number_date_accept}}</strong>
                    </div>
                </div>

                <div class="d-flex mt-3">
                    <div class="flex-1">
                        Số Date đã thực hiện:
                    </div>
                    <div class="flex-1 text-end">
                        <strong>{{ $user->number_date}}</strong>
                    </div>
                </div>

                <div class="d-flex mt-3">
                    <div class="flex-1">
                        <strong>Trạng thái duyệt hồ sơ:</strong>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input name="user_status_id" class="form-check-input"
                                   type="checkbox" {{$user->isActive($user->id) ? 'checked' : ''}}>
                        </div>
                        <p>Không thể tạo pair, date cho Candidates này</p>
                    </div>
                </div>

                <div class="d-flex mt-3">
                    <div class="flex-1">
                        <strong>Thêm vào danh sách Candidates chọn lọc:</strong>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input name="user_suggestion_id" class="form-check-input"
                                   type="checkbox" {{$user->isSuggestion($user->id) ? 'checked' : ''}}>
                        </div>
                        <p>Giúp Finder Gold & Silver nhìn thấy sớm hơn</p>
                    </div>
                </div>

                <div class="d-flex mt-3">
                    <div class="flex-1">
                        <strong>Không xuất hiện trên trang tìm kiếm của Finder:</strong>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input name="user_finder_find_id" class="form-check-input"
                                   type="checkbox" {{!$user->isFinderFind($user->id) ? 'checked' : ''}}>
                        </div>
                        <p>Finder không thể tìm kiếm thấy Candidates này</p>
                    </div>
                </div>

                <div class="text-end mt-3 container-save">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="w-50 btn btn-outline-secondary btn-lg rounded-pill">Chat</button>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('js')
    <script src="{{asset('vendor/sweet-alert-2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/products/index/list.js')}}"></script>

    <script type="text/javascript" src="{{asset('vendor/datetimepicker/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/datetimepicker/daterangepicker.js')}}"></script>

    <script>

        $('.container-save').hide()

        $('input').on('change', function () {
            $('.container-save').show()
        })
    </script>
@endsection
