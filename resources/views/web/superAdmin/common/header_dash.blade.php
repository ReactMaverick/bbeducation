@php
    $webUserLoginData = Session::get('superadmin');
@endphp

<nav class="main-header skd_header navbar-expand navbar-white navbar-light sidebar_none">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            {{-- <a href="{{ URL::to('/dashboard') }}" class="brand-link skd_logo">
                <img src="{{ asset($webUserLoginData->company_logo) }}" alt=""
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light mob_dp_none">
                    @if ($webUserLoginData && isset($webUserLoginData->company_name))
                        {{ $webUserLoginData->company_name }}
                    @endif
                </span>
            </a> --}}
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
                        <a href="{{ URL::to('/all-company') }}"
                            class="skd_item @if ($headerTitle == 'Dashboard') skd_active @endif">Home</a>
                    </li>
                    <div class="sb_new_navbar">
                        <li class="skd_list _hover_submenu_open">
                            <a href="javascript:void(0)"
                                class="skd_item submnu_btn @if ($headerTitle == 'Assignment Section' || $headerTitle == 'School Section' || $headerTitle == 'Teacher Section') skd_active @endif">System
                                Preferences<i class="plus"></i> </a>
                            <div class="submenu_new">
                                <ul class="submenu_ul">
                                    <li class="skd_list">
                                        <a class="skd_item" href="{{ URL::to('/system-assignment') }}">Assignment
                                            Section</a>
                                    </li>
                                    <li class="skd_list">
                                        <a class="skd_item" href="{{ URL::to('/system-school') }}">School Section</a>
                                    </li>
                                    <li class="skd_list">
                                        <a class="skd_item" href="{{ URL::to('/system-teacher') }}">Teacher Section</a>
                                    </li>
                                </ul>
                            </div>

                        </li>
                    </div>

                </ul>
            </div>

        </li>




        <li class="user_log">
            <a class="log_item" href="#">
                <div class="image skd_user_img elevation-2 img-circle">
                    @if ($webUserLoginData->profileImage)
                        @if (File::exists(public_path($webUserLoginData->profileImageLocation_txt . '/' . $webUserLoginData->profileImage)))
                            <img src="{{ asset($webUserLoginData->profileImageLocation_txt . '/' . $webUserLoginData->profileImage) }}"
                                class="img-fluid" alt="">
                        @else
                            <img src="{{ asset('web/images/user-img.png') }}" class="img-fluid" alt="">
                        @endif
                    @else
                        <img src="{{ asset('web/images/user-img.png') }}" class="img-fluid" alt="">
                    @endif

                </div>
                <span
                    class="mob_dp_none">{{ $webUserLoginData->firstName_txt . ' ' . $webUserLoginData->surname_txt }}</span>
            </a>
            <ul class="dropdown">
                <li><a href="{{ URL::to('/system-logout') }}">
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
<script>
    $(document).ready(function() {
        var curentWindowWidth = window.innerWidth;
        console.log('curentWindowWidth - ', curentWindowWidth);
        $("._hover_submenu_open").click(function() {
            if (curentWindowWidth < 1024) {
                $(this).toggleClass("active_mnu");
                $(".submenu_new").toggleClass("activeSubmenu");
            }
        });
    });
</script>
