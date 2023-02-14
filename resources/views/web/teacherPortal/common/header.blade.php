@php
    $teacherLoginData = Session::get('teacherLoginData');
@endphp
<div class="container-fluid dashboard-tab-section">
    <!-- <div class="container"> -->

    <!-------HEADER LOGO----------->

    <div class="header-user-profile-sec">
        <div class="header-logo">
            <img src="{{ asset($teacherLoginData->company_logo) }}" alt="">
            <span>
                @if ($teacherLoginData && isset($teacherLoginData->company_name))
                    {{ $teacherLoginData->company_name }}
                @endif
            </span>
        </div>
        @if ($teacherLoginData)
            <div class="user-name-sec">
                <i class="fa-solid fa-user"></i><span>{{ $teacherLoginData->firstName_txt }}
                    {{ $teacherLoginData->surname_txt }}</span>
            </div>
        @endif
    </div>

    {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item @if ($headerTitle == 'Teachers') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/teacher/detail') }}">
                <i class="fa-solid fa-person-chalkboard">
                    <span class="tab-section-text">Teachers</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Logout') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/teacher/logout') }}">
                <i class="fa-solid fa-arrow-right-from-bracket">
                    <span class="tab-section-text">Logout</span>
                </i>
            </a>
        </li>
    </ul> --}}

    <!-- </div> -->
</div>
