<div class="topbar-Section">
    <i class="fa-solid fa-users">
        <span class="topbar-text">{{ $schoolDetail->ageRange_txt }}</span>
    </i>
    <i class="fa-solid fa-school">
        <span class="topbar-text">{{ $schoolDetail->type_txt }}</span>
    </i>
    <i class="fa-solid fa-list-ul">
        <span class="topbar-text">{{ $schoolDetail->laName_txt }}</span>
    </i>
    <i class="fa-solid fa-flag">
        <span class="topbar-text">{{ $schoolDetail->religion_txt }}</span>
    </i>
    <a style="cursor: pointer;" onclick="hAddSchoolFab('{{ $school_id }}')">
        <i class="fa-solid fa-star {{ $schoolDetail->favourite_id ? 'topbar-star-icon' : '' }}"></i>
    </a>

    <a href="{{ URL::to('/school-calendar/' . $school_id) }}">
        <i class="fa-regular fa-calendar-days">
            <span class="topbar-text">calendar</span>
        </i>
    </a>
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
