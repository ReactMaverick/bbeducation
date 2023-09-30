@php
    $webUserLoginData = Session::get('webUserLoginData');
@endphp

<nav class="main-header skd_header navbar-expand navbar-white navbar-light sidebar_none">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ URL::to('/dashboard') }}" class="brand-link skd_logo">
                <img src="{{ asset($webUserLoginData->company_logo) }}" alt=""
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light mob_dp_none">
                    @if ($webUserLoginData && isset($webUserLoginData->company_name))
                        {{ $webUserLoginData->company_name }}
                    @endif
                </span>
            </a>
        </li>
        <li class="nav-item">
            <div class="fill_menu_bar">
                <div class="hamberger_icon">
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>

                </div>
                <ul class="skd_menu">
                    <li class="skd_list">
                        <a href="#" class="skd_item skd_active">Home</a>
                    </li>
                    <li class="skd_list">
                        <a href="#" class="skd_item">Assignments</a>
                    </li>
                    <li class="skd_list">
                        <a href="#" class="skd_item">Teachers</a>
                    </li>
                    <li class="skd_list">
                        <a href="#" class="skd_item">Schools</a>
                    </li>
                    <li class="skd_list">
                        <a href="#" class="skd_item">Finance</a>
                    </li>
                    <li class="skd_list">
                        <a href="#" class="skd_item">Management</a>
                    </li>
                    <li class="skd_list">
                        <a href="#" class="skd_item">Contact</a>
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
