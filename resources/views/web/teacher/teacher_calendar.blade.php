{{-- @extends('web.layout') --}}
@extends('web.layout_dashboard')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12  pt-3">

                        <div class="school-detail-right-sec sec_box_edit">
                            <div class="row teacher-calendar-sec5">
                                <div class="col-lg-1 col-md-12 col-xl-1 col-sm-12 col-12">
                                    <div class="teacher-calendar-sidebar-section new_teacher-calendar-sidebar">
                                        <div class="form-check sidebar-mode-check">
                                            <label class="teacher_svg" for="editMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 401.523 401"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M370.59 250.973c-5.524 0-10 4.476-10 10v88.789c-.02 16.562-13.438 29.984-30 30H50c-16.563-.016-29.98-13.438-30-30V89.172c.02-16.559 13.438-29.98 30-30h88.79c5.523 0 10-4.477 10-10 0-5.52-4.477-10-10-10H50c-27.602.031-49.969 22.398-50 50v260.594c.031 27.601 22.398 49.968 50 50h280.59c27.601-.032 49.969-22.399 50-50v-88.793c0-5.524-4.477-10-10-10zm0 0"
                                                            fill="#3c0077ad" opacity="1" data-original="#3c0077ad"
                                                            class=""></path>
                                                        <path
                                                            d="M376.629 13.441c-17.574-17.574-46.067-17.574-63.64 0L134.581 191.848a9.997 9.997 0 0 0-2.566 4.402l-23.461 84.7a9.997 9.997 0 0 0 12.304 12.308l84.7-23.465a9.997 9.997 0 0 0 4.402-2.566l178.402-178.41c17.547-17.587 17.547-46.055 0-63.641zM156.37 198.348 302.383 52.332l47.09 47.09-146.016 146.016zm-9.406 18.875 37.62 37.625-52.038 14.418zM374.223 74.676 363.617 85.28l-47.094-47.094 10.61-10.605c9.762-9.762 25.59-9.762 35.351 0l11.739 11.734c9.746 9.774 9.746 25.59 0 35.36zm0 0"
                                                            fill="#3c0077ad" opacity="1" data-original="#3c0077ad"
                                                            class=""></path>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="radio" id="editMode" name="calendar_mode" value="edit"
                                                checked>
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label class="teacher_svg" for="viewMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 512 512"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M452 40h-24V0h-40v40H124V0H84v40H60C26.916 40 0 66.916 0 100v352c0 33.084 26.916 60 60 60h392c33.084 0 60-26.916 60-60V100c0-33.084-26.916-60-60-60zm20 412c0 11.028-8.972 20-20 20H60c-11.028 0-20-8.972-20-20V188h432v264zm0-304H40v-48c0-11.028 8.972-20 20-20h24v40h40V80h264v40h40V80h24c11.028 0 20 8.972 20 20v48z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                        <path
                                                            d="M76 230h40v40H76zM156 230h40v40h-40zM236 230h40v40h-40zM316 230h40v40h-40zM396 230h40v40h-40zM76 310h40v40H76zM156 310h40v40h-40zM236 310h40v40h-40zM316 310h40v40h-40zM76 390h40v40H76zM156 390h40v40h-40zM236 390h40v40h-40zM316 390h40v40h-40zM396 310h40v40h-40z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="radio" id="viewMode" name="calendar_mode" value="view">
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label class="teacher_svg" for="teacherMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 349.2 349.2"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="m337.6 114.25-139.2-68c-12-6-32.4-6-44.4 0l-142.4 68c-10 4.8-11.6 11.6-11.6 15.2 0 3.6 1.6 10 11.6 15.2l11.6 5.6v64c-7.2 2.8-12.4 10-12.4 18s5.2 15.2 12 18l-18 57.2h50.4l-18-57.2c7.2-2.8 12-10 12-18 0-8.4-5.2-15.2-12.4-18v-57.2l21.2 10.4v83.2c0 1.2.4 2.4 1.2 3.6 2 2.4 39.2 53.2 115.2 53.2s113.2-51.2 114.8-53.2c.8-1.2 1.2-2.4 1.2-3.6v-82.8l47.2-23.2c10-4.8 11.6-11.6 11.6-15.2-.4-3.6-1.6-10.4-11.6-15.2zm-60 134.4c-6.4 8-40.8 46.4-103.2 46.4-62.4 0-96.8-38.4-103.2-46.4v-75.6l82.8 39.6c6 2.8 14 4.4 22 4.4 8.4 0 16.4-1.6 22.4-4.8l79.2-38.8v75.2zm54.4-115.2-48 23.6c-2 0-3.6.8-4.4 2.4l-86.8 42c-8.4 4.4-24.8 4.4-33.6 0l-106.8-51.2 122.8-14.4c3.6-.4 6-3.6 5.6-6.8-.4-3.6-3.6-6-6.8-5.6l-142.4 16.8-14.4-6.8c-3.6-1.6-4.4-3.6-4.4-3.6 0-.4.8-2 4.4-3.6l142.4-68.4c4.4-2 10.4-3.2 16.4-3.2 6.4 0 12.8 1.2 16.8 3.2l139.2 68c3.6 1.6 4.4 3.2 4.4 4 0 0-1.2 2-4.4 3.6z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="radio" id="teacherMode" name="calendar_mode" value="teacher">
                                        </div>
                                        <div class="form-check sidebar-mode-check">
                                            <label class="teacher_svg" for="schoolMode">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                                    x="0" y="0" viewBox="0 0 512 512"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M495.971 492.917h-19.51V263.75h3.398c9.957 0 18.058-8.101 18.058-18.058s-8.101-18.058-18.058-18.058H356.64v-44.18a28.614 28.614 0 0 0-9.886-21.637l-72.005-62.395c-3.715-3.217-8.101-5.242-12.672-6.223V55.981h47.075c7.181 0 13.023-5.842 13.023-13.023V19.957c0-7.181-5.842-13.023-13.023-13.023h-53.15a6.075 6.075 0 0 0-6.075 6.075v80.189c-4.573.981-8.961 3.006-12.676 6.225l-72.005 62.395a28.613 28.613 0 0 0-9.886 21.637v44.18H32.142c-9.957 0-18.058 8.101-18.058 18.058s8.101 18.058 18.058 18.058h3.389v229.167H16.029c-3.355 0-6.075 2.719-6.075 6.075s2.719 6.075 6.075 6.075H495.97c3.355 0 6.075-2.719 6.075-6.075s-2.719-6.076-6.074-6.076zM262.077 19.083h47.075c.479 0 .873.392.873.873v23.001a.875.875 0 0 1-.873.873h-47.075zm202.234 473.834H356.64V263.75h107.671zm15.547-253.134c3.256 0 5.909 2.653 5.909 5.909s-2.653 5.909-5.909 5.909l-123.219-.004v-11.813h123.219zm-453.625 5.909a5.919 5.919 0 0 1 5.909-5.909H155.36v11.813l-123.218.004a5.917 5.917 0 0 1-5.909-5.908zM47.68 263.75h107.68v229.167H47.68zm201.745 229.167h-33.468V389.356c0-8.951 7.28-16.236 16.231-16.236h17.237zm46.619 0h-34.47V373.12h18.239c8.951 0 16.231 7.285 16.231 16.236zM279.813 360.97h-47.625c-15.647 0-28.381 12.733-28.381 28.385v103.561H167.52c-.002-64.265-.009-226.82-.009-309.463 0-4.784 2.074-9.321 5.69-12.458l72.005-62.39c6.155-5.33 15.434-5.344 21.589 0l72.005 62.39a16.481 16.481 0 0 1 5.69 12.458l-.024 309.463h-36.273v-103.56c0-15.652-12.733-28.386-28.38-28.386z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                        <path
                                                            d="M255.499 239.793c22.643 0 41.062-18.419 41.062-41.057 0-22.643-18.419-41.062-41.062-41.062s-41.062 18.419-41.062 41.062c.001 22.638 18.419 41.057 41.062 41.057zm0-69.97c15.942 0 28.912 12.971 28.912 28.912s-12.971 28.907-28.912 28.907c-15.942 0-28.912-12.966-28.912-28.907s12.971-28.912 28.912-28.912z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                        <path
                                                            d="M253.292 208.906h12.482a6.075 6.075 0 1 0 0-12.15h-6.407v-12.695c0-3.355-2.719-6.075-6.075-6.075s-6.075 2.719-6.075 6.075v18.77a6.075 6.075 0 0 0 6.075 6.075zM205.022 283.536h101.957a6.075 6.075 0 1 0 0-12.15H205.022a6.075 6.075 0 1 0 0 12.15zM313.053 320.037a6.075 6.075 0 0 0-6.075-6.075H205.022a6.075 6.075 0 1 0 0 12.15h101.957a6.074 6.074 0 0 0 6.074-6.075zM112.329 305.994H90.721c-9.33 0-16.919 7.593-16.919 16.924v21.603c0 9.331 7.589 16.924 16.919 16.924h21.608c9.33 0 16.919-7.593 16.919-16.924v-21.603c0-9.331-7.589-16.924-16.919-16.924zm4.77 38.527a4.776 4.776 0 0 1-4.77 4.774H90.721a4.777 4.777 0 0 1-4.77-4.774v-21.603a4.776 4.776 0 0 1 4.77-4.774h21.608c2.629 0 4.77 2.14 4.77 4.774zM112.329 395.222H90.721c-9.33 0-16.919 7.589-16.919 16.919v21.608c0 9.33 7.589 16.924 16.919 16.924h21.608c9.33 0 16.919-7.593 16.919-16.924v-21.608c0-9.331-7.589-16.919-16.919-16.919zm4.77 38.527a4.776 4.776 0 0 1-4.77 4.774H90.721a4.777 4.777 0 0 1-4.77-4.774v-21.608c0-2.629 2.14-4.77 4.77-4.77h21.608c2.629 0 4.77 2.14 4.77 4.77zM399.671 361.445h21.608c9.331 0 16.919-7.593 16.919-16.924v-21.603c0-9.331-7.589-16.924-16.919-16.924h-21.608c-9.331 0-16.919 7.593-16.919 16.924v21.603c0 9.331 7.589 16.924 16.919 16.924zm-4.77-38.527a4.776 4.776 0 0 1 4.77-4.774h21.608c2.629 0 4.77 2.14 4.77 4.774v21.603a4.776 4.776 0 0 1-4.77 4.774h-21.608a4.777 4.777 0 0 1-4.77-4.774zM399.671 450.673h21.608c9.331 0 16.919-7.593 16.919-16.924v-21.608c0-9.331-7.589-16.919-16.919-16.919h-21.608c-9.331 0-16.919 7.589-16.919 16.919v21.608c0 9.331 7.589 16.924 16.919 16.924zm-4.77-38.532c0-2.629 2.14-4.77 4.77-4.77h21.608c2.629 0 4.77 2.14 4.77 4.77v21.608a4.776 4.776 0 0 1-4.77 4.774h-21.608a4.777 4.777 0 0 1-4.77-4.774z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="radio" id="schoolMode" name="calendar_mode" value="school">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12 col-sm-12 col-lg-11 col-xl-11">
                                    <div class="teacher-calendar-slider">
                                        <div class="teacher-calendar-table-section1">
                                            <div class="total-days-slider-sec1">
                                                <div class="total-days-text">
                                                    <div class="assignment-date">
                                                        <a
                                                            href="{{ URL::to('/candidate-calendar?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                                            <i class="fas fa-caret-left"></i>
                                                        </a>
                                                    </div>
                                                    <div class="teacher-calendar-date-text">
                                                        <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                                    </div>
                                                    <div class="assignment-date2">
                                                        <a
                                                            href="{{ URL::to('/candidate-calendar?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                                            <i class="fas fa-caret-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $day1Amount_total = 0;
                                            $day2Amount_total = 0;
                                            $day3Amount_total = 0;
                                            $day4Amount_total = 0;
                                            $day5Amount_total = 0;
                                            foreach ($calenderList as $key => $cal) {
                                                $day1Amount_total += $cal->day1Amount_dec;
                                                $day2Amount_total += $cal->day2Amount_dec;
                                                $day3Amount_total += $cal->day3Amount_dec;
                                                $day4Amount_total += $cal->day4Amount_dec;
                                                $day5Amount_total += $cal->day5Amount_dec;
                                            }
                                            ?>

                                            <div class="new_teacher_calendar_outer1">
                                                <div class="new_teacher_wapper">
                                                    <div class="skd_dates_row grid_7">
                                                        <div class="teacher-calendar-total-days-text skd_date">
                                                            <p>{{ number_format((float) ($day1Amount_total + $day2Amount_total + $day3Amount_total + $day4Amount_total + $day5Amount_total), 1, '.', '') }}
                                                                days total:</p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Monday</p>
                                                            <p class="teacher-calendar-bottom-text">{{ $day1Amount_total }}
                                                            </p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Tuesday</p>
                                                            <p class="teacher-calendar-bottom-text">{{ $day2Amount_total }}
                                                            </p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Wednesday</p>
                                                            <p class="teacher-calendar-bottom-text">{{ $day3Amount_total }}
                                                            </p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Thursday</p>
                                                            <p class="teacher-calendar-bottom-text">{{ $day4Amount_total }}
                                                            </p>
                                                        </div>
                                                        <div class="teacher-calendar-days-text skd_date">
                                                            <p>Friday</p>
                                                            <p class="teacher-calendar-bottom-text">{{ $day5Amount_total }}
                                                            </p>
                                                        </div>
                                                    </div>


                                                    @foreach ($calenderList as $key1 => $calender)
                                                        <div
                                                            class="calendar-section skd_image_calender_box new_teacher_calendar_outer2">
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                <div class="teacher-calendar-days-field3"
                                                                    style="cursor: pointer;"
                                                                    onclick="calDateClick('teacher', '{{ $calender->teacher_id }}', '', '')">
                                                                    <div class="calendar_first_sec">
                                                                        @if ($calender->file_location != null || $calender->file_location != '')
                                                                            <img src="{{ asset($calender->file_location) }}"
                                                                                alt="">
                                                                        @else
                                                                            <img src="{{ asset('web/images/user-img.png') }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="calendar_right_sec">
                                                                        <p>
                                                                            @if ($calender->knownAs_txt == null && $calender->knownAs_txt == '')
                                                                                {{ $calender->firstName_txt . ' ' . $calender->surname_txt }}
                                                                            @else
                                                                                {{ $calender->firstName_txt . ' (' . $calender->knownAs_txt . ') ' . $calender->surname_txt }}
                                                                            @endif
                                                                        </p>
                                                                        <p>{{ $calender->totalDays }} Days</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day1Avail_txt && $calender->day1Link_id)
                                                                    <div class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day1Link_id }}', '{{ $calender->day1School_id }}')">
                                                                        <p>{{ $calender->day1Avail_txt }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day2Avail_txt && $calender->day2Link_id)
                                                                    <div class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day2Link_id }}', '{{ $calender->day2School_id }}')">
                                                                        <p>{{ $calender->day2Avail_txt }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day3Avail_txt && $calender->day3Link_id)
                                                                    <div class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day3Link_id }}', '{{ $calender->day3School_id }}')">
                                                                        <p>{{ $calender->day3Avail_txt }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day4Avail_txt && $calender->day4Link_id)
                                                                    <div class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day4Link_id }}', '{{ $calender->day4School_id }}')">
                                                                        <p>{{ $calender->day4Avail_txt }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="date-left-teacher-calendar new_teacher_calendar_inner">
                                                                @if ($calender->day5Avail_txt && $calender->day5Link_id)
                                                                    <div class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                                        style="cursor: pointer;"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day5Link_id }}', '{{ $calender->day5School_id }}')">
                                                                        <p>{{ $calender->day5Avail_txt }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="teacher-calendar-days-field3"
                                                                        onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Teacher Calendar Modal -->
    <div class="modal fade" id="TeacherCalendarModal">
        <div class="modal-dialog modal-xl modal-dialog-centered calendar-modal-section tab_mob_full">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Teacher Calendar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="AjaxTeacherCalendar" class="skd_calender_new"></div>

                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher Calendar Modal -->

    <!-- Teacher Calendar Event Edit Modal -->
    <div class="modal fade" id="TeacherCalEventEditModal" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Calendar Item</h4>
                    <button type="button" class="close" id="EventEditModalClose">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="AjaxTeacherCalEvent"></div>
                </div>

            </div>
        </div>
    </div>
    <!-- Teacher Calendar Event Edit Modal -->

    <script>
        function calDateClick(type, teacher_id, asn_id, school_id) {
            // alert('type->'+type+', teacher->'+teacher_id+', asn->'+asn_id)
            var calendar_mode = $('input[name="calendar_mode"]:checked').val();
            if (calendar_mode == 'edit') {
                if (type == 'teacher') {
                    swal("",
                        "You cannot open a school or assignment using this control. Either change the mode on the working list form or click on a specific day."
                    );
                }
                if (type == 'date' && asn_id) {
                    var rUrl = '<?php echo url('/assignment-details/'); ?>' + '/' + asn_id;
                    window.open(rUrl, '_blank');
                }
            }

            if (calendar_mode == 'view' && teacher_id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('teacherCalendarList') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacher_id: teacher_id
                    },
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        $('#AjaxTeacherCalendar').html(data.html);
                        $('#TeacherCalendarModal').modal("show");
                    }
                });
            }

            if (calendar_mode == 'teacher') {
                var rUrl1 = '<?php echo url('/candidate-detail/'); ?>' + '/' + teacher_id;
                window.open(rUrl1, '_blank');
            }

            if (calendar_mode == 'school') {
                if (type == 'teacher') {
                    swal("",
                        "You cannot open a school or assignment using this control. Either change the mode on the working list form or click on a specific day."
                    );
                }
                if (type == 'date' && school_id) {
                    var rUrl = '<?php echo url('/school-detail/'); ?>' + '/' + school_id;
                    window.open(rUrl, '_blank');
                }
            }
        }

        $(document).on('click', '#EventEditModalClose', function() {
            $('#TeacherCalEventEditModal').modal("hide");
            $('body').addClass('modal-open');
        });

        $(document).on('change', '#part_int_id', function() {
            var part_int_id = $('#part_int_id').val();
            if (part_int_id == 4) {
                $("#start_tm_id").prop('disabled', false);
                $("#end_tm_id").prop('disabled', false);
            } else {
                $("#start_tm_id").val('');
                $("#end_tm_id").val('');
                $("#start_tm_id").prop('disabled', true);
                $("#end_tm_id").prop('disabled', true);
            }
        });

        $(document).on('click', '#TeacherCalEventSaveBtn', function() {
            var form = $("#TeacherCalEventEditForm");
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                async: false,
                success: function(data) {
                    $('#full_calendar_events').fullCalendar('refetchEvents');
                    $('#full_calendar_events').fullCalendar('unselect');
                    $('#TeacherCalEventEditModal').modal("hide");
                    $('body').addClass('modal-open');
                }
            });
        });

        $(document).on('click', '#TeacherCalEventDeleteBtn', function() {
            var form = $("#TeacherCalEventEditForm");
            var SITEURL = "{{ url('/') }}";
            var actionUrl = SITEURL + "/teacherEventDelete";
            swal({
                    title: "",
                    text: "This will DELETE this calendar item. Please click YES if you are certain you wish to remove it.",
                    buttons: {
                        cancel: "No",
                        Yes: "Yes"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $.ajax({
                                type: "POST",
                                url: actionUrl,
                                data: form.serialize(),
                                dataType: "json",
                                async: false,
                                success: function(data) {
                                    $('#full_calendar_events').fullCalendar('refetchEvents');
                                    $('#full_calendar_events').fullCalendar('unselect');
                                    $('#TeacherCalEventEditModal').modal("hide");
                                    $('body').addClass('modal-open');
                                }
                            });
                    }
                });
        });
    </script>
@endsection
