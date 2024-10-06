<div class="modal fade" id="edit_group" tabindex="-1" role="dialog" aria-labelledby="edit_groupLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_groupLabel">Edit Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Group name">
                    </div>
                    <div class="form-group">
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" rows="3" class="form-control" placeholder="Add Group detail"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right float-right">Update</button>
                        <button type="button" class="btn float-right" data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.edit-group-btn').click(function() {

        // Set values to form and its inputs
        $("#edit_group form").attr('action', $(this).data('url'));
        $("#edit_group input[name='name']").val($(this).data('name'));
        $("#edit_group textarea[name='detail']").val($(this).data('detail'));

        // Show modal
        $("#edit_group").modal('show');
    });
</script>
