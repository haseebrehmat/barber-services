<div class="modal fade" id="submenu-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <div class="p-2">
                        <form action="{{route('admin.submenu.add')}}" method="post" id="submenu-form-{{$row->id}}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{$row->id}}">
                            @php
                            $subMenuOptions = array_filter($options, function($item) use ($row) {
                            return $item['id'] != $row->id;
                            });
                            @endphp
                            <label>Select Menu Item to add as submenu</label>
                            <select class="form-control" name="child_id">
                                @foreach ($subMenuOptions as $option)
                                <option value="{{$option['id']}}">{{$option['menu_name']}}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    @if (count($row->sub_menu) > 0)
                    <div class="mt-2 p-2">
                        <h5>Sub Menu Items</h5>
                        @foreach($row->sub_menu as $sub)
                        <form action="{{ route('admin.submenu.remove', $sub->id) }}" method="post" class="px-2 py-1 my-2 border border-2 d-flex justify-content-between align-items-center">
                            @csrf
                            @method('DELETE')
                            <span>{{ $sub->menu_name }}</span>
                            <button class="btn btn-sm btn-danger btn-circle" type="button" onclick="$(form).submit()">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="$('#submenu-form-{{$row->id}}').submit()">Save changes</button>
            </div>
        </div>
    </div>
</div>
