@extends('admin.admin_layouts')
@section('admin_content')
    @includeIf('admin.chat.stylings', ['type' => 'employee'])

    <h1 class="h3 mb-3 text-gray-800">Chat with Employees</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Messages</h6>
        </div>
        <div class="card-body px-0">
            <div class="container-fluid chats">
                <div class="chat-box">
                    <div class="container-fluid">
                        @if (isset($employee))
                            <h4>Chat with Admin</h4>
                            <div class="chat-container">
                                @foreach ($messages as $row)
                                    <div
                                        class="message @if ($row->sent_by === 'admin') admin-message @else employee-message @endif">
                                        <div class="message-content">
                                            @if ($row->sent_by!='admin')
                                                    <img style="width: 30px;height: 30px;" class="img-profile rounded-circle" src="{{ asset('public/uploads/'.$employee->photo) }}">   
                                                @endif
                                            <small class="username">
                                                {{ $row->sent_by === 'admin' ? 'Admin' : $employee->name }}</small>
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
                                <input type="hidden" name="type" value="{{ Crypt::encrypt('employee') }}">
                                <input type="hidden" name="sent_by" value="employee">
                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
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
@endsection
