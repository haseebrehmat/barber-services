<div class="modal fade" id="add_to_cart" tabindex="-1" aria-labelledby="add_to_cartLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('front.add_to_cart') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_to_cartLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0 pt-1">
                    @csrf
                    <input type="hidden" name="product_id">
                    <div class="form-group">
                        <label>Select Quantity</label>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-danger" type="button" id="minus-qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" class="form-control text-center" name="product_count"
                                        value="1" min="1" step="1" inputmode="numeric">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success" type="button" id="plus-qty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="product-unit-price d-none"></div>
                                <div class="d-inline-flex">
                                    USD
                                    <div class="product-price ml-3 h4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="product_variant_options" class="form-group"></div>
                    <div id="modifiers_list" class="form-group"></div>
                </div>
                <div class="modal-footer cart-button px-2">
                    <button type="submit" class="add-to-cart">
                        <i class="fas fa-shopping-bag mr-1"></i>
                        Add To Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.add-to-cart-btn').click(function() {
        const product = $(this).data('product');
        console.log(product);
        const variant = product?.variant;
        const modifiers = product?.modifiers;

        $("#add_to_cart input[name='product_id']").val(product?.id);
        $("#add_to_cart .modal-title").text(`${product?.product_name}`);

        var product_price = product?.product_current_price;
        if (variant) {
            var product_opts = Object.values(product?.variant_options)
            if (product_opts.length > 0) {
                product_price = product_opts[0];
            }
        }

        $("#add_to_cart .product-price").text(`${product_price}`);
        $("#add_to_cart .product-unit-price").text(`${product_price}`);
        $("#add_to_cart input[name='product_count']").attr('max', `${product?.product_stock}`);

        if (variant) {
            $('#add_to_cart #product_variant_options').empty();
            $("#add_to_cart #product_variant_options").append(
                `<span class="h5">Choose Variant - ${variant?.name}</span>`);
            $("#add_to_cart #product_variant_options").append(`<hr class="my-1">`);

            variant?.options?.map(function(i, index) {
                var checked = index <= 0;
                var option = $('<div class="form-check align-items-center mb-1 ml-1">' +
                    '<input ' + (checked ? 'checked' : '') +
                    ' class="form-check-input" type="radio" name="variant" required id="inlineRadio' +
                    i + '" value="' + i + '" data-price="' + product?.variant_options[i] + '">' +
                    '<label class="form-check-label ml-1" for="inlineRadio' + i + '">' + i +
                    ' (USD ' +
                    product?.variant_options[i] + ')</label>' +
                    '</div>');
                $('#add_to_cart #product_variant_options').append(option);
            })
        } else {
            $('#add_to_cart #product_variant_options').empty();
        }

        if (modifiers?.length > 0) {
            $('#add_to_cart #modifiers_list').empty();
            $("#add_to_cart #modifiers_list").append(`<span class="h5">Select Modifiers</span>`);
            $("#add_to_cart #modifiers_list").append(`<hr class="my-1">`);

            modifiers?.map(function(mod) {
                var option = $('<div class="d-flex align-items-center mb-1 ml-1">' +
                    '<input type="checkbox" name="products_modifiers[]" value="' +
                    mod?.id + '">' +
                    '<label class="form-check-label ml-1">' + mod?.name + ' (USD ' + mod
                    ?.unit_price +
                    ')' + '</label>' +
                    '</div>');
                $('#add_to_cart #modifiers_list').append(option);
            })
        } else {
            $('#add_to_cart #modifiers_list').empty();
        }

        $("#add_to_cart").modal('show');

        $("#add_to_cart input[name='variant']").change(function(e) {
            const _qty = $("#add_to_cart input[name='product_count']").val();
            const _price = $(this).data("price");
            $("#add_to_cart .product-unit-price").text(`${_price}`);
            $("#add_to_cart .product-price").text(_qty * _price);
        });

        var qty = 1;
        $("#add_to_cart input[name='product_count']").val(qty);

        $("#add_to_cart #plus-qty").click(function() {
            qty++;
            $("#add_to_cart input[name='product_count']").val(qty);
            var unit_price = parseInt($("#add_to_cart .product-unit-price").text())
            $("#add_to_cart .product-price").text(unit_price * qty)
        });

        $("#add_to_cart #minus-qty").click(function() {
            if (qty > 1) {
                qty--;
                $("#add_to_cart input[name='product_count']").val(qty);
                var unit_price = parseInt($("#add_to_cart .product-unit-price").text())
                $("#add_to_cart .product-price").text(unit_price * qty)
            }
        });
    });
</script>
