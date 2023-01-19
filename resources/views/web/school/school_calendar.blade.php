@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')


                <div class="tab-content assignment-tab-content school-calandar">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="teacher-calendar-sidebar-section school-calendar-sidebar-section">
                                <div class="form-check sidebar-mode-check">
                                    <label for="html"><a href="#"><i class="fa-solid fa-desktop"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                                <div class="form-check sidebar-mode-check">
                                    <label for="html"><a href="#"><i
                                                class="fa-regular fa-calendar-days"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                                <div class="form-check sidebar-mode-check">
                                    <label for="html"><a href="#"><i
                                                class="fa-solid fa-graduation-cap"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                                <div class="form-check sidebar-mode-check">
                                    <label for="html"><a href="#"><i
                                                class="fa-solid fa-school-flag"></i></a></label>
                                    <input type="radio" id="html" name="fav_language" value="HTML">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-11">
                            <div class="teacher-calendar-slider">
                                <div class="teacher-calendar-table-section">
                                    <div class="total-days-slider-sec">
                                        <div class="total-days-text">
                                            <div class="assignment-date">
                                                <i class="fa-solid fa-caret-left"></i>
                                            </div>
                                            <div class="teacher-calendar-date-text">
                                                <span>Mon 28 November 2022</span>
                                            </div>
                                            <div class="assignment-date2">
                                                <i class="fa-solid fa-caret-right"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="teacher-calendar-days-sec school-calendar-days-sec">
                                        <div class="teacher-calendar-total-days-text school-calendar-total-days-text">
                                            {{-- <p>211 days total:</p> --}}
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Mon</p>
                                            {{-- <p class="teacher-calendar-bottom-text">41.46</p> --}}
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Tue</p>
                                            {{-- <p class="teacher-calendar-bottom-text">43.46</p> --}}
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Wed</p>
                                            {{-- <p class="teacher-calendar-bottom-text">43.46</p> --}}
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Thu</p>
                                            {{-- <p class="teacher-calendar-bottom-text">42.3</p> --}}
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Fri</p>
                                            {{-- <p class="teacher-calendar-bottom-text">40.3</p> --}}
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Sat</p>
                                        </div>
                                        <div class="teacher-calendar-days-text school-calendar-days-text">
                                            <p>Sun</p>
                                        </div>
                                    </div>

                                    <div class="calendar-section school-calendar-section">
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field3">
                                                <p>Bede Abii</p>
                                                <p>5.4 Days for BB</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>

                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field3">
                                                <p>Bede Abii</p>
                                                <p>5.4 Days for BB</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field2">
                                                <p>Tetherdown Primary School: 1.08 Hours</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="calendar-section school-calendar-section">
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field3">
                                                <p>Bede Abii</p>
                                                <p>5.4 Days for BB</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field">
                                                <p>West hampstead Primary School: Whole Day</p>
                                            </div>
                                        </div>

                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field3">
                                                <p>Bede Abii</p>
                                                <p>5.4 Days for BB</p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar date-left-school-calendar">
                                            <div class="teacher-calendar-days-field2">
                                                <p>Tetherdown Primary School: 1.08 Hours</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-content assignment-tab-content school-calandar">

                    <div class="assignment-section-col">
                        <div class="teacher-calendar-sec">




                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
