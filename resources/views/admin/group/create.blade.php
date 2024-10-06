<div class="modal fade" id="create_group" tabindex="-1" role="dialog" aria-labelledby="create_groupLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_groupLabel">Create Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.group.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Group name"
                            value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" rows="3" class="form-control" placeholder="Add Group detail">{{ old('detail') }}</textarea>
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
