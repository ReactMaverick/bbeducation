@extends('web.teacherPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacherPortal.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacherPortal.teacher_header')

                {{-- calendar --}}
                <div class="school-detail-right-sec">
                    <div class="teacher-calendar-sec" style="display: block">

                        <div class="teacher-calendar-slider">
                            <div class="teacher-calendar-table-section">
                                <div class="total-days-slider-sec">
                                    <div class="total-days-text">
                                        <div class="assignment-date">
                                            <a
                                                href="{{ URL::to('/teacher/timesheet?date=' . date('Y-m-d', strtotime($weekStartDate . ' -7 days'))) }}">
                                                <i class="fa-solid fa-caret-left"></i>
                                            </a>
                                        </div>
                                        <div class="teacher-calendar-date-text">
                                            <span>{{ date('D d M Y', strtotime($weekStartDate)) }}</span>
                                        </div>
                                        <div class="assignment-date2">
                                            <a
                                                href="{{ URL::to('/teacher/timesheet?date=' . date('Y-m-d', strtotime($weekStartDate . ' +7 days'))) }}">
                                                <i class="fa-solid fa-caret-right"></i>
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

                                <div class="teacher-calendar-days-sec">
                                    <div class="teacher-calendar-total-days-text">
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Monday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Tuesday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Wednesday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Thursday</p>
                                    </div>
                                    <div class="teacher-calendar-days-text">
                                        <p>Friday</p>
                                    </div>
                                </div>

                                @foreach ($calenderList as $key1 => $calender)
                                    <div class="calendar-section">
                                        <div class="date-left-teacher-calendar">
                                            <div class="teacher-calendar-days-field3" style="cursor: pointer;"
                                                onclick="calDateClick('teacher', '{{ $calender->teacher_id }}', '', '')">
                                                <p>
                                                    {{ $calender->name_txt }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="date-left-teacher-calendar">
                                            @if ($calender->day1Avail_txt && $calender->day1Link_id)
                                                <div class="{{ $calender->day1LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                    style="cursor: pointer;"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day1Link_id }}')">
                                                    <p>{{ $calender->day1Avail_txt }}</p>
                                                </div>
                                            @else
                                                <div class="teacher-calendar-days-field3"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="date-left-teacher-calendar">
                                            @if ($calender->day2Avail_txt && $calender->day2Link_id)
                                                <div class="{{ $calender->day2LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                    style="cursor: pointer;"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day2Link_id }}')">
                                                    <p>{{ $calender->day2Avail_txt }}</p>
                                                </div>
                                            @else
                                                <div class="teacher-calendar-days-field3"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="date-left-teacher-calendar">
                                            @if ($calender->day3Avail_txt && $calender->day3Link_id)
                                                <div class="{{ $calender->day3LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                    style="cursor: pointer;"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day3Link_id }}')">
                                                    <p>{{ $calender->day3Avail_txt }}</p>
                                                </div>
                                            @else
                                                <div class="teacher-calendar-days-field3"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="date-left-teacher-calendar">
                                            @if ($calender->day4Avail_txt && $calender->day4Link_id)
                                                <div class="{{ $calender->day4LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                    style="cursor: pointer;"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day4Link_id }}')">
                                                    <p>{{ $calender->day4Avail_txt }}</p>
                                                </div>
                                            @else
                                                <div class="teacher-calendar-days-field3"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '', '')">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="date-left-teacher-calendar">
                                            @if ($calender->day5Avail_txt && $calender->day5Link_id)
                                                <div class="{{ $calender->day5LinkType_int == 1 ? 'teacher-calendar-days-field' : 'teacher-calendar-days-field2' }}"
                                                    style="cursor: pointer;"
                                                    onclick="calDateClick('date', '{{ $calender->teacher_id }}', '{{ $calender->day5Link_id }}')">
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
                {{-- calendar --}}

            </div>
        </div>
    </div>
@endsection
