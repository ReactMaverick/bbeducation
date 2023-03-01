@php
    $schoolLoginData = Session::get('schoolLoginData');
@endphp
<div class="container-fluid dashboard-tab-section">
    <!-- <div class="container"> -->

    <!-------HEADER LOGO----------->

    <div class="header-user-profile-sec">
        <div class="header-logo">
            <img src="{{ asset($schoolLoginData->company_logo) }}" alt="">
            <span>
                @if ($schoolLoginData && isset($schoolLoginData->company_name))
                    {{ $schoolLoginData->company_name }}
                @endif
            </span>
        </div>

        <div class="user-name-sec dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                aria-expanded="false" style="padding: 0; color: #fff;">
                <i class="fa-solid fa-user"></i><span>{{ $schoolLoginData ? $schoolLoginData->name_txt : '' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ URL::to('/school/change-password') }}">Change Password</a>
                <a class="dropdown-item" href="{{ URL::to('/school/logout') }}">Logout</a>
            </div>
        </div>

    </div>

    <!-- </div> -->
</div>
