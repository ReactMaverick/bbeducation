@extends('web.layout')
@section('content')
    <div class="assignment-section-col">

        <div class="teacher-all-section">
            <div class="finance-section">
                <div class="teacher-page-sec">
                    <h2>Management</h2>
                </div>
                <div class="teacher-left-sec">
                    {{-- <div class="about-finance">
                        <a href="{{ URL::to('/management-user') }}"> <i class="fa-solid fa-magnifying-glass"></i>
                            <p>Open Users</p>
                        </a>
                    </div> --}}

                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-user"></i>
                            <p>Manage Users</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a href="{{ URL::to('/management-mailshot') }}"> <i class="fa-solid fa-envelope"></i>
                            <p>Mailshots</p>
                        </a>
                    </div>
                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-people-group"></i>
                            <p>Students</p>
                        </a>
                    </div>

                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-gear"></i>
                            <p>Assignment</p>
                            <p>Rates</p>
                        </a>
                    </div>
                    {{-- <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-id-badge"></i>
                            <p>Delete Teacher</p>
                        </a>
                    </div>
                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-chart-line"></i>
                            <p>View Metrics</p>
                        </a>
                    </div>
                    <div class="about-finance">
                        <a href="#"> <i class="fa-solid fa-person"></i>
                            <p>Export to</p>
                            <p>Quickbooks</p>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
