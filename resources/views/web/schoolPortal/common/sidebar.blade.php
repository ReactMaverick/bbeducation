@php
    $schoolLoginData = Session::get('schoolLoginData');
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ URL::to('/school/detail') }}" class="brand-link">
        <img src="{{ asset($schoolLoginData->company_logo) }}" alt="" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            @if ($schoolLoginData && isset($schoolLoginData->company_name))
                {{ $schoolLoginData->company_name }}
            @endif
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ URL::to('/school/detail') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'School Detail') active @endif">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Details
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('/school/finance?include=&method=') }}"
                        class="nav-link @if ($pagetitle['pageTitle'] == 'School Finance') active @endif">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Finance
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @if ($schoolDetail->profile_pic != null || $schoolDetail->profile_pic != '')
                <img src="{{ asset($schoolDetail->profile_pic) }}" class="img-circle elevation-2" alt="">
            @else
                <img src="{{ asset('web/images/college.png') }}" class="img-circle elevation-2" alt="">
            @endif
        </div>
        <div class="info">
            <a href="javascript:void(0)" class="d-block">
                {{ $schoolDetail->name_txt }}
            </a>
        </div>
    </div>
</aside>
