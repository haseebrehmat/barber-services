<div class="col-3">
    <ul class="nav flex-column nav-pills border border-success p-3" id="myTab" role="tablist">
        @foreach ($groups as $row)
            @php
                $isActive = $active_group_id == $row->id || ($loop->first && !$active_group_id);
            @endphp
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $isActive ? 'active' : '' }}" aria-selected="{{ $isActive ? 'true' : 'false' }}"
                    href="{{ route('admin.group.contacts', ['group_id' => $row->id]) }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ $row->name }}</span>
                        <strong style="font-size: 20px;">{{ $row->contacts_count }}</strong>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
