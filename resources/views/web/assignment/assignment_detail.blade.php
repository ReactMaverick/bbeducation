{{-- @extends('web.layout') --}}
@extends('web.assignment.assignment_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.assignment.assignment_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">

                <div class="row assignment-detail-row">
                    <div class="col-md-12">
                        <div class="mode-section">
                            <div class="mode-text-sec mode_text_outer">
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-12 col-sm-12">
                                        <div class="mode_box">
                                            <p>Mode</p>
                                            <span class="mode_icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="70" height="70"
                                                    x="0" y="0" viewBox="0 0 156 156"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    class="">
                                                    <g>
                                                        <path
                                                            d="M130.13 76.49C115.31 62.88 99.2 51.08 81.49 41.5c-.95-.51-2.18.02-2.58.92-.06.03-.12.05-.18.1-2.24 1.86-4.13 4.42-6.61 5.95-.71.44-.8 1.27-.46 1.96.93 1.9 1.97 4.15 3.22 6.16-12.12-2.26-24.65-2.83-36.73-5.1-1.14-.21-1.97.42-2.32 1.24C24.9 55.29 25.44 69.36 25.44 78.6c0 7.05-.4 15.69 2.15 22.35 1.71 4.47 9.5 6.91 13.62 7.95.38.1.72.02 1.01-.15.06-.01.12-.01.18-.03 10.79-3.29 21.55-6.69 32.31-10.09-1.61 3.7-2.39 8.2-2.78 11.86-.06.54.37 1.02.78 1.29 2.4 1.56 5.32 3.29 8.25 2.71.12-.02.22-.09.29-.17.6.42 1.44.53 2.07.13 16.68-10.7 32.03-22.78 46.85-35.91.59-.52.5-1.55-.04-2.05zM28.89 69.24c2.02-1.86 4.03-3.56 6.61-4.83.94-.46.22-1.96-.74-1.64-1.79.58-3.62 1.47-5.21 2.65 1.05-4.18 3.24-7.76 7.6-9.93h.01c.45.1.9.19 1.35.29-.28 4.28-.38 8.56-.38 12.84-1.58 1.09-3.15 2.16-4.65 3.36-1.58 1.25-3.46 2.41-4.78 3.96-.06-2.26-.04-4.52.19-6.7zm-.05 7.51c2.03-.64 3.8-2.13 5.54-3.33 1.34-.92 2.57-1.96 3.78-3.04.02 1.88.08 3.75.14 5.63-3.27 2.34-6.23 5.11-9.22 7.8v-.06c-.1-2.24-.26-4.62-.35-7.01.03.01.06.03.11.01zm.25 9.32c.05-.02.1-.03.15-.07 3.05-2.41 6.23-4.75 9.12-7.38.09 2.48.21 4.96.35 7.43-.14-.04-.3-.02-.48.07-3.37 1.91-6.14 4.44-8.7 7.34-.6.68.39 1.64 1.03.97 2.51-2.63 5.35-4.94 8.22-7.17.13 2.37.28 4.74.44 7.11h-.01c-2.72 1.63-5.65 3.48-8.03 5.68-2.27-2.5-2.12-9.61-2.09-13.98zm3.64 15.22c2.33-1.3 4.55-2.96 6.61-4.64.19 2.87.38 5.74.56 8.6-2.49-1.14-4.89-2.37-7.17-3.96zm50.7-46.99c.73 1.64 1.48 3.27 2.25 4.89a94.14 94.14 0 0 0-6.35-1.67c-.04-.12-.1-.23-.14-.35 1.36-.81 2.67-1.67 3.98-2.59.12-.08.2-.18.26-.28zm-2.49-5.43c.03-.04.05-.08.07-.12.62 1.47 1.26 2.94 1.91 4.4a.854.854 0 0 0-.6.06c-1.37.65-2.69 1.34-4 2.07-.56-1.06-1.21-2.1-1.89-3.1 1.75-.62 3.27-1.99 4.51-3.31zm-6.33.78c1.31-1.83 3.13-3.37 4.67-5.04.46 1.16.96 2.3 1.45 3.45-.12-.05-.26-.04-.4.06-1.45 1.08-3.09 2.07-4.42 3.32-.44-.62-.88-1.22-1.3-1.79zm8.58 54.39a.674.674 0 0 0-.61.13 32.418 32.418 0 0 1-5.63 3.71c-.95.49-.08 1.87.87 1.4 1.85-.91 3.43-2.02 4.86-3.44-.61 2.22-1.29 4.42-2.1 6.61-.05.14-.06.27-.07.4-1.65-1.16-3.6-1.87-5.32-3 .51-1.72.94-3.47 1.4-5.2.98-1.14 2.06-2.14 3.29-3.01 1.22-.86 2.89-1.26 3.93-2.3.37-.37.04-.91-.42-.94-1.5-.08-3.12 1.15-4.3 1.96-.58.4-1.12.84-1.64 1.31.44-1.42.89-2.81 1.15-4.26 2.09-.66 4.18-1.32 6.28-1.98-.41 2.91-.97 5.77-1.69 8.61zm2.57 4.46a83.33 83.33 0 0 0 3.12-15.28c.15-1.33-.85-2.68-2.33-2.21-14.4 4.5-28.83 8.93-43.19 13.54-2.39-15.98-2.26-32.14-2.4-48.25 15.83 3.07 32.12 2.74 47.67 7.57 1.6.5 2.57-1.37 1.92-2.64-2.35-4.58-4.44-9.27-6.38-14.03 15.21 8.7 29.58 18.75 42.75 30.35-12.89 11.3-26.8 21.56-41.16 30.95z"
                                                            fill="#000000" opacity="1" data-original="#000000"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-12 col-sm-12">

                                        <div class="skd_top_bar">
                                            <div class="form-check mode-check mode_check_inner">
                                                <label for="addMode" class="add_days_btn check_btn_active">
                                                    Add Days
                                                    <!-- <i class="fa-solid fa-plus"></i> -->
                                                </label>
                                                <input type="radio" id="addMode" name="assignment_mode" value="add"
                                                    checked>
                                            </div>
                                            <div class="form-check mode-check mode_check_inner">
                                                <label for="editMode" class="edit_days_btn">
                                                    Edit Days
                                                    <!-- <i class="fa-solid fa-pencil"></i> -->
                                                </label>
                                                <input type="radio" id="editMode" name="assignment_mode" value="edit">
                                            </div>
                                            <div class="form-check mode-check mode_check_inner">
                                                <label for="enterMode" id="unblockLabel" class="unblock_days_btn">
                                                    Unblock Booking
                                                    <!-- <i class="fa-solid fa-right-long next-arrow-icon"></i> -->
                                                </label>
                                                <input type="radio" id="enterMode" name="assignment_mode" value="unblock">
                                            </div>

                                            <div class="button-section btn_sec_outer">

                                                <button type="button" class="btn btn-primary button-2 block_days_btn"
                                                    id="blockBookingBtnId">
                                                    Block Booking
                                                </button>

                                                <button type="button"
                                                    class="button-1 candidate_vetting_days_btn {{ $assignmentDetail->teacher_id ? '' : 'disableCandVetting' }}"
                                                    {{ $assignmentDetail->teacher_id ? '' : 'disabled' }}
                                                    onclick="candidateVetting({{ $asn_id }}, '{{ $assignmentDetail->teacher_id }}', '{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}')">Candidate
                                                    Vetting</button>

                                                <button type="button" class="btn btn-primary button-3 check_save_btn"
                                                    id="assignmentDetSubBtn">
                                                    Save
                                                    {{-- <img src="{{ asset('web/images/checkmark.png') }}" alt=""
                                                        class="checkmark_img" /> --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="12"
                                                        height="12" x="0" y="0" viewBox="0 0 512 511"
                                                        style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                        class="">
                                                        <g>
                                                            <path
                                                                d="M512 256.5c0 50.531-15 99.672-43.375 142.113-3.855 5.77-10.191 8.887-16.645 8.887-3.82 0-7.683-1.09-11.097-3.375-9.184-6.137-11.649-18.559-5.512-27.742C459.336 340.543 472 299.09 472 256.5c0-18.3-2.29-36.477-6.805-54.016-2.754-10.695 3.688-21.601 14.383-24.355 10.703-2.75 21.602 3.687 24.356 14.383C509.285 213.309 512 234.836 512 256.5zM367.734 441.395C334.141 461.742 295.504 472.5 256 472.5c-119.102 0-216-96.898-216-216s96.898-216 216-216c44.098 0 86.5 13.195 122.629 38.16 9.086 6.278 21.543 4 27.824-5.086 6.277-9.086 4.004-21.543-5.086-27.824C358.523 16.148 308.257.5 256 .5 187.621.5 123.332 27.129 74.98 75.48 26.63 123.832 0 188.121 0 256.5s26.629 132.668 74.98 181.02C123.332 485.87 187.621 512.5 256 512.5c46.813 0 92.617-12.758 132.46-36.895 9.45-5.722 12.47-18.02 6.747-27.468-5.727-9.45-18.023-12.465-27.473-6.742zM257.93 314.492c-3.168.125-6.125-1-8.422-3.187l-104.746-99.317c-8.016-7.601-20.676-7.265-28.274.75-7.601 8.016-7.265 20.676.75 28.274l104.727 99.3c9.672 9.196 22.183 14.188 35.441 14.188.711 0 1.422-.016 2.133-.043 14.043-.566 26.941-6.644 36.316-17.117.239-.262.465-.531.688-.809l211.043-262.5c6.922-8.61 5.555-21.199-3.055-28.117-8.605-6.922-21.199-5.555-28.12 3.055L265.78 310.957a11.434 11.434 0 0 1-7.851 3.535zm0 0"
                                                                fill="#000000" opacity="1" data-original="#000000"
                                                                class=""></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 topbar-sec">

                        <form action="{{ url('/assignmentDetailUpdate') }}" method="post" id="assignmentDetForm">
                            @csrf

                            <input type="hidden" name="assignmentId" id="" value="{{ $asn_id }}">

                            <div class="assignment-detail-right-sec row nw_row">
                                <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12 col-12 pr-3">
                                    <div class="filter-section">
                                        <div class="filter-group-sec">
                                            <div class="form-group assignment-detail-form-group">
                                                <label for="">Age Range</label>
                                                <select id="" class="form-control select2" name="ageRange_int"
                                                    style="width:100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($ageRangeList as $key => $ageRange)
                                                        <option value="{{ $ageRange->description_int }}"
                                                            {{ $assignmentDetail->ageRange_int == $ageRange->description_int ? 'selected' : '' }}>
                                                            {{ $ageRange->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group assignment-detail-form-group">
                                                <label for="">Subject</label>
                                                <select id="" class="form-control select2" name="subject_int"
                                                    style="width:100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($subjectList as $key => $subject)
                                                        <option value="{{ $subject->description_int }}"
                                                            {{ $assignmentDetail->subject_int == $subject->description_int ? 'selected' : '' }}>
                                                            {{ $subject->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group assignment-detail-form-group">
                                                <label for="">Year Group</label>
                                                <select id="" class="form-control select2" name="yearGroup_int"
                                                    style="width:100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($yearGrList as $key => $yearGr)
                                                        <option value="{{ $yearGr->description_int }}"
                                                            {{ $assignmentDetail->yearGroup_int == $yearGr->description_int ? 'selected' : '' }}>
                                                            {{ $yearGr->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group assignment-detail-form-group">
                                                <label for="">Assignment Length</label>
                                                <select id="" class="form-control select2" name="asnLength_int"
                                                    style="width:100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($assLengthList as $key => $assLength)
                                                        <option value="{{ $assLength->description_int }}"
                                                            {{ $assignmentDetail->asnLength_int == $assLength->description_int ? 'selected' : '' }}>
                                                            {{ $assLength->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group assignment-detail-form-group">
                                                <label for="">Professional Type</label>
                                                <select id="" class="form-control select2"
                                                    name="professionalType_int" style="width:100%;"
                                                    onchange="changeProfType('{{ $assignmentDetail->school_id }}', this.value)">
                                                    <option value="">Choose one</option>
                                                    @foreach ($profTypeList as $key => $profType)
                                                        <option value="{{ $profType->description_int }}"
                                                            {{ $assignmentDetail->professionalType_int == $profType->description_int ? 'selected' : '' }}>
                                                            {{ $profType->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group assignment-detail-form-group">
                                                <label for="">Student</label>
                                                <select id="" class="form-control select2" name="student_id"
                                                    style="width:100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($studentList as $key => $student)
                                                        <option value="{{ $student->student_id }}"
                                                            {{ $assignmentDetail->student_id == $student->student_id ? 'selected' : '' }}>
                                                            {{ $student->firstName_txt . ' ' . $student->surname_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row filter-input-sec">
                                            <div class="form-group filter-input-sec-group col-md-6">
                                                <label for="">Daily Charge</label>
                                                <input type="text" class="form-control assignment-detail-form-control"
                                                    id="asnDailyCharge" name="charge_dec" placeholder=""
                                                    value="{{ $assignmentDetail->charge_dec ? $assignmentDetail->charge_dec : '' }}">
                                            </div>

                                            <div class="form-group filter-input-sec-group2 col-md-6">
                                                <label for="">Daily Pay</label>
                                                <input type="text" class="form-control assignment-detail-form-control"
                                                    id="" name="cost_dec" placeholder=""
                                                    value="{{ $assignmentDetail->cost_dec }}">
                                            </div>
                                        </div>
                                        <div class="row status-section">
                                            <div class="form-group col-md-12 second-filter-sec">
                                                <label for="">Status</label>
                                                <select id="" class="form-control select2" name="status_int"
                                                    style="width:100%;">
                                                    <option value="">Choose one</option>
                                                    @foreach ($assignmentStatusList as $key => $assignmentStatus)
                                                        <option value="{{ $assignmentStatus->description_int }}"
                                                            {{ $assignmentDetail->status_int == $assignmentStatus->description_int ? 'selected' : '' }}>
                                                            {{ $assignmentStatus->description_txt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- <div class="form-group col-md-6 second-filter-sec">
                                                        <label for="">First Date</label>
                                                        <input type="text" class="form-control" id=""
                                                            name="firstDate_dte"
                                                            value="{{ $assignmentDetail->firstDate_dte ? $assignmentDetail->firstDate_dte : '' }}"
                                                            readonly>
                                                    </div> --}}
                                        </div>
                                        <div class="row assignment-notes-sec">
                                            {{-- <div class="form-group col-md-6 label-heading">
                                                <label for="">Last Contact re. Assignment</label>
                                                <textarea class="form-control" rows="5" id="" name=""></textarea>
                                            </div> --}}
                                            <div class="form-group col-md-12 label-heading">
                                                <label for="">Assignment Notes</label>
                                                <textarea class="form-control" rows="5" id="" name="notes_txt">{{ $assignmentDetail->notes_txt }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-xl-8 col-sm-12 col-12 pl-3">
                                    <div class="assignment-time-table-section">
                                        <div class="total-days-section">


                                            <div class="date-section">
                                                <div class="total-days-slider-sec">
                                                    <div class="total-days-text">
                                                        <div class="assignment-date">
                                                            <span id="prevDaySpan">
                                                                @if ($prevDays && $prevDays->previousDays > 0)
                                                                    {{ $prevDays->previousDays }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="assignment-date-text">
                                                            <div class="days-slider-sec">
                                                                <a class="calender_icon" style="cursor: pointer"
                                                                    id=""
                                                                    onclick="goFirstAsnDate('<?php echo $assignmentDetail->asnStartDate_dte; ?>')"
                                                                    title="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="30" height="30" x="0" y="0"
                                                                        viewBox="0 0 463.994 463"
                                                                        style="enable-background:new 0 0 512 512"
                                                                        xml:space="preserve" class="">
                                                                        <g>
                                                                            <path
                                                                                d="M384 48.496c0-13.254-10.746-24-24-24h-24c0-13.254-10.746-24-24-24s-24 10.746-24 24h-32c0-13.254-10.746-24-24-24s-24 10.746-24 24h-32c0-13.254-10.746-24-24-24s-24 10.746-24 24H96c0-13.254-10.746-24-24-24s-24 10.746-24 24H24c-13.254 0-24 10.746-24 24v336a8 8 0 0 0 8 8h24v24a8 8 0 0 0 8 8h210.664c.106 0 .184-.055.281-.055 42.371 29.223 97.618 32 142.707 7.168 45.09-24.828 72.278-73.004 70.235-124.433-2.043-51.434-32.969-97.297-79.887-118.473zm-80-24a8 8 0 0 1 16 0v24h-16zm-80 0a8 8 0 0 1 16 0v24h-16zm-80 0a8 8 0 0 1 16 0v24h-16zm-80 0a8 8 0 0 1 16 0v24H64zm-48 24a8 8 0 0 1 8-8h24v16a8 8 0 0 0 8 8h32a8 8 0 0 0 8-8v-16h32v16a8 8 0 0 0 8 8h32a8 8 0 0 0 8-8v-16h32v16a8 8 0 0 0 8 8h32a8 8 0 0 0 8-8v-16h32v16a8 8 0 0 0 8 8h32a8 8 0 0 0 8-8v-16h24a8 8 0 0 1 8 8v40H16zm32 344h170.266a136.023 136.023 0 0 0 13.504 16H48zm400-80c0 66.274-53.727 120-120 120s-120-53.726-120-120c0-66.273 53.727-120 120-120 66.242.074 119.926 53.758 120 120zm-120-136c-47.785-.031-92.074 25.031-116.648 66.012-24.575 40.976-25.825 91.855-3.29 133.988H16v-272h352v78.024a135.599 135.599 0 0 0-40-6.024zm0 0"
                                                                                fill="#000000" opacity="1"
                                                                                data-original="#000000" class="">
                                                                            </path>
                                                                            <path
                                                                                d="M72 136.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM152 136.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM232 136.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM72 200.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM152 200.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM72 264.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM152 264.496c-13.254 0-24 10.746-24 24s10.746 24 24 24 24-10.746 24-24-10.746-24-24-24zm0 32a8 8 0 1 1 0-16 8 8 0 0 1 0 16zM224 312.496c0 57.438 46.563 104 104 104s104-46.562 104-104-46.563-104-104-104c-57.41.067-103.934 46.59-104 104zm192 0h-16a8 8 0 0 0 0 16h14.473C407.258 367.22 375.219 396.45 336 400.09v-15.594a8 8 0 0 0-16 0v15.594c-39.219-3.64-71.258-32.871-78.473-71.594H256a8 8 0 0 0 0-16h-16c.059-45.469 34.723-83.422 80-87.59v15.59a8 8 0 0 0 16 0v-15.59c45.277 4.168 79.941 42.121 80 87.59zm0 0"
                                                                                fill="#000000" opacity="1"
                                                                                data-original="#000000" class="">
                                                                            </path>
                                                                            <path
                                                                                d="m329.719 308.656-11.063-16.597a8.007 8.007 0 0 0-11.097-2.22 8.002 8.002 0 0 0-2.215 11.098l16 24a8.025 8.025 0 0 0 5.504 3.473 7.987 7.987 0 0 0 6.273-1.762l48-40a8 8 0 0 0 1.031-11.27 8.005 8.005 0 0 0-11.273-1.034zm0 0"
                                                                                fill="#000000" opacity="1"
                                                                                data-original="#000000" class="">
                                                                            </path>
                                                                        </g>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            <span class="ttl_days">Total Days:
                                                                {{ $assignmentDetail->daysThisWeek }}</span>
                                                        </div>
                                                        <div class="assignment-date2">
                                                            <span id="nextDaySpan">
                                                                @if ($nextDays && $nextDays->nDays > 0)
                                                                    {{ $nextDays->nDays }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id='full_calendar_events' class="skd_calender_new"></div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            {{-- <div class="button-section">
                            <button type="button"
                                class="button-1 {{ $assignmentDetail->teacher_id ? '' : 'disableCandVetting' }}"
                                {{ $assignmentDetail->teacher_id ? '' : 'disabled' }}
                                onclick="candidateVetting({{ $asn_id }}, '{{ $assignmentDetail->teacher_id }}', '{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}')">Candidate
                                Vetting</button>

                            <button type="button" class="btn btn-primary button-2" id="blockBookingBtnId">
                                Block Booking
                            </button>

                            <button type="submit" class="btn btn-primary button-3">Save</button>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Block Booking Modal -->
    <div class="modal fade" id="blockBookingModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Block Date Booking</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-pencil-alt school-edit-icon"></i>
                        <h2>Create a block of dates for an assignment</h2>
                    </div>

                    <form action="{{ url('/addBlockBooking') }}" method="post" class="form-validate-2"
                        id="addBlockBookingForm">
                        @csrf
                        <input type="hidden" name="assignmentId" id="" value="{{ $asn_id }}">

                        <div class="modal-input-field-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Start Date</label>
                                        <input type="text" class="form-control datePickerPaste datepaste-validate-2"
                                            name="blockStartDate" id="blockStartDate" value="">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">End Date</label>
                                        <input type="text" class="form-control datePickerPaste datepaste-validate-2"
                                            name="blockEndDate" id="blockEndDate" value="">
                                    </div>
                                </div>

                                <input type="hidden" name="blockDays" id="blockDays" value="">

                                <div class="col-md-12" style="padding-right: 0">
                                    <div class="block_booking">
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Monday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Mon', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Tuesday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Tue', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Wednesday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Wed', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Thursday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Thu', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Friday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Fri', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Saturday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Sat', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="block_booking_inr_div">
                                            <div class="date_calendar_top_sec">
                                                <span>Sunday</span>
                                            </div>
                                            <div class="date_calendar_bottom_sec" onclick="selectWeekDay('Sun', event)">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Part Of Day</label>
                                        <select class="form-control field-validate-2" name="blockDayPart"
                                            id="blockDayPart">
                                            <option value="">Choose one</option>
                                            @foreach ($dayPartList as $key1 => $dayPart)
                                                <option value="{{ $dayPart->description_int }}">
                                                    {{ $dayPart->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field" id="blockHourDiv" style="display: none;">
                                        <label class="form-check-label">Hours</label>
                                        <input type="text" class="form-control" name="blockHour" id="blockHour"
                                            value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modal-input-field" id="blockBookingStartTimeDiv"
                                        style="display: none;">
                                        <label class="form-check-label">Start Time</label>
                                        <input type="text" class="form-control" name="start_tm"
                                            id="blockBookingStartTime" value="">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field" id="blockBookingEndTimeDiv"
                                        style="display: none;">
                                        <label class="form-check-label">Finish Time</label>
                                        <input type="text" class="form-control" name="end_tm"
                                            id="blockBookingEndTime" value="">
                                    </div>
                                </div>

                                <div class="col-md-12 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Mins taken for lunch</label>
                                        <input type="text" class="form-control" name="lunch_time" id=""
                                            value="">
                                    </div>
                                </div>

                                <div class="col-md-12 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Note</label>
                                        <textarea class="form-control" rows="2" id="" name="event_note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="addBlockBookingBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
    <!-- Block Booking Modal -->

    <!-- Unblock Booking Modal -->
    <div class="modal fade" id="unblockBookingModal" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">UnBlock Date Booking</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-pencil-alt school-edit-icon"></i>
                        <h2>Enter unblock dates</h2>
                    </div>

                    <form action="{{ url('/unBlockBooking') }}" method="post" class="form-validate-3"
                        id="unblockBookingBtnForm">
                        @csrf
                        <input type="hidden" name="assignmentId" id="" value="{{ $asn_id }}">

                        <div class="modal-input-field-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Start Date</label>
                                        <input type="text" class="form-control datePickerPaste datepaste-validate-3"
                                            name="unblockStartDate" id="unblockStartDate" value="">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">End Date</label>
                                        <input type="text" class="form-control datePickerPaste datepaste-validate-3"
                                            name="unblockEndDate" id="unblockEndDate" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="unblockBookingBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!-- Unblock Booking Modal -->

    <!-- Event Edit Modal -->
    <div class="modal fade" id="eventEditModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Working Day</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-pencil-alt school-edit-icon"></i>
                        <h2>Edit Assignment Day</h2>
                    </div>

                    <form action="{{ url('/ajaxAssignmentEventUpdate') }}" method="post" class="form-validate"
                        id="ajaxAssignmentEventForm">
                        @csrf
                        <input type="hidden" name="editEventId" id="editEventId" value="">

                        <div class="modal-input-field-section">
                            <div id="AjaxEventEdit"></div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="button" class="btn btn-secondary" id="ajaxAssignmentEventBtn">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!-- Event Edit Modal -->

    <!-- Candidate Vetting Modal -->
    <div class="modal fade" id="candidateVettingModal">
        <div
            class="modal-dialog cand-vetting-modal-section modal-xl modal_xxl modal-dialog-centered calendar-modal-section cand-vetting-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Candidate Vetting</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="candidateVetAjax"></div>
                </div>


            </div>
        </div>
    </div>
    <!-- Candidate Vetting Modal -->

    <script src="//cdn.ckeditor.com/4.4.7/standard-all/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/4.4.7/standard-all/adapters/jquery.js"></script>
    <script>
        // Use the document as the parent element for event delegation
        // jQuery(document).ready(function($) {
        //     // Initialize CKEditor when the modal is shown
        //     $('#candidateVettingModal').on('shown.bs.modal', function() {
        //         $('#school_contnt').ckeditor({
        //             toolbar: [],
        //         });

        //         const teacherHtml = $('#teacher_contnt').val();
        //         // console.log(teacherHtml);
        //         const editor = CKEDITOR.replace('teacher_contnt', {
        //             toolbar: [],
        //         });
        //         editor.setData(teacherHtml);
        //     });
        // });
    </script>

    <script>
        $(document).ready(function() {
            $('input[name="assignment_mode"]').change(function() {
                // Remove the class from all labels
                $('.mode-check label').removeClass('check_btn_active');

                // Add the class to the label of the checked radio button
                if ($(this).is(':checked')) {
                    $(this).siblings('label').addClass('check_btn_active');
                }
            });
        });

        $(document).on('click', '#assignmentDetSubBtn', function() {
            $('#assignmentDetForm').submit();
        });
        // $(document).ready(function() {
        //     $('#blockBookingStartTime, #blockBookingEndTime').timepicker({
        //         // timeFormat: 'h:i a',
        //         // 'step': 30,
        //         // 'forceRoundTime': true,
        //         autocomplete: true
        //     });
        // });

        $(document).ready(function() {
            var asnChrgDec = "{{ $assignmentDetail->charge_dec }}";
            var asnCostDec = "{{ $assignmentDetail->cost_dec }}";
            var SITEURL = "{{ url('/') }}";
            var asn_id = "{{ $asn_id }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#full_calendar_events').fullCalendar({
                editable: false,
                firstDay: 1,
                header: {
                    left: 'prev',
                    center: 'today, title',
                    right: 'next'
                },
                // weekends: [ 0, 6 ],
                fixedWeekCount: false,
                showNonCurrentDates: false,
                fullDay: false,
                events: SITEURL + "/assignment-details/" + asn_id,
                displayEventTime: false,
                // eventColor: '#cdb71e',
                eventTextColor: '#fff',
                eventBackgroundColor: '#48A0DC',
                eventRender: function(event, element, view) {
                    // if (event.allDay === 'true') {
                    //     event.allDay = true;
                    // } else {
                    //     event.allDay = false;
                    // }
                    event.editable = true;
                    element.find('span.fc-title').addClass('customClass');
                },
                selectable: true,
                selectHelper: true,
                dragScroll: false,
                unselectAuto: false,
                droppable: false,
                allDayDefault: false,
                longPressDelay: 1,
                select: function(event_start, event_end, allDay) {
                    var AddEvntSts = 'No';
                    var start = moment(event_start);
                    var end = moment(event_end);

                    var lastDayOfMonth = start.clone().endOf('month').date();
                    if (start.date() == lastDayOfMonth) {
                        AddEvntSts = 'Yes';
                    } else if ((event_end._d.getDate() - 1) != event_start._d.getDate()) {
                        AddEvntSts = 'No';
                    } else {
                        AddEvntSts = 'Yes';
                    }
                    // console.log('event_start ==>', event_start)
                    // console.log('event_end ==>', event_end)

                    // console.log('event_start date ==>', event_start._d.getDate())
                    // console.log('event_end date ==>', event_end._d.getDate())
                    if (AddEvntSts == 'No') {
                        calendar.fullCalendar('unselect');
                    } else {
                        // var event_name = prompt('Event Name:');
                        // var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                        var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                        var assignment_mode = $('input[name="assignment_mode"]:checked').val();
                        if (assignment_mode == 'add') {
                            if (asnChrgDec && asnCostDec) {
                                $.ajax({
                                    url: SITEURL + "/insertAssignmentEvent/" + asn_id,
                                    data: {
                                        event_start: event_start
                                    },
                                    type: "POST",
                                    dataType: "json",
                                    success: function(data) {
                                        if (data) {
                                            if (data.exist && data.exist == 'Yes') {
                                                $('#editEventId').val(data.eventId)
                                                $('#AjaxEventEdit').html(data.html);
                                                $('#eventEditModal').modal("show");
                                            }

                                            calendar.fullCalendar('refetchEvents');
                                        }
                                        calendar.fullCalendar('unselect');
                                    }
                                });
                            } else {
                                swal("",
                                    "Please update 'Daily Charge' and 'Daily Pay' first."
                                );
                            }
                        }

                        if (assignment_mode == 'edit') {
                            $.ajax({
                                url: SITEURL + "/checkAssignmentEvent/" + asn_id,
                                data: {
                                    event_start: event_start
                                },
                                type: "POST",
                                dataType: "json",
                                success: function(data) {
                                    if (data) {
                                        if (data.exist == 'No') {
                                            swal("",
                                                "You cannot use the edit day mode on an empty date in the calendar."
                                            );
                                        } else {
                                            $('#editEventId').val(data.eventId)
                                            $('#AjaxEventEdit').html(data.html);
                                            $('#eventEditModal').modal("show");
                                        }
                                    }
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }
                    }
                },
                // eventDrop: function(event, delta) {
                //     var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                //     var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                //     $.ajax({
                //         url: SITEURL + '/calendar-crud-ajax',
                //         data: {
                //             title: event.event_name,
                //             start: event_start,
                //             end: event_end,
                //             id: event.id,
                //             type: 'edit'
                //         },
                //         type: "POST",
                //         success: function(response) {

                //         }
                //     });
                // },
                eventClick: function(event) {
                    // var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                    var assignment_mode = $('input[name="assignment_mode"]:checked').val();
                    if (assignment_mode == 'add') {
                        if (asnChrgDec && asnCostDec) {
                            $.ajax({
                                type: "POST",
                                url: SITEURL + "/updateAssignmentEvent/" + asn_id,
                                data: {
                                    id: event.id
                                },
                                dataType: "json",
                                success: function(data) {
                                    if (data) {
                                        if (data.exist && data.exist == 'Yes') {
                                            $('#editEventId').val(data.eventId)
                                            $('#AjaxEventEdit').html(data.html);
                                            $('#eventEditModal').modal("show");
                                        }

                                        calendar.fullCalendar('refetchEvents');
                                    }
                                }
                            });
                        } else {
                            swal("",
                                "Please update 'Daily Charge' and 'Daily Pay' first."
                            );
                        }
                    }

                    if (assignment_mode == 'edit') {
                        $.ajax({
                            url: SITEURL + "/checkAssignmentEvent2/" + asn_id,
                            data: {
                                id: event.id
                            },
                            type: "POST",
                            dataType: "json",
                            success: function(data) {
                                if (data) {
                                    if (data.exist == 'No') {
                                        swal("",
                                            "You cannot use the edit day mode on an empty date in the calendar."
                                        );
                                    } else {
                                        $('#editEventId').val(data.eventId)
                                        $('#AjaxEventEdit').html(data.html);
                                        $('#eventEditModal').modal("show");
                                    }
                                }
                                calendar.fullCalendar('unselect');
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '#ajaxAssignmentEventBtn', function() {
            var error = "";
            $(".field-validate").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".number-validate").each(function() {
                if (this.value == '' || isNaN(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#ajaxAssignmentEventForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                // $("#full_calendar_events").fullCalendar('removeEvents', data
                                //     .eventId);
                                // $("#full_calendar_events").fullCalendar('renderEvent', {
                                //     id: data.eventItem.id,
                                //     title: data.eventItem.title,
                                //     start: data.eventItem.start,
                                //     editable: false
                                // }, true);
                                $("#full_calendar_events").fullCalendar('refetchEvents');
                                date = moment(data.eventItem.start, "YYYY-MM-DD");
                                $("#full_calendar_events").fullCalendar('gotoDate', date);

                                $('#eventEditModal').modal("hide");
                            }
                        }
                    }
                });
            }
        });

        function goFirstAsnDate(asnStartDate_dte) {
            if (asnStartDate_dte) {
                date = moment(asnStartDate_dte, "YYYY-MM-DD");
                $("#full_calendar_events").fullCalendar('gotoDate', date);

                var SITEURL = "{{ url('/') }}";
                var asn_id = "{{ $asn_id }}";
                $.ajax({
                    type: "POST",
                    url: SITEURL + "/prevNextEvent/" + asn_id,
                    data: {
                        Date: asnStartDate_dte
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#prevDaySpan').html('');
                            $('#nextDaySpan').html('');
                            if (data.prevDays) {
                                $('#prevDaySpan').html(data.prevDays.previousDays);
                            }
                            if (data.nextDays) {
                                $('#nextDaySpan').html(data.nextDays.nDays);
                            }
                        }
                    }
                });
            }
        }

        $(document).on('change', '#blockDayPart', function() {
            var blockDayPart = this.value;
            $('#blockBookingStartTime').val('');
            $('#blockBookingEndTime').val('');
            if (blockDayPart == 4) {
                $('#blockHour').addClass('number-validate-2');
                $('#blockHourDiv').show();

                $('#blockBookingStartTime').addClass('field-validate-2');
                $('#blockBookingStartTimeDiv').show();
                $('#blockBookingEndTime').addClass('field-validate-2');
                $('#blockBookingEndTimeDiv').show();
            } else {
                $('#blockHour').val('');
                $('#blockHour').removeClass('number-validate-2');
                $('#blockHour').closest(".form-group").removeClass('has-error');
                $('#blockHourDiv').hide();

                $('#blockBookingStartTime').removeClass('field-validate-2');
                $('#blockBookingStartTime').closest(".form-group").removeClass('has-error');
                $('#blockBookingStartTimeDiv').hide();
                $('#blockBookingEndTime').removeClass('field-validate-2');
                $('#blockBookingEndTime').closest(".form-group").removeClass('has-error');
                $('#blockBookingEndTimeDiv').hide();
            }
        });

        // $(document).on('change', '#blockBookingStartTime, #blockBookingEndTime', function() {
        //     var startTime = $('#blockBookingStartTime').val();
        //     var endTime = $('#blockBookingEndTime').val();
        //     $('#blockHour').val('');
        //     if (startTime, endTime) {
        //         // var currentDate = new Date();
        //         // var startDate = new Date(currentDate.toDateString() + ' ' + startTime);
        //         // var endDate = new Date(currentDate.toDateString() + ' ' + endTime);
        //         // var timeDiff = endDate - startDate;
        //         // var hoursDiff = timeDiff / (1000 * 60 * 60);
        //         var start = parseTime(startTime);
        //         var end = parseTime(endTime);
        //         // Calculate the time difference in hours
        //         var hoursDiff = (end - start) / 1000 / 60 / 60;

        //         $('#blockHour').val(hoursDiff);
        //     }
        // });

        function parseTime(time) {
            var parts = time.match(/(\d+):(\d+)(am|pm)/);
            var hours = parseInt(parts[1]);
            var minutes = parseInt(parts[2]);

            if (parts[3] === "pm" && hours !== 12) {
                hours += 12;
            } else if (parts[3] === "am" && hours === 12) {
                hours = 0;
            }
            return new Date(0, 0, 0, hours, minutes);
        }

        $(document).on('click', '#blockBookingBtnId', function() {
            var asnChrgDec = "{{ $assignmentDetail->charge_dec }}";
            var asnCostDec = "{{ $assignmentDetail->cost_dec }}";

            if (asnChrgDec && asnCostDec) {
                var CurrentDateObj = new Date();
                date = moment(CurrentDateObj, "YYYY-MM-DD");
                $("#full_calendar_events").fullCalendar('gotoDate', date);
                $('#blockBookingModal').modal('show');
            } else {
                swal("",
                    "Please update 'Daily Charge' and 'Daily Pay' first."
                );
            }
        });

        $(document).on('click', '#addBlockBookingBtn', function() {
            var error = "";
            $(".field-validate-2").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".number-validate-2").each(function() {
                if (this.value == '' || isNaN(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".datepaste-validate-2").each(function() {
                var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
                if (this.value == '' || !dateRegex.test(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#addBlockBookingForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                // location.reload();
                                $.each(data.IdArray, function(val1, text1) {
                                    $("#full_calendar_events").fullCalendar('removeEvents',
                                        text1);
                                });
                                var DateObj = new Date(data.firstDate);
                                var months = DateObj.getMonth();
                                var CurrentDateObj = new Date();
                                var CurrentMonths = CurrentDateObj.getMonth();
                                // if (months == CurrentMonths) {
                                //     $.each(data.eventItemArr, function(val, text) {
                                //         $("#full_calendar_events").fullCalendar('renderEvent', {
                                //             id: text.id,
                                //             title: text.title,
                                //             start: text.start,
                                //             editable: false
                                //         }, true);
                                //     });
                                // }
                                $("#full_calendar_events").fullCalendar('refetchEvents');

                                if (data.firstDate) {
                                    date = moment(data.firstDate, "YYYY-MM-DD");
                                    $("#full_calendar_events").fullCalendar('gotoDate', date);
                                }

                                $('#blockBookingModal').modal('hide');
                            }
                        }
                    }
                });
            }
        });

        $('input[type=radio][name=assignment_mode]').change(function() {
            if (this.value == 'unblock') {
                var CurrentDateObj = new Date();
                date = moment(CurrentDateObj, "YYYY-MM-DD");
                $("#full_calendar_events").fullCalendar('gotoDate', date);
                $('#unblockBookingModal').modal('show');
            }
        });

        $(document).on('click', '#unblockLabel', function() {
            var CurrentDateObj = new Date();
            date = moment(CurrentDateObj, "YYYY-MM-DD");
            $("#full_calendar_events").fullCalendar('gotoDate', date);
            $('#unblockBookingModal').modal('show');
        });

        $(document).on('click', '#unblockBookingBtn', function() {
            var error = "";
            $(".field-validate-3").each(function() {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            $(".datepaste-validate-3").each(function() {
                var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
                if (this.value == '' || !dateRegex.test(this.value)) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            });
            if (error == "has error") {
                return false;
            } else {
                var form = $("#unblockBookingBtnForm");
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data) {
                            if (data.status == 'success') {
                                // location.reload();
                                // $.each(data.IdArray, function(val1, text1) {
                                //     $("#full_calendar_events").fullCalendar('removeEvents',
                                //         text1);
                                // });
                                $("#full_calendar_events").fullCalendar('refetchEvents');

                                if (data.firstDate) {
                                    date = moment(data.firstDate, "YYYY-MM-DD");
                                    $("#full_calendar_events").fullCalendar('gotoDate', date);
                                }

                                $('#unblockBookingModal').modal('hide');
                            }
                        }
                    }
                });
            }
        });

        $(document).on('click', '.fc-prev-button, .fc-next-button', function() {
            var getDate = $('#full_calendar_events').fullCalendar('getDate');
            var Date = getDate.format();
            var SITEURL = "{{ url('/') }}";
            var asn_id = "{{ $asn_id }}";
            $.ajax({
                type: "POST",
                url: SITEURL + "/prevNextEvent/" + asn_id,
                data: {
                    Date: Date
                },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#prevDaySpan').html('');
                        $('#nextDaySpan').html('');
                        if (data.prevDays) {
                            $('#prevDaySpan').html(data.prevDays.previousDays);
                        }
                        if (data.nextDays) {
                            $('#nextDaySpan').html(data.nextDays.nDays);
                        }
                    }
                }
            });
        });

        function candidateVetting(asn_id, teacher_id, candidateName) {
            if (asn_id && teacher_id) {
                var vetting_id = '';
                $.ajax({
                    type: 'POST',
                    url: '{{ url('checkVettingExist') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        asn_id: asn_id,
                        teacher_id: teacher_id
                    },
                    dataType: "json",
                    async: false,
                    success: function(data) {
                        if (data.exist == "Yes" && data.vetting_id) {
                            vetting_id = data.vetting_id;
                        }
                    }
                });

                if (vetting_id) {
                    swal({
                            title: "",
                            text: "A vetting already exists for this teacher and assignment would you like to open it? Clicking No will create a new vetting",
                            buttons: {
                                Yes: "Yes",
                                No: "No",
                                cancel: "Cancel"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "Yes":
                                    // alert('yes');
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('createCandidateVetting') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asn_id: asn_id,
                                            vetting_id: vetting_id,
                                            newVetting: "No"
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $('#candidateVetAjax').html(data.html);
                                                $('#candidateVettingModal').modal("show");
                                            }
                                        }
                                    });
                                    break;
                                case "No":
                                    // alert('No');
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('createCandidateVetting') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asn_id: asn_id,
                                            vetting_id: vetting_id,
                                            newVetting: "Yes"
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $('#candidateVetAjax').html(data.html);
                                                $('#candidateVettingModal').modal("show");
                                            }
                                        }
                                    });
                                    break;
                            }
                        });
                } else {
                    swal({
                            title: "",
                            text: "This will manually create a vetting request for the candidate " + candidateName +
                                " (automatically done on school confirmation) continue anyway?",
                            buttons: {
                                cancel: "No",
                                Yes: "Yes"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "Yes":
                                    // alert('yes')
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('createCandidateVetting') }}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            asn_id: asn_id,
                                            vetting_id: vetting_id,
                                            newVetting: "Yes"
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $('#candidateVetAjax').html(data.html);
                                                $('#candidateVettingModal').modal("show");
                                            }
                                        }
                                    });
                            }
                        });
                }
            }
        }

        $(document).on('click', '#candVettingEditBtn', function() {
            // var error = "";
            // $(".vetting-field-validate").each(function() {
            //     if (this.value == '') {
            //         $(this).closest(".form-group").addClass('has-error');
            //         error = "has error";
            //     } else {
            //         $(this).closest(".form-group").removeClass('has-error');
            //     }
            // });
            // if (error == "has error") {
            //     return false;
            // } else {
            var form = $("#candVettingEditForm");
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                async: false,
                success: function(data) {
                    if (data) {
                        $('#candidateVetAjax').html(data.html);
                    }
                }
            });
            // }
        });

        function changeProfType(school_id, type) {
            // alert(school_id + ',' + type)
            if (school_id && type) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('changeAsnProfType') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        school_id: school_id,
                        type: type
                    },
                    success: function(data) {
                        $('#asnDailyCharge').val(data.rate);
                    }
                });
            }
        }

        function selectWeekDay(day) {
            if (day == 'Mon' || day == 'Tue' || day == 'Wed' || day == 'Thu' || day == 'Fri' || day == 'Sat' || day ==
                'Sun') {
                var element = $(event.target).closest('.date_calendar_bottom_sec');

                if (element.hasClass('date_calendar_bottom_sec_active')) {
                    setDays(day, 'rm');
                    element.removeClass('date_calendar_bottom_sec_active');
                } else {
                    setDays(day, 'add');
                    element.addClass('date_calendar_bottom_sec_active');
                }
            }
        }

        function setDays(day, type) {
            var ItemId = day;
            var ids = '';
            var idsArr = [];
            var asnItemIds = $('#blockDays').val();
            if (asnItemIds) {
                idsArr = asnItemIds.split(',');
            }
            if (type == 'add') {
                idsArr.push(ItemId);
            }
            if (type == 'rm') {
                idsArr = jQuery.grep(idsArr, function(value) {
                    return value != ItemId;
                });
            }
            ids = idsArr.toString();
            $('#blockDays').val(ids);
        }
    </script>
@endsection
