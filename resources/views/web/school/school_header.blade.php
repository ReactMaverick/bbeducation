<div class="topbar-Section">
    <div class="menu_item">
        <i class="fas fa-users"></i>
        <span class="topbar-text">{{ $schoolDetail->ageRange_txt }}</span>
    </div>

    <div class="menu_item">
        <i class="fas fa-school"></i>
        <span class="topbar-text">{{ $schoolDetail->type_txt }}</span>
    </div>

    <div class="menu_item">
        <i class="fas fa-list-ul"></i>
        <span class="topbar-text">{{ $schoolDetail->laName_txt }}</span>
    </div>

    <div class="menu_item">
        <i class="fas fa-flag"></i>
        <span class="topbar-text">{{ $schoolDetail->religion_txt }}</span>
    </div>

    <div class="menu_item">
        <a style="cursor: pointer;" onclick="hAddSchoolFab('{{ $school_id }}')">
            <i class="fas fa-star {{ $schoolDetail->favourite_id ? 'topbar-star-icon' : '' }}"></i>
        </a>
    </div>

    <div class="menu_item">
        <a href="{{ URL::to('/school-calendar/' . $school_id) }}">
            <i class="fas fa-calendar-alt"></i>
            <span class="topbar-text">calendar</span>
        </a>
    </div>
</div>

<script>
    function hAddSchoolFab(school_id) {
        $.ajax({
            type: 'POST',
            url: '{{ url('schoolHeaderFabAdd') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                school_id: school_id
            },
            async: false,
            success: function(data) {
                location.reload();
            }
        });
    }
</script>
