<style>
    .modifier-img {
        object-fit: contain;
    }
</style>
<div class="modal fade" id="edit_modifier_qtys" tabindex="-1" aria-labelledby="edit_modifier_qtysLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title my-0 h5" id="edit_modifier_qtysLabel">Edit Modifiers Quantities</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('modifier.update_qtys') }}" method="post">
                    @csrf
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mb-3">
                        @foreach ($selected_modifiers as $row)
                            <div class="col mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if (isset($row->thumbnail) && file_exists(public_path('uploads/') . $row->thumbnail))
                                            <img src="{{ asset('public/uploads/' . $row->thumbnail) }}" alt="Modifier"
                                                class="card-img-top modifier-img" height="95">
                                        @else
                                            <img src="http://via.placeholder.com/640x360?text={{ isset($row->name) ? str_replace(' ', '+', $row->name) : 'Modifier+Thumbnail' }}"
                                                alt="Modifier" class="card-img-top" height="95">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="font-weight-bold">
                                                {{ Str::limit(ucwords($row->name), 20, '...') }}
                                            </span>
                                            <span>(USD {{ $row->unit_price }})</span>
                                            <input type="number" class="form-control"
                                                name="modifier_qtys[{{ $row->id }}]" step="1" min="1"
                                                max="" pattern="" pattern="[0-9]*" inputmode="numeric"
                                                value="{{ isset($session_modifier_qtys[$row->id]) ? $session_modifier_qtys[$row->id] : 1 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="cart-button text-center">
                        <button type="submit" class="px-5" style="width: fit-content;">Update Modifiers
                            Quantities</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {});
</script>
