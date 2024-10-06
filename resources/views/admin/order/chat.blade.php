@extends('admin.admin_layouts')
@section('admin_content')
    @includeIf('admin.chat.stylings', ['type' => 'customer'])

    <h1 class="h3 mb-3 text-gray-800">Order Number - {{ $order_number }}</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Messages</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.order.grid') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Back to Orders
                </a>
            </div>
        </div>
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
                        <form action="{{ route('admin.order.chat.store') }}" method="post">
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
