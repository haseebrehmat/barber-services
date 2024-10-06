@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Menus</h1>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ url('admin/menu/update') }}" method="post">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">View Menus</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Menu Name</th>
                                        <th>Menu Status</th>
                                        <th width='200'>Sub Menu</th>
                                        <th width='40'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $row)
                                        <input type="hidden" name="menu_id[]" value="{{ $row->id }}">
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <input type="text" name="menu_name[]" value="{{ $row->menu_name }}"
                                                    class="form-control" required>
                                            </td>
                                            <td>
                                                <select name="menu_status[]" class="form-control">
                                                    <option value="Show"
                                                        @if ($row->menu_status == 'Show') selected @endif>Show</option>
                                                    <option value="Hide"
                                                        @if ($row->menu_status == 'Hide') selected @endif>Hide</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    @if ($row->parent_id == null)
                                                        <button class="btn btn-sm btn-info" type="button"
                                                            data-toggle="modal" data-target="#submenu-{{ $row->id }}">
                                                            See and Change
                                                        </button>
                                                    @endif
                                                    @if (count($row->sub_menu) > 0)
                                                        <div class="mt-1">
                                                            @foreach ($row->sub_menu as $sub)
                                                                <small
                                                                    class="p-1 m-1 border border-info border-3 d-inline-flex">{{ $sub->menu_name }}</small>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($row->fixed === 0)
                                                    <button class="btn btn-sm text-danger confirm-del-menu"
                                                        data-route="{{ url('admin/menu/remove/' . $row->id) }}"
                                                        type="button">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form action="{{ url('admin/menu/store') }}" method="post">
                @csrf
                <input type="hidden" name="fixed" value="0">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-success">New Menu Item</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Menu Key</label>
                            <input type="text" name="menu_key" class="form-control" value="{{ old('menu_key') }}">
                            <small>Menu Keys cannot be edited. You have to enter key(s) carefully</small>
                        </div>
                        <div class="form-group">
                            <label for="">Menu Name</label>
                            <input type="text" name="menu_name" class="form-control" value="{{ old('menu_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Menu Status</label>
                            <select name="menu_status" class="form-control">
                                <option value="Show">Show</option>
                                <option value="Hide">Hide</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Is External Link</label>
                            <input type="checkbox" name="link" id="is-link-checkbox">
                        </div>
                        <div class="form-group">
                            <label for="">Menu Route</label>
                            <input type="text" name="route" class="form-control" value="{{ old('route') }}" id="menu-route-input">
                        </div>
                        <script>
                            // JavaScript code to toggle the "Menu Route" text based on the checkbox
                            const isLinkCheckbox = document.getElementById("is-link-checkbox");
                            const menuRouteInput = document.getElementById("menu-route-input");
        
                            isLinkCheckbox.addEventListener("change", function () {
                                menuRouteInput.placeholder = this.checked ? "Enter Link here" : "";
                            });
                        </script>
                        <button type="submit" class="btn btn-sm btn-success btn-block">Add</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>

    {{-- Menu Delete Form --}}
    <form action="" method="post" id="del-menu-form">
        @csrf
        @method('DELETE')
    </form>

    {{-- To avoid main form submit and to load all modals --}}
    @foreach ($menus as $row)
        @include('admin.menu.submenu', ['row' => $row, 'option' => $options])
    @endforeach

    <script>
        $(document).ready(function() {
            $('.confirm-del-menu').click(function() {
                if (confirm('Are you sure delete this menu item?')) {
                    $('#del-menu-form').attr('action', $(this).data('route'));
                    $('#del-menu-form').submit();
                }
            });
        });
    </script>
@endsection
