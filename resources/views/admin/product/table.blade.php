<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>SL</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td><img src="{{ asset('public/uploads/'.$row->product_featured_photo) }}" alt="" class="w_150"></td>
            <td>{{ $row->product_name }}</td>
            <td>{{ $row->productCategory->name ?? 'Not Categorized' }}</td>
            <td>
                <a href="{{ URL::to('admin/product/edit/'.$row->id) }}" class="btn btn-warning btn-sm"><i
                        class="fas fa-edit"></i></a>
                <a href="{{ URL::to('admin/product/delete/'.$row->id) }}" class="btn btn-danger btn-sm"
                    onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                @if (isset($row->variant))
                    <a href="{{ route('admin.product.variants', ['product' => $row]) }}" class="btn btn-outline-dark btn-sm">
                        <i class="fas fa-cog"></i> Update Variants
                    </a>
                @else
                    <a href="{{ route('admin.product.variants', ['product' => $row]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-cog"></i> Add Variants
                    </a>
                @endif
                <a href="{{ route('admin.product.modifiers', ['product' => $row]) }}" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-list-alt"></i>
                    Modifiers {{ sizeOf($row->modifiers) > 0 ? '(' . $row->modifiers->count(). ')' : null }}
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
