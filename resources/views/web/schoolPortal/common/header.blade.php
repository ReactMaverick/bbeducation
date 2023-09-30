@php
    $schoolLoginData = Session::get('schoolLoginData');
    $commonLoginSchoolData = Session::get('commonLoginSchoolData');
@endphp

<nav class="main-header skd_header navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li> --}}
        <li class="user_log"><a class="log_item" href="#">
                <div class="image elevation-2 img-circle">
                    @if ($schoolDetail->profile_pic != null || $schoolDetail->profile_pic != '')
                        <img src="{{ asset($schoolDetail->profile_pic) }}" class="img-fluid" alt="">
                    @else
                        <img src="{{ asset('web/images/college.png') }}" class="img-fluid" alt="">
                    @endif
                </div>
                {{ $schoolLoginData ? $schoolLoginData->name_txt : '' }}
            </a>
            <ul class="dropdown">
                @if ($schoolLoginData && !$commonLoginSchoolData)
                    <li>
                        <a href="{{ URL::to('/school/change-password') }}">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                    </path>
                                </svg>
                            </span> Change Password
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/school/logout') }}">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <polyline points="10 17 15 12 10 7"></polyline>
                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                </svg>
                            </span>Logout
                        </a>
                    </li>
                @endif
                @if ($schoolLoginData && $commonLoginSchoolData)
                    <li>
                        <a href="{{ URL::to('/school/commonSchoolLogout') }}">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <polyline points="10 17 15 12 10 7"></polyline>
                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                </svg>
                            </span>Logout
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    </ul>

    <!-- Right navbar links -->
    {{-- <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <div class="header-user-profile-sec">
                <div class="user-name-sec dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" style="padding: 0;">
                        <i
                            class="fas fa-user-alt"></i><span>{{ $schoolLoginData ? $schoolLoginData->name_txt : '' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ URL::to('/school/change-password') }}">Change Password</a>
                        <a class="dropdown-item" href="{{ URL::to('/school/logout') }}">Logout</a>
                    </div>
                </div>
            </div>
        </li>
    </ul> --}}

</nav>
