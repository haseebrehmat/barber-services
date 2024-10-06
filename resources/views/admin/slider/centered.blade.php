<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #1cc88a;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #1cc88a;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .text-bold {
        font-weight: 700;
    }
</style>

<div class="d-flex">
    <label class="switch mb-3">
        <input type="checkbox" name='centered' @if (isset($centered) && $centered) checked @endif>
        <span class="slider"></span>
    </label>
    <span class="mx-2 p-1 mt-1 text-bold">Check if you want to align the items to the center of slider?</span>
</div>


