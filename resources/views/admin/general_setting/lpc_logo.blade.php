<div class="form-group">
    <label for="">Existing Logo</label>
    <div>
        <img src="{{ isset($general_setting->lpc_logo) ? asset('public/uploads/' . $general_setting->lpc_logo) : 'https://placehold.co/400' }}"
            alt="" class="w_200">
    </div>
</div>

<div class="form-group">
    <label for="">Change Logo</label>
    <div>
        <input type="file" name="lpc_logo">
    </div>
</div>

<div class="row my-3">
    <div class="col-md-6">
        <div class="border p-2">
            <h5>Mobile</h5>

            <label for="text">Logo Mobile Width</label>
            <input name="lpc_logo_mobile_width" type="number" id="text"
                value="{{ $general_setting->lpc_logo_mobile_width }}" class="form-control form-control-sm">

            <label for="text" class="mt-2">Logo Mobile Height</label>
            <input name="lpc_logo_mobile_height" type="number" id="text"
                value="{{ $general_setting->lpc_logo_mobile_height }}" class="form-control form-control-sm">
        </div>
    </div>

    <div class="col-md-6">
        <div class="border p-2">
            <h5>PC</h5>

            <label for="text">Logo PC Width</label>
            <input name="lpc_logo_pc_width" type="number" id="text"
                value="{{ $general_setting->lpc_logo_pc_width }}" class="form-control form-control-sm">

            <label for="text" class="mt-2">Logo Pc Height</label>
            <input name="lpc_logo_pc_height" type="number" id="text"
                value="{{ $general_setting->lpc_logo_pc_height }}" class="form-control form-control-sm">
        </div>
    </div>
</div>
