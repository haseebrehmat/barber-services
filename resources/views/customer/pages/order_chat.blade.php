@extends('layouts.app')

@section('content')
    @includeIf('admin.chat.stylings', ['type' => 'customer'])

    <div class="page-banner"
        style="background-image: url({{ asset('public/uploads/' . $g_setting->banner_customer_panel) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Orders</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('customer/order') }}">Orders</a></li>
                    <li class="breadcrumb-item" aria-current="page">Number - {{ $order_number }}</li>
                    <li class="breadcrumb-item active" aria-current="page">Chat</li>
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

                    <div class="card-body px-0">
                        <div class="container-fluid chats">
                            <div class="chat-box">
                                <div class="container-fluid">

                                    <div class="chat-container">
                                        @forelse ($data as $row)
                                            <div
                                                class="message @if ($row->from === 'customer') customer-message @else admin-message @endif">
                                                <div class="message-content">
                                                    <small class="username">
                                                        {{ isset($row->username) ? $row->username : 'Guest User' }}
                                                    </small>
                                                    <p class="message-text">{!! $row->msg !!}</p>
                                                    <small class="message-time">
                                                        {{ \Carbon\Carbon::parse($row->created_at)->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                            </div>
                                        @empty
                                            <h5>No messages found</h5>
                                        @endforelse
                                    </div>
                                    <form action="{{ url('customer/order/chat') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ Crypt::encrypt($id) }}">
                                        <textarea name="msg" class="form-control" placeholder="Start typing here..." id="message-compose-box"></textarea>
                                        <button type="submit" class="btn btn-success float-right mt-1">Send</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var textareaActive = false; // Flag to track if textarea is focused/active

            // Listen for textarea focus event
            $('#message-compose-box').on('focus', function() {
                textareaActive = true;
            });

            // Listen for textarea blur event
            $('#message-compose-box').on('blur', function() {
                textareaActive = false;
            });

            // Function to reload the page
            function reloadPage() {
                if (!textareaActive) {
                    location.reload();
                }
            }

            // Reload the page every 15 seconds
            setInterval(reloadPage, 15000);
        });
    </script>
@endsection
