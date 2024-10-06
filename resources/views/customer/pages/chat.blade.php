@extends('layouts.app')

@section('content')
    @includeIf('admin.chat.stylings', ['type' => 'customer'])
    <div class="page-banner"
        style="background-image: url({{ asset('public/uploads/' . $g_setting->banner_customer_panel) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Chat</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chat with Admin</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="user-sidebar">
                        @include('layouts.sidebar_customer')
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="container-fluid chats">
                        <div class="chat-box">
                            <div class="container-fluid">
                                @if (isset($customer))
                                    <h4>Chat with Admin</h4>
                                    <div class="chat-container">
                                        @foreach ($messages as $row)
                                            <div
                                                class="message @if ($row->sent_by === 'admin') admin-message @else customer-message @endif">
                                                <div class="message-content">
                                                    <small class="username">
                                                        {{ $row->sent_by === 'admin' ? 'Admin' : $customer->customer_name }}</small>
                                                    <p class="message-text">{!! $row->msg !!}</p>
                                                    <small class="message-time">
                                                        {{ $row->created_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <form action="{{ route('admin.chat.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ Crypt::encrypt('customer') }}">
                                        <input type="hidden" name="sent_by" value="customer">
                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                        <textarea name="msg" class="form-control" placeholder="Start typing here..."></textarea>
                                        <button type="submit" class="btn btn-success mt-1">Send</button>
                                    </form>
                                @else
                                    <span>
                                        No messages found
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
