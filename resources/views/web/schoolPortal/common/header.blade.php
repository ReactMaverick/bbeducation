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
        @if ($schoolLoginData)
            <div class="user-name-sec">
                <i class="fa-solid fa-user"></i><span>{{ $schoolLoginData->name_txt }}</span>
            </div>
        @endif
    </div>

    <!-- </div> -->
</div>
