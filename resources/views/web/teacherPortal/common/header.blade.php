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

        <div class="user-name-sec dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                aria-expanded="false" style="padding: 0; color: #fff;">
                <i class="fa-solid fa-user"></i><span>{{ $teacherLoginData ? $teacherLoginData->firstName_txt : '' }}
                    {{ $teacherLoginData ? $teacherLoginData->surname_txt : '' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ URL::to('/candidate/change-password') }}">Change Password</a>
                <a class="dropdown-item" href="{{ URL::to('/candidate/logout') }}">Logout</a>
            </div>
        </div>

    </div>

    {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item @if ($headerTitle == 'Teachers') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/candidate/detail') }}">
                <i class="fa-solid fa-person-chalkboard">
                    <span class="tab-section-text">Teachers</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Logout') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/candidate/logout') }}">
                <i class="fa-solid fa-arrow-right-from-bracket">
                    <span class="tab-section-text">Logout</span>
                </i>
            </a>
        </li>
    </ul> --}}

    <!-- </div> -->
</div>
