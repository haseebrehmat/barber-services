@extends('admin.admin_layouts')
@section('admin_content')
<h1 class="h3 mb-3 text-gray-800">Edit Color Information</h1>

<form action="{{ url('admin/setting/general/color/update') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Theme Color</label>
                        <input type="text" name="theme_color" class="form-control jscolor"
                            value="{{ $general_setting->theme_color }}">
                    </div>
                    <div class="form-group">
                        <label for="">Navbar Color (Background of Menu and Logo)</label>
                        <input type="text" name="navbar_color" class="form-control jscolor"
                            value="{{ $general_setting->navbar_color }}">
                    </div>
                    <div class="form-group">
                        <label for="">Navbar Items Color (Text Color of Menu Items)</label>
                        <input type="text" name="items_color" class="form-control jscolor"
                            value="{{ $general_setting->items_color }}">
                    </div>
                    <div class="form-group">
                        <label for="">Navbar Items Hover Color (Text Color of Menu Items on hovering them)</label>
                        <input type="text" name="items_hover_color" class="form-control jscolor"
                            value="{{ $general_setting->items_hover_color }}">
                    </div>
                    <div class="form-group">
                        <label for="">Navbar Sub Menu (Background Color of Menu Sub Items)</label>
                        <input type="text" name="sub_items_bg_color" class="form-control jscolor"
                            value="{{ $general_setting->sub_items_bg_color }}">
                    </div>
                    <div class="form-group">
                        <label for="">Navbar Sub Menu on Hover (Background Color of Menu Sub Items on hovering them)</label>
                        <input type="text" name="sub_items_hover_bg_color" class="form-control jscolor"
                            value="{{ $general_setting->sub_items_hover_bg_color }}">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
