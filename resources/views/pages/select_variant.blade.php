<div class="modal fade" id="select_variant" tabindex="-1" aria-labelledby="select_variantLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('front.add_to_cart') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="select_variantLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="product_id">
                    <input type="hidden" name="product_qty" value="1">
                    <div id="variant_options" class="mx-1"></div>
                </div>
                <div class="modal-footer cart-button px-2">
                    <button type="submit" class="add-to-cart" disabled>
                        <i class="fas fa-shopping-bag mr-1"></i>
                        Add To Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.select-variant-btn').click(function() {
        const variant = $(this).data('variant');
        if (variant) {
            $("#select_variant .modal-title").text(`Select ${variant?.name}`);
            $("#select_variant input[name='product_id']").val($(this).data('product_id'));

            $('#variant_options').empty();
            variant?.options?.map(function(i) {
                var option = $('<div class="form-check mb-2">' +
                    '<input class="form-check-input" type="radio" name="variant" required id="inlineRadio' +
                    i + '" value="' + i + '">' +
                    '<label class="form-check-label" for="inlineRadio' + i + '">' + i + '</label>' +
                    '</div>');
                $('#variant_options').append(option);
            })

            $("#select_variant input[name='email']").val($(this).data('email'));
            // Show modal
            $("#select_variant").modal('show');
        }

        $("input[name='variant']").change(function (e) {
            e.preventDefault();
            $(".add-to-cart").removeAttr("disabled");
        });
    });
</script>
