<div class="modal fade" id="create_contact" tabindex="-1" role="dialog" aria-labelledby="create_contactLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_contactLabel">Create Group Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.group.contacts.store') }}">
                    @csrf
                    <input type="hidden" name="group_id">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="test" class="form-control" name="phone" placeholder="Enter phone">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right float-right">Save</button>
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
    $(document).ready(function() {
        $('.create-contact-btn').click(function() {

            // Set values to form and its inputs
            $("#create_contact input[name='group_id']").val($(this).data('id'));

            // Show modal
            $("#create_contact").modal('show');
        });
    });
</script>
