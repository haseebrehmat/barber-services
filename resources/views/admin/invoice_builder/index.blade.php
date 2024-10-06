@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Invoices</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Invoices</h6>
            <div class="float-right d-inline">
                <a href="{{ route('invoice-builder.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                    New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice Number</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Issue Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->number }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span> {{ $row->client_name ?? 'No name' }}</span>
                                        <span> {{ $row->client_email ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge @if ($row->status == 'paid') badge-success @elseif ($row->status == 'unpaid') badge-danger @else badge-secondary @endif">{{ ucwords($row->status) }}</span>
                                </td>
                                <td>{{ $row->issue_date }}</td>
                                <td>
                                    <a href="{{ route('invoice-builder.edit', ['invoice_builder' => $row->id]) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{ URL::to('admin/invoice-builder/delete/' . $row->id) }}"
                                        class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i
                                            class="fas fa-trash-alt"></i></a>
                                    <form action="{{ route('invoice-builder.get_invoice') }}" method="post" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-arrow-alt-circle-down">Invoice</i>
                                        </button>
                                    </form>
                                    <form action="{{ route('invoice-builder.thermal_invoice') }}" method="post" class="d-inline" target="_blank">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                        <button type="submit" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-arrow-down"></i> Thermal Print
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
