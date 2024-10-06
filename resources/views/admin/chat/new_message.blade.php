@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Compose Message</h1>

    <form action="{{ route('admin.chat.store') }}" method="post">
        @csrf
        <input type="hidden" name="type" value="{{ Crypt::encrypt($type) }}">
        <input type="hidden" name="sent_by" value="admin">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Chat</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.employees.chat') }}" class="btn btn-secondary btn-sm">Back To Chats</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Choose {{ $type == 'employee' ? 'Employee' : 'Customer' }} *</label>
                            <select name="{{ $type == 'employee' ? 'employee_id' : 'customer_id' }}" class="form-control">
                                @foreach ($users as $row)
                                    <option value="{{ $row->id }}">
                                        {{ ucwords($type == 'employee' ? $row->name : $row->customer_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Message *</label>
                            <textarea name="msg" class="form-control" placeholder="Start typing here..." cols="30" rows="10">{{ old('msg') }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Send</button>
            </div>
        </div>
    </form>
@endsection
