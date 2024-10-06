<div class="modal fade" id="product-category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Product Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <div class="p-2">
                        <form action="{{route('admin.product_category.store')}}" method="post" id="product-category-form">
                            @csrf
                            <div class="form-group">
                                <label for="">Name *</label>
                                <input type="text" name="name" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"
                    onclick="$('#product-category-form').submit()">Save</button>
            </div>
        </div>
    </div>
</div>
