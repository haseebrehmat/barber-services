<div class="p-lg-1">
    <h5>Update Shop Opening / Closing Timings</h5>
    <form action="{{ route('admin.offering.update_settings', ['type' => 'timings']) }}" method="post">
        @csrf
        <div class="row p-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="openingtimeSelect">Select Opening Time (24-hour format): </label>
                    <select id="openingtimeSelect" class="form-control select2" name="shop_open_time">
                        @for ($hour = 1; $hour <= 23; $hour++)
                            @php
                                $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                            @endphp
                            <option value="{{ $formattedHour }}" @if ($general_settings_global->shop_open_time == $formattedHour) selected @endif>
                                {{ $formattedHour }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="closingtimeSelect">Select Closing Time (24-hour format): </label>
                    <select id="closingtimeSelect" class="form-control select2" name="shop_close_time">
                        @for ($hour = 1; $hour <= 23; $hour++)
                            @php
                                $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                            @endphp
                            <option value="{{ $formattedHour }}" @if ($general_settings_global->shop_close_time == $formattedHour) selected @endif>
                                {{ $formattedHour }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Shop Serveice Interval: </label>
                    <input type="number" name="shop_service_interval" min="1" max="59"
                        value="{{ $general_settings_global->shop_service_interval }}" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary rounded-pill float-right px-5" type="submit">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap",
        });
    });
</script>
