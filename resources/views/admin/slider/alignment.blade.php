<style>
    input[name="alignment"] {
        height: 20px;
    }
</style>
<div class="form-group">
    <label for="">Slider Content Alignment</label>
    <div class="row">
        <span class="d-flex align-items-center justify-content-center col-md-1">
            <input type="radio" name="alignment" class="form-control form-control-sm" value="center"
                @if($alignment=="center" ) checked @endif> Center
        </span>
        <span class="d-flex align-items-center justify-content-center col-md-1">
            <input type="radio" name="alignment" class="form-control form-control-sm" value="left"
                @if($alignment=="left" ) checked @endif> Left
        </span>
        <span class="d-flex align-items-center justify-content-center col-md-1">
            <input type="radio" name="alignment" class="form-control form-control-sm" value="right"
                @if($alignment=="right" ) checked @endif> Right
        </span>
    </div>
</div>
