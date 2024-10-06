<style>
    .select-modifier {
        letter-spacing: 2px;
        font-size: 18px;
    }

    .modifier-img {
        object-fit: contain;
    }
</style>
<div class="modal fade" id="add_modifier" tabindex="-1" aria-labelledby="add_modifierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title my-0 h5" id="add_modifierLabel">Select Modifiers</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('modifier.add_to_cart') }}" method="post">
                    @csrf
                    <input type="hidden" name="modifier_ids" id="modifiers">
                    <div class="row row-cols-1 row-cols-md-4 row-cols-lg-5">
                        @foreach ($modifiers as $row)
                            <div class="col mb-2">
                                <div class="card">
                                    @if (isset($row->thumbnail) && file_exists(public_path('uploads/') . $row->thumbnail))
                                        <img src="{{ asset('public/uploads/' . $row->thumbnail) }}" alt="Modifier"
                                            class="card-img-top modifier-img" height="150">
                                    @else
                                        <img src="http://via.placeholder.com/640x360?text={{ isset($row->name) ? str_replace(' ', '+', $row->name) : 'Modifier+Thumbnail' }}"
                                            alt="Modifier" class="card-img-top" height="150">
                                    @endif
                                    <div class="card-body text-center px-2 py-2">
                                        <span class="font-weight-bold">{{ Str::limit(ucwords($row->name), 20, '...') }}</span>
                                        <p class="card-text">USD {{ $row->unit_price }}</p>
                                        <a href="javascript:;"
                                            class="btn {{ in_array($row->id, $session_modifiers) ? 'btn-success' : 'btn-info' }} btn-block rounded-pill select-modifier py-1"
                                            data-id="{{ $row->id }}">
                                            {{ in_array($row->id, $session_modifiers) ? 'Unselect' : 'Select' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="cart-button text-center">
                        <button type="submit" class="px-5" style="width: fit-content;">Add Modifiers To Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var selectedModifiers = {!! json_encode($session_modifiers) !!};

        $('.select-modifier').click(function() {
            // Toggle Class
            $(this).toggleClass("btn-info btn-success");
            // Toggle Text
            var newText = $(this).hasClass("btn-info") ? "Select" : "Unselect";
            $(this).text(newText);
            // Toggle Values
            var dataId = $(this).data("id");
            if (!selectedModifiers?.includes(dataId?.toString())) {
                selectedModifiers.push(dataId?.toString());
            } else {
                selectedModifiers = selectedModifiers.filter(function(id) {
                    return id != dataId;
                });
            }
            $("#modifiers").val(selectedModifiers?.join(','));
        });
    });
</script>
