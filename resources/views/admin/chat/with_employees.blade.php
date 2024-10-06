@extends('admin.admin_layouts')
@section('admin_content')
<style>
    .toggle-icon {
        transition: transform 0.3s ease;
    }
    
    .rotate {
        transform: rotate(180deg);
    }
    </style>
    
    @includeIf('admin.chat.stylings', ['type' => 'employee'])

    <h1 class="h3 mb-3 text-gray-800">Chat with Employees</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Messages</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.chat.new.message', 'type=' . Crypt::encrypt('employee')) }}"
                    class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Message</a>
            </div>
        </div>
        <div class="users-list" id="usersList">
            <h5><i class="fas fa-chevron-down toggle-icon"></i> Employees</h5>
            <div class="users-list-content">
                @forelse ($users as $row)
                    <div class="user">
                        <a class="btn p-0 my-0"
                            href="{{ route('admin.employees.chat', 'id=' . Crypt::encrypt($row->id)) }}">{{ ucwords($row->name) }}</a>
                    </div>
                @empty
                    <small>No Chat Found</small>
                @endforelse
            </div>
        </div>
        <div class="card-body px-0">
            <div class="container-fluid chats">
                
                <div class="chat-box">
                    <div class="container-fluid">
                        @if (isset($employee))
                            <h4>Chat with {{ $employee->name }} <img style="width: 50px;height: 50px;" class="img-profile rounded-circle" src="{{ asset('public/uploads/'.$employee->photo) }}"></h4>
                            <div class="chat-container">
                                @foreach ($messages as $row)
                                    <div
                                        class="message @if ($row->sent_by === 'admin') admin-message @else employee-message @endif">
                                        <div class="message-content">
                                            <small class="username">
                                                
                                                @if ($row->sent_by!='admin')
                                                    <img style="width: 30px;height: 30px;" class="img-profile rounded-circle" src="{{ asset('public/uploads/'.$employee->photo) }}">   
                                                @endif
                                                {{ $row->sent_by === 'admin' ? session('name') : $employee->name }}</small>
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
                                <input type="hidden" name="sent_by" value="admin">
                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                <textarea name="msg" class="form-control" placeholder="Start typing here..."></textarea>
                                <button type="submit" class="btn btn-success mt-1">Send</button>
                            </form>
                        @else
                            <span>
                                No messages found
                                <a class="mx-2" href="{{ route('admin.chat.new.message', 'type=' . Crypt::encrypt('employee')) }}"><i
                                        class="fa fa-plus"></i> Please Start Chating
                                    here..</a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Hide the users list content by default
            $('.users-list-content').hide();
        
            // Toggle users list content and rotate icon when clicking on the header
            $('.users-list h5').click(function() {
                $('.users-list-content').slideToggle();
                $(this).find('.toggle-icon').toggleClass('rotate');
            });
        });
        </script>
        
        <!-- Include Font Awesome CSS if not already included -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection
