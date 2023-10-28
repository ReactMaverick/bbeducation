@php
    $webUserLoginData = Session::get('webUserLoginData');
@endphp

<nav class="main-header skd_header navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item">
            <div class="hamberger_icon">
                <div class="hamburger" id="hamburger-6">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </div>
            </div>
            <div class="fill_menu_bar">
                <ul class="skd_menu">
                    <li class="skd_list">
                        <a href="{{ URL::to('/dashboard') }}"
                            class="skd_item @if ($headerTitle == 'Dashboard') skd_active @endif">Home</a>
                    </li>
                    <li class="skd_list">
                        <a href="{{ URL::to('/assignments?include=') }}"
                            class="skd_item @if ($headerTitle == 'Assignments') skd_active @endif">Assignments</a>
                    </li>
                    <li class="skd_list">
                        <a href="{{ URL::to('/candidates') }}"
                            class="skd_item @if ($headerTitle == 'Teachers') skd_active @endif">Teachers</a>
                    </li>
                    <li class="skd_list">
                        <a href="{{ URL::to('/schools') }}"
                            class="skd_item @if ($headerTitle == 'Schools') skd_active @endif">Schools</a>
                    </li>
                    <li class="skd_list">
                        <a href="{{ URL::to('/finance') }}"
                            class="skd_item @if ($headerTitle == 'Finance') skd_active @endif">Finance</a>
                    </li>
                    <li class="skd_list">
                        <a href="{{ URL::to('/management') }}"
                            class="skd_item @if ($headerTitle == 'Management') skd_active @endif">Management</a>
                    </li>
                </ul>
            </div>

        </li>


        <li class="user_log">
            <a class="log_item" href="#">
                <div class="image skd_user_img elevation-2 img-circle">
                    <img src="{{ asset('web/images/user-img.png') }}" class="img-fluid" alt="">
                </div>
                <span
                    class="mob_dp_none">{{ $webUserLoginData->firstName_txt . ' ' . $webUserLoginData->surname_txt }}</span>
            </a>
            <ul class="dropdown">
                <li><a href="{{ URL::to('/logout') }}">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-log-in">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                        </span>Logout</a>
                </li>

            </ul>
        </li>
    </ul>


</nav>

<script>
    $(document).ready(function() {
        $(".hamburger").click(function() {
            $(this).toggleClass("is-active");
            $(".skd_menu").toggleClass("active_menu");
            // #(".skd_menu").toggleClass("active_menu");
        });
    });
</script>
