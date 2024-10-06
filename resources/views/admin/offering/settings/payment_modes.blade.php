<div class="p-lg-1">
    <h5>Enable / Disable Payment Modes</h5>
    <form action="{{ route('admin.offering.update_settings', ['type' => 'payment_modes']) }}" method="post">
        @csrf
        <div class="row p-2">
            <div class="col-md-6">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Regular Service</p>
                    @forelse ($settings['regular_modes'] as $row)
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" name="payment_mode_ids[]" class="custom-control-input"
                                id="regular-mode-{{ $row->id }}" @if ($row->enabled) checked @endif
                                value="{{ $row->id }}">
                            <label class="custom-control-label"
                                for="regular-mode-{{ $row->id }}">{{ $row->method_name }}</label>
                        </div>
                    @empty
                        <small class="p-2">No regular service payment mode is added</small>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Appointment Service</p>
                    @forelse ($settings['appointment_modes'] as $row)
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" name="payment_mode_ids[]" class="custom-control-input"
                                id="appointment-mode-{{ $row->id }}"
                                @if ($row->enabled) checked @endif value="{{ $row->id }}">
                            <label class="custom-control-label"
                                for="appointment-mode-{{ $row->id }}">{{ $row->method_name }}</label>
                        </div>
                    @empty
                        <small class="p-2">No regular service payment mode is added</small>
                    @endforelse
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
