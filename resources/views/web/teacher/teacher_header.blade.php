<div class="topbar-Section">
    <i class="fa-solid fa-address-book">
        <span class="topbar-text">{{ $teacherDetail->appStatus_txt }}</span>
    </i>
    <i class="fa-solid fa-users">
        <span class="topbar-text">{{ $teacherDetail->ageRangeSpecialism_txt }}</span>
    </i>
    <i class="fa-brands fa-black-tie">
        <span class="topbar-text">{{ $teacherDetail->professionalType_txt }}</span>
    </i>
    <a style="cursor: pointer;" onclick="addteacherFab('{{ $teacherDetail->teacher_id }}')">
        <i class="fa-solid fa-star topbar-star-icon"></i>
    </a>

    <a href="{{ URL::to('/teacher-calendar-list/' . $teacherDetail->teacher_id) }}">
        <i class="fa-regular fa-calendar-days">
            <span class="topbar-text">Calendar</span>
        </i>
    </a>

    <a href="#">
        <i class="fa-solid fa-trash trash-icon"></i>
    </a>
</div>

<script>
    function addteacherFab(teacher_id) {
        // alert(teacher_id)
    }
</script>
