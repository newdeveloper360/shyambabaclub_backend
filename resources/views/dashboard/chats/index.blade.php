@extends('layouts.app')
@section('title', 'Admin | Chats ')
@section('content')
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('layouts.navbar')
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="card">
                                    <div class="body">
                                        <div id="plist" class="people-list">
                                            <div class="chat-search">
                                                <h4>Chats</h4>
                                            </div>
                                            <hr>
                                            <div class="m-b-20">
                                                <div id="chat-scroll">
                                                    <ul class="chat-list list-unstyled m-b-0" id="chatList">
                                                        @foreach ($chats as $chat)
                                                            <li class="chats clearfix" data-chat="{{ $chat->id }}">
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <div class="about">
                                                                            <div class="name font-weight-bold">
                                                                                {{ $chat->user->name . ' (' . $chat->user->phone . ')' }}
                                                                            </div>
                                                                            <div class="status">
                                                                                {{ ucfirst(str_replace('_', ' ', $chat->type)) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 text-right unreadMessage">
                                                                        <span
                                                                            class="badge badge-danger">{{ $chat->unread_messages > 0 ? $chat->unread_messages : '' }}</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        <div id="divOfChatIdsData"
                                                            data-chat-ids="{{ $chats->pluck('id')->implode(',') }}"
                                                            data-chat-exists="{{ $chats->isNotEmpty() ? 'true' : 'false' }}">
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="divOfChatWall" class="col-xs-12 col-sm-12 col-md-9 col-lg-9 d-none">
                                <div class="card">
                                    <div class="chat">
                                        <div class="chat-header clearfix">
                                            <div class="chat-about">
                                                <div class="chat-with" id="headerUserName"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-box" id="mychatbox">
                                        <div class="card-body chat-content">
                                        </div>
                                        @can('chats-send-message')
                                        <div class="card-footer chat-form">
                                            <form id="chat-form">
                                                <input type="text" class="form-control" placeholder="Type a message">
                                                <div class="col-5 d-flex">
                                                    <input type="file" class="form-control-file pl-1">
                                                    <button type="button" class="btn btn-danger ml-5 d-none"
                                                        id="cancel-upload">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                <button class="btn btn-primary">
                                                    <i class="far fa-paper-plane"></i>
                                                </button>
                                                <span class="text-danger px-2 py-5" id="msg-error"></span>
                                            </form>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <div id="noChatWall"
                                class="card col-xs-12 col-sm-12 col-md-9 col-lg-9 d-flex justify-content-center align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div><i data-feather="message-square"></i>
                                        <span class="px-2"> Select a chat from the tabs aside.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('dashboard.chats.script')
    @endpush
@endsection
