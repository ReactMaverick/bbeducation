<div class="container-fluid dashboard-tab-section">
    <!-- <div class="container"> -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item @if ($headerTitle == 'Dashboard') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/dashboard') }}" ><i class="fa-solid fa-house-chimney">Home</i></a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Assignments') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/assignments') }}"><i class="fa-solid fa-id-card">assignments</i></a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Teachers') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/teachers') }}"><i
                    class="fa-solid fa-person-chalkboard">Teachers</i></a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Schools') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/schools') }}"><i class="fa-solid fa-school">Schools</i></a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Finance') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/finance') }}"><i class="fa-solid fa-money-bills">Finance</i></a>
        </li>
        <li class="nav-item @if ($headerTitle == 'Management') header-active @endif ">
            <a class="nav-link" href="{{ URL::to('/management') }}"><i class="fa-solid fa-person">Management</i></a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-gear">Settings</i></a>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ URL::to('/profile') }}">Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                </div>
        </li>
    </ul>

    <!-- </div> -->
</div>