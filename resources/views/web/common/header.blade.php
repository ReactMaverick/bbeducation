@php
    $webUserLoginData = Session::get('webUserLoginData');
@endphp
<div class="container-fluid dashboard-tab-section">
    <!-- <div class="container"> -->

    <!-------HEADER LOGO----------->

    <div class="header-user-profile-sec">
        <div class="header-logo">
            <img src="{{ asset($webUserLoginData->company_logo) }}" alt="">
            <span>
                @if ($webUserLoginData && isset($webUserLoginData->company_name))
                    {{ $webUserLoginData->company_name }}
                @endif
            </span>
        </div>
        @if ($webUserLoginData)
            <div class="user-name-sec">
                <i class="fa-solid fa-user"></i><span>{{ $webUserLoginData->firstName_txt }}
                    {{ $webUserLoginData->surname_txt }}</span>
            </div>
        @endif
    </div>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item @if ($headerTitle == 'Dashboard') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/dashboard') }}">
                <i class="fa-solid fa-house-chimney">
                    <span class="tab-section-text">Home</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Assignments') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/assignments?include=') }}">
                <i class="fa-solid fa-id-card">
                    <span class="tab-section-text">Assignments</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Teachers') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/teachers') }}">
                <i class="fa-solid fa-person-chalkboard">
                    <span class="tab-section-text">Teachers</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Schools') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/schools') }}">
                <i class="fa-solid fa-school">
                    <span class="tab-section-text">Schools</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Finance') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/finance') }}">
                <i class="fa-solid fa-money-bills">
                    <span class="tab-section-text">Finance</span>
                </i>
            </a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Management') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/management') }}">
                <i class="fa-solid fa-person">
                    <span class="tab-section-text">Management</span>
                </i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa-solid fa-gear">
                    <span class="tab-section-text">Settings</span>
                </i>
            </a>
            {{-- <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ URL::to('/profile') }}">Profile</a>
                <!-- <div class="dropdown-divider"></div> -->
            </div> --}}
        </li>
        <li class="nav-item @if ($headerTitle == 'Logout') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/logout') }}">
                <i class="fa-solid fa-arrow-right-from-bracket">
                    <span class="tab-section-text">Logout</span>
                </i>
            </a>
        </li>
    </ul>

    <!-- </div> -->
</div>
