@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">
                <div class="topbar-Section">
                    <i class="fa-solid fa-crown">
                        <span class="topbar-text">All Through</span>
                    </i>
                    <i class="fa-solid fa-school">
                        <span class="topbar-text">Other</span>
                    </i>
                    <i class="fa-solid fa-list-ul">
                        <span class="topbar-text">Barnet</span>
                    </i>
                    <i class="fa-solid fa-flag">
                        <span class="topbar-text">Other</span>
                    </i>
                    <i class="fa-solid fa-star topbar-star-icon"></i>
                    <i class="fa-regular fa-calendar-days">
                        <span class="topbar-text">calendar</span>
                    </i>
                </div>

                <div class="school-detail-right-sec">
                    <div class="school-details-first-sec">
                        <div class="details-heading">
                            <h2>Details</h2>
                            <a href="#"><i class="fa-solid fa-pencil"></i></a>
                        </div>

                        <div class="about-school-section">
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>School</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $schoolDetail->name_txt }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Address</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($schoolDetail->address1_txt)
                                        <p>{{ $schoolDetail->address1_txt }}</p>
                                    @endif
                                    @if ($schoolDetail->address2_txt)
                                        <p>{{ $schoolDetail->address2_txt }}</p>
                                    @endif
                                    @if ($schoolDetail->address3_txt)
                                        <p>{{ $schoolDetail->address3_txt }}</p>
                                    @endif
                                    @if ($schoolDetail->address4_txt)
                                        <p>{{ $schoolDetail->address4_txt }}</p>
                                    @endif
                                    @if ($schoolDetail->address5_txt)
                                        <p>{{ $schoolDetail->address5_txt }}</p>
                                    @endif
                                    @if ($schoolDetail->postcode_txt)
                                        <p>{{ $schoolDetail->postcode_txt }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Grid Refs</h2>
                                </div>
                                <div class="grid-refs-sec">
                                    <div class="grid-refs-text1">
                                        <p>{{ $schoolDetail->lat_txt }}</p>
                                    </div>

                                    <div class="grid-refs-text1">
                                        <p>{{ $schoolDetail->lon_txt }}</p>
                                    </div>

                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Website</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $schoolDetail->website_txt }}</p>
                                </div>
                            </div>

                            <div class="contact-heading">
                                <div class="contact-heading-text">
                                    <h2>Contacts</h2>
                                </div>
                                <div class="contact-icon-sec">
                                    <a href="#"><i class="fa-solid fa-xmark"></i></a>
                                    <a href="#"><i class="fa-solid fa-plus"></i></a>
                                    <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                                </div>
                            </div>
                        </div>

                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Job Role</th>
                                    <th>Name</th>
                                    <th>T/S</th>
                                    <th>Vet.</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data">
                                    <td>xbx</td>
                                    <td>sgsfg</td>
                                    <td>fffs</td>
                                    <td>xdgsg</td>
                                </tr>

                                <tr class="school-detail-table-data">
                                    <td>xbx</td>
                                    <td>sgsfg</td>
                                    <td>fffs</td>
                                    <td>xdgsg</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="school-details-second-sec">
                        <div>
                            <div class="details-heading">
                                <h2>Last Contact</h2>
                            </div>

                            <!-- <div class="about-school-section"> -->
                            <div class="school-name-section">
                                <div class="school-detail-last-contact-text">
                                    @if ($schoolDetail->schoolContactLog_id)
                                    <p>
                                        {{ $schoolDetail->firstName_txt }} {{ $schoolDetail->surname_txt }}
                                        @if ($schoolDetail->method_int == 1)
                                            {{ ' called' }}
                                        @elseif ($schoolDetail->method_int == 2)
                                            {{ ' emailed' }}
                                        @elseif ($schoolDetail->method_int == 3)
                                            {{ ' sent text' }}
                                        @else
                                            {{ ' met' }}
                                        @endif
                                        {{ ' on ' }}
                                        @if ($schoolDetail->contactOn_dtm != 0)
                                            {{ date('d-m-Y', strtotime($schoolDetail->contactOn_dtm)) }}
                                        @endif
                                        {{ '. Spoke to: ' . $schoolDetail->spokeTo_txt . ' and noted: ' . $schoolDetail->notes_txt . '.' }}
                                    </p>
                                    @else
                                        <p>We have no record of previous contact with this school.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="contact-heading">
                                <div class="contact-heading-text">
                                    <h2>Contact Items</h2>
                                </div>
                                <div class="contact-icon-sec">
                                    <a href="#"><i class="fa-solid fa-mobile-screen"></i></a>
                                    <a href="#"><i class="fa-solid fa-envelope"></i></a>
                                    <a href="#"><i class="fa-solid fa-xmark"></i></a>
                                    <a href="#"><i class="fa-solid fa-plus"></i></a>
                                    <a href="#"><i class="fa-solid fa-pencil school-edit-icon"></i></a>
                                </div>
                            </div>
                            <!-- </div> -->



                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Person</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    <tr class="school-detail-table-data">
                                        <td>School Main</td>
                                        <td>School Main</td>
                                        <td>020 8359 7744</td>
                                    </tr>

                                    <tr class="school-detail-table-data">
                                        <td>School Main</td>
                                        <td>School Main</td>
                                        <td>020 8359 7744</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
