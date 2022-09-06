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
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('assets/administrator/css/chat.css')}}"/>

@endsection

@include('administrator.chat.active_slidebar')

@section('content')
    @php
        $chatGroupIdWithUser = \App\Models\ParticipantChat::chatGroupIdWithUser(request('user_id'));
        if(empty($chatGroupIdWithUser)){
            $chatGroupIdWithUser = (count($items) ? $items[0]->chat_group_id : 0);
        }
        $isHaveUserId = false;
    @endphp
    <div class="col-md-4">

        <div class="card">

            <div class="card-header">
                Danh sách đã chat
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Tên</th>
                        </tr>
                        </thead>
                        <tbody class="container-participant">

                        @foreach($items as $item)
                            <tr style="cursor: pointer;{{$item->chat_group_id == $chatGroupIdWithUser ? 'color: red;' : ''}}"
                                data-url="{{route('administrator.chat.participant' , ['id' => $item->chat_group_id])}}"
                                data-id="{{$item->chat_group_id}}"
                                data-participant_chat_id="{{$item->id}}"
                            >
                                @php
                                    if($item->chat_group_id == $chatGroupIdWithUser){
                                        $isHaveUserId = true;
                                    }
                                @endphp
                                <td>
                                    @foreach(\App\Models\ParticipantChat::where('chat_group_id', $item->chat_group_id)->get() as $itemParticipantChat)
                                        @if(auth()->id() != optional($itemParticipantChat->user)->id)
                                            <div data-userid="{{optional($itemParticipantChat->user)->id}}"
                                                 data-username="{{optional($itemParticipantChat->user)->name}}"
                                                 data-notechat="{{optional($itemParticipantChat->user)->note_chat}}">
                                                {{ optional($itemParticipantChat->user)->name}}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="card" style="display: none">
            <div class="card-header">
                Danh sách khách hàng
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Vai trò</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Models\User::where('is_admin' , '!=' , 1)->get() as $item)

                            <tr style="cursor: pointer;{{$item->id == request('user_id') ? 'color: red;' : ''}}">
                                <td>
                                    <div>
                                        {{ $item->display_name}}
                                    </div>
                                </td>
                                <td>
                                    {{optional($item->role)->name}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-8">
        <div>
            <div class="card" id="chat2">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <h5 class="mb-0" id="lbl_name_message"></h5>
                </div>
                <div id="container_chat" class="card-body" data-mdb-perfect-scrollbar="true"
                     style="position: relative; height: 67vh;overflow: auto">

                    {{--                    <div class="divider d-flex align-items-center mb-4">--}}
                    {{--                        <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>--}}
                    {{--                    </div>--}}
                </div>
                <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                    <input type="text" class="form-control form-control-lg" placeholder="Nhập nội dung"
                           id="input_message">
                    <div>
                        <input class="form-control form-control-sm" id="file_images" type="file" multiple
                               accept="image/*">
                    </div>

                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-outline dropdown-toggle ms-3 me-3"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-smile"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <div class="h-full tab-pane active" role="tabpanel" aria-labelledby="smile-tab">
                                <div class="font-medium px-3">Smileys &amp; People</div>
                                <div class="h-full pb-10 px-2 overflow-y-auto scrollbar-hidden mt-2"
                                     style="max-height: 20vh;overflow-y: auto;width: 20vw;">
                                    <div class="grid grid-cols-8 text-2xl" id="smile">
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😁
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😂
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤣
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😃
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😄
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😅
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😆
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😉
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😊
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😋
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😎
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😍
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😘
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😗
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😙
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😚
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">☺️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙂
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤗
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤔
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😐
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😑
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😶
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙄
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😏
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😣
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😥
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😮
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤐
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😯
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😪
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😫
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😴
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😌
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😛
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😜
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😝
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😔
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😕
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙃
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤑
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😲
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">☹️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙁
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😖
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😞
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😟
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😢
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😭
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤯
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😬
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😰
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😱
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😳
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤪
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😵
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😡
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😠
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤬
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😷
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤕
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤢
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤮
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😇
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤠
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤡
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤥
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤫
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤭
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧐
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😈
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👿
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👹
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👺
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">☠️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👻
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👽
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👾
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤖
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😺
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😸
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😹
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😻
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😼
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😽
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😿
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">😾
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙈
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙉
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙊
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👶
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧑
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👴
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👵
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍⚕️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍⚕️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🎓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🎓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🏫
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🏫
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍⚖️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍⚖️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🌾
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🌾
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🍳
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🍳
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🔧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🔧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🏭
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🏭
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍💼
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍💼
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🔬
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🔬
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍💻
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍💻
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🎤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🎤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🎨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🎨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍✈️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍✈️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🚀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🚀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍🚒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍🚒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👮
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👮‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👮‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🕵️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🕵️‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🕵️‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💂
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💂‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💂‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👷
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👷‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👷‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤴
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👸
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👳
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👳‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👳‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👲
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧕
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧔
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👱
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👱‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👱‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤵
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👰
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤰
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤱
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👼
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🎅
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤶
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧙
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧙‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧙‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧚
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧚‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧚‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧛
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧛‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧛‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧜
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧜‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧜‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧝
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧝‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧝‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧞
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧞‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧞‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧟
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧟‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧟‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙍
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙍‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙍‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙎
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙎‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙎‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙅
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙅‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙅‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙆
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙆‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙆‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💁
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💁‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💁‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙋
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙋‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙋‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙇
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙇‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🙇‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤦‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤦‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤷
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤷‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤷‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💆
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💆‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💆‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💇
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💇‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            💇‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🚶
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚶‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚶‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🏃
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏃‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏃‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💃
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🕺
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👯
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👯‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👯‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧖
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧖‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧖‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧗
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧗‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧗‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧘
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧘‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🧘‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🛀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🛌
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🕴️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🗣️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👥
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤺
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🏇
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">⛷️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🏂
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏌️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏌️‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏌️‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🏄
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏄‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏄‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🚣
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚣‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚣‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🏊
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏊‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏊‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">⛹️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            ⛹️‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            ⛹️‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏋️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏋️‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏋️‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🚴
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚴‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚴‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🚵
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚵‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🚵‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏎️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🏍️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤸
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤸‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤸‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤼
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤼‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤼‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤽
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤽‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤽‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤾
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤾‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤾‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤹
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤹‍♂️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🤹‍♀️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👫
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👬
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👭
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💏
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍❤️‍💋‍👨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍❤️‍💋‍👨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍❤️‍💋‍👩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💑
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍❤️‍👨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍❤️‍👨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍❤️‍👩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👪
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👩‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👩‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👩‍👧‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👩‍👦‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👩‍👧‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👨‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👨‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👨‍👧‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👨‍👦‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👨‍👧‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👩‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👩‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👩‍👧‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👩‍👦‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👩‍👧‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👦‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👧‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👨‍👧‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👦‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👧‍👦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👩‍👧‍👧
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤳
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💪
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👈
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👉
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">☝️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👆
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🖕
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👇
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">✌️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤞
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🖖
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤘
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤙
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🖐️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">✋
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👌
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👍
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👎
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">✊
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👊
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤛
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤜
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤚
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👋
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤟
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">✍️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👏
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👐
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙌
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤲
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🙏
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🤝
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💅
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👂
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👃
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👣
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👀
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👁️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            👁️‍🗨️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧠
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👅
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👄
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💋
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💘
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">❤️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💔
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💕
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💖
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💗
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💙
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💚
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💛
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧡
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💜
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🖤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💝
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💞
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💟
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">❣️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💌
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💢
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💣
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💥
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💨
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💫
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💬
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🗨️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🗯️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💭
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🕳️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🕶️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👔
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👕
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👖
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧣
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧤
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧥
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧦
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👗
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👘
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👙
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👚
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👛
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👜
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👝
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">
                                            🛍️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🎒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👞
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👟
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👠
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👡
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👢
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👑
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">👒
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🎩
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🎓
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">🧢
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">⛑️
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">📿
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💄
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💍
                                        </button>
                                        <button
                                            class="rounded focus:outline-none hover:bg-gray-200 dark:hover:bg-dark-2">💎
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>

                    <button onclick="sendMessage()" class="btn-primary btn"><i class="fas fa-paper-plane"></i></button>

                </div>
            </div>

        </div>
    </div>

{{--    <div class="col-md-3">--}}
{{--        <div class="text-center">--}}
{{--            <a href="#" onclick="viewProfile()" class="border-search ps-5 pe-5 pt-3 pb-3">--}}
{{--                Xem hồ sơ--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="mt-3">--}}
{{--            <label>Ghi chú</label>--}}

{{--            <div>--}}
{{--                <textarea data-field="note_chat" id="txa_note_chat" rows="8" style="width: 100%"></textarea>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    @if(!$isHaveUserId)
        <style>
            .container-participant > tr:first-child {
                color: red;
            }
        </style>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <img id="image_modal">
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('vendor/sweet-alert-2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/products/index/list.js')}}"></script>

    <script type="text/javascript" src="{{asset('vendor/datetimepicker/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/datetimepicker/daterangepicker.js')}}"></script>

{{--    <script src="{{asset('vendor/pusher/pusher.min.js')}}"></script>--}}
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: '{{env('PUSHER_APP_CLUSTER')}}'
        });

        var channel = pusher.subscribe('id-chat-pusher-' + '{{auth()->id()}}');
        channel.bind('id-chat-pusher-' + '{{auth()->id()}}', function (data) {
            console.log(data)
            if (data.chat_group_id == chat_group_id) {
                addMessageToChatBox(data.content, data.created_at, false, true, data.image_link, data.images)
            }
        });
    </script>

    <script>

        let chat_group_id = "{{count($items) ? $items[0]->chat_group_id : 0}}"
        let participant_chat_id = "{{count($items) ? $items[0]->id : 0}}"
        let user_profile_id = "{{request('user_id')}}"
        let urlRequestLoadmore
        let page
        let canLoadmore = true
        let name_getter = ''

        if ("{{request('user_id')}}") {
            chat_group_id_temp = '{{$chatGroupIdWithUser}}'

            if (chat_group_id_temp) {
                chat_group_id = chat_group_id_temp
            }
        }

        function addMessageToChatBox(content, time, sender = true, add_to_bottom = true, img_link = "", images = [], is_scroll_to_bottom = true) {
            if (!images) {
                images = []
            }
            time = formatCommentTime(time)
            content = escapeHtml(content)
            const element = $(`#container_chat`)

            let data = ``
            let display = 'none';

            if (content && content != 'null' && content != '""') {
                display = 'inline-block;'
            }

            let data_image = '';

            for (let i = 0; i < images.length; i++) {
                data_image += `<div class="col-4 pe-0">
                                    <img data-src="${images[i].image_path}" onclick="showImage(this)" class="image-chat" src="${images[i].image_path}">
                                </div>`
            }
            if (sender) {
                data = `<div class="d-flex flex-row justify-content-end message">
                        <div class="w-100 text-end">
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary text-chat" style="display: ${display};">${content}</p>
                            <div class="row justify-content-end small me-3 rounded-3">
                                ${data_image}
                            </div>
                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${time}</p>
                        </div>
                        <img src="{{auth()->user()->feature_image_path}}" class="avatar-chat">
                    </div>`

            } else {
                data = `<div class="d-flex flex-row justify-content-start mb-4 message">
                        <img src="${img_link}"  class="avatar-chat">
                        <div class="w-100 text-start">
                            <p class="small ms-3 mb-1 text-chat">${name_getter}</p>
                            <p class="small p-2 ms-3 mb-1 rounded-3 text-chat" style="background-color: #f5f6f7;display: ${display};">${content}</p>
                            <div class="row justify-content-end small me-3 rounded-3">
                                ${data_image}
                            </div>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">${time}</p>
                        </div>
                    </div>`
            }

            if (add_to_bottom) {
                element.append(data)
            } else {
                element.prepend(data)
            }

            if (is_scroll_to_bottom) {
                element.animate({
                    scrollTop: element.prop("scrollHeight")
                }, 0);
            }

        }

        function sendMessage() {
            if (chat_group_id) {
                const fd = new FormData();
                let TotalFiles = $('#file_images')[0].files.length; //Total files

                if (!$("#input_message").val() && !TotalFiles) return

                const files = $('#file_images')[0];

                for (let i = 0; i < TotalFiles; i++) {
                    fd.append('feature_image' + i, files.files[i]);
                }
                fd.append('total_files', TotalFiles);

                fd.append('contents', $("#input_message").val());
                fd.append('chat_group_id', chat_group_id);
                $.ajax({
                    type: 'POST',
                    url: "{{route('administrator.chat.create')}}",
                    headers: {
                        // 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data:{
                    //     'contents': $(this).val(),
                    //     'chat_group_id': chat_group_id,
                    // },
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        addMessageToChatBox(response.content, response.created_at, true, true, null, response.images)
                    },
                    error: function (err) {
                        console.log(err)
                    },
                })

                $("#input_message").val('')
                $("#file_images").val(null);
            }
        }

        $("#input_message").on("keydown", function search(e) {

            if (e.keyCode == 13) {
                sendMessage()
            }
        })

        $(document).ready(function ($) {
            if (chat_group_id) {
                page = 1
                urlRequestLoadmore = "{{route('administrator.chat.participant' , ['id' => $chatGroupIdWithUser])}}";

                $.ajax({
                    type: 'GET',
                    url: "{{route('administrator.chat.participant' , ['id' => $chatGroupIdWithUser])}}",
                    success: function (response) {
                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i].user_id == "{{auth()->id()}}") {
                                addMessageToChatBox(response.data[i].content, response.data[i].created_at, true, false, response.data[i].user.feature_image_path, response.data[i].images)
                            } else {
                                addMessageToChatBox(response.data[i].content, response.data[i].created_at, false, false, response.data[i].user.feature_image_path, response.data[i].images)
                            }
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    },
                })
            }

            $(".container-participant tr").click(function () {
                canLoadmore = false;
                const element = $(`#container_chat`)

                element.html('')
                chat_group_id = $(this).data('id')
                participant_chat_id = $(this).data('participant_chat_id')
                $('#lbl_name_message').html($(this).children(":first").html())
                $('#txa_note_chat').val($(this).children(":first").children(":first").data('notechat'))

                user_profile_id = $(this).children(":first").children(":first").data('userid')

                $('tr').css("color", "black")
                $(this).css("color", "red")
                let urlRequest = $(this).data('url')
                urlRequestLoadmore = $(this).data('url')
                page = 1

                $.ajax({
                    type: 'GET',
                    url: urlRequest,
                    success: function (response) {
                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i].user_id == "{{auth()->id()}}") {
                                addMessageToChatBox(response.data[i].content, response.data[i].created_at, true, false, response.data[i].user.feature_image_path, response.data[i].images)
                            } else {
                                addMessageToChatBox(response.data[i].content, response.data[i].created_at, false, false, response.data[i].user.feature_image_path, response.data[i].images)
                            }
                        }
                        if (response.data.length) {
                            canLoadmore = true;
                        } else {
                            $('#container_chat').prepend(`<div class="divider d-flex align-items-center mb-4">
                                                    <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Đã hết tin</p>
                                                </div>`)

                        }
                    },
                    error: function (err) {
                        console.log(err)
                    },
                })
            });

        });

        $("#smile button").click(function () {
            $("#input_message").val($("#input_message").val() + $(this).html())
        })

        function viewProfile() {
            if(user_profile_id){
                window.location.href = "/administrator/users/edit/" + user_profile_id
            }
        }

        function loadmoreChat() {
            if (canLoadmore) {
                canLoadmore = false;
                $('#container_chat').prepend(`<div class="text-center" style="position: absolute;left: 0;right: 0;"><div style="position: absolute;" class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>`)

                $.ajax({
                    type: 'GET',
                    url: urlRequestLoadmore + '?page=' + ++page,
                    success: function (response) {
                        $('.spinner-border').remove()
                        const firstMsg = $('.message:first');
                        const curOffset = firstMsg.offset().top - $(document).scrollTop();
                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i].user_id == "{{auth()->id()}}") {
                                addMessageToChatBox(response.data[i].content, response.data[i].created_at, true, false, response.data[i].user.feature_image_path, response.data[i].images, false)
                            } else {
                                addMessageToChatBox(response.data[i].content, response.data[i].created_at, false, false, response.data[i].user.feature_image_path, response.data[i].images, false)
                            }
                        }

                        $('#container_chat').scrollTop(firstMsg.offset().top - curOffset);

                        if (response.data.length) {
                            canLoadmore = true;
                        } else {
                            $('#container_chat').prepend(`<div class="divider d-flex align-items-center mb-4">
                                                    <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Đã hết tin</p>
                                                </div>`)

                        }

                    },
                    error: function (err) {
                        console.log(err)
                    },
                })
            }
        }

        $('#container_chat').scroll(function () {
            var pos = $('#container_chat').scrollTop();
            if (pos == 0) {
                loadmoreChat()
            }
        });

        $('#txa_note_chat').on('change', function () {

            if (!user_profile_id) return

            const value = $(this).val()
            const field = $(this).data('field')


            $.ajax({
                type: 'PUT',
                url: "/administrator/users/update/" + user_profile_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    [field]: value,
                },
                success: function (response) {
                    console.log(response)
                },
                error: function (err) {
                    console.log(err)
                },
            })
        })

        function showImage(e){
            const src = $(e).attr("src")

            const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
            $("#image_modal").attr("src",src)
            myModal.show()
        }
    </script>

    <script>
        $('.note').on('change', function () {
            const value = this.value
            const field = $(this).data('field')

            $.ajax({
                type: 'PUT',
                url: "/administrator/chats/participant/update/" + participant_chat_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    [field]: value,
                },
                success: function (response) {
                    console.log(response)
                },
                error: function (err) {
                    console.log(err)
                },
            })
        })
    </script>
@endsection
