@extends('admin.admin_layouts')

@section('admin_content')
    <div class="alert alert-danger">
        Your package has expired. Please <a href="{{ url('/admin/plan_payment') }}">click here</a> to see your billing details or to renew your package.
    </div>
@endsection
