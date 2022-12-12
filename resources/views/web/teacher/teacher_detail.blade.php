@extends('web.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacher.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacher.teacher_header')

                <div class="school-detail-right-sec">
                    <div class="school-details-first-sec">
                        <div class="details-heading">
                            <h2>Details</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <div class="about-school-section">
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>ID</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $teacherDetail->teacher_id }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Title</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $teacherDetail->title_txt }}</p>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>First Name</h2>
                                </div>
                                <div class="grid-refs-sec">
                                    <div class="grid-refs-text1">
                                        <p>{{ $teacherDetail->firstName_txt }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Surname</h2>
                                </div>
                                <div class="grid-refs-sec">
                                    <div class="grid-refs-text1">
                                        <p>{{ $teacherDetail->surname_txt }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Known As</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $teacherDetail->knownAs_txt }}</p>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Maiden Name</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $teacherDetail->maidenPreviousNames_txt }}</p>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Date of Birth</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ date('d-m-Y', strtotime($teacherDetail->DOB_dte)) }}</p>
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Nationality</h2>
                                </div>
                                <div class="school-name-text">
                                    <p>{{ $teacherDetail->nationality_txt }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="school-details-second-sec">
                        <div>
                            <div class="details-heading">
                                <h2>Address</h2>
                                <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                        class="fa-solid fa-pencil"></i></a>
                            </div>

                            <!-- <div class="about-school-section"> -->
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Full Address</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($teacherDetail->address1_txt)
                                        <p>{{ $teacherDetail->address1_txt }}</p>
                                    @endif
                                    @if ($teacherDetail->address2_txt)
                                        <p>{{ $teacherDetail->address2_txt }}</p>
                                    @endif
                                    @if ($teacherDetail->address3_txt)
                                        <p>{{ $teacherDetail->address3_txt }}</p>
                                    @endif
                                    @if ($teacherDetail->address4_txt)
                                        <p>{{ $teacherDetail->address4_txt }}</p>
                                    @endif
                                    @if ($teacherDetail->postcode_txt)
                                        <p>{{ $teacherDetail->postcode_txt }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Grid Refs</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($teacherDetail->lat_txt)
                                        <p>{{ $teacherDetail->lat_txt }}</p>
                                    @endif
                                    @if ($teacherDetail->lon_txt)
                                        <p>{{ $teacherDetail->lon_txt }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="school-detail-right-sec">

                    <div class="school-details-contact-second-sec">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>Contacts</h2>
                            </div>
                            <div class="contact-icon-sec">
                                <a style="cursor: pointer" class="disabled-link" id="phoneContactItemBttn">
                                    <i class="fa-solid fa-mobile-screen"></i>
                                </a>
                                <a style="cursor: pointer" class="disabled-link" id="mailContactItemBttn">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                                <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Type</th>
                                        <th>Item</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($contactItemList as $key => $contactItem)
                                    <tr class="school-detail-table-data editContactRow">
                                        <td>{{ $contactItem->type_txt }}</td>
                                        <td>{{ $contactItem->contactItem_txt }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="school-details-first-sec">
                        <div class="details-heading">
                            <h2>Emergency Contact</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <div class="about-school-section">
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Emergency Contact</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($teacherDetail->emergencyContactName_txt)
                                        <p>{{ $teacherDetail->emergencyContactName_txt }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Relationship</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($teacherDetail->emergencyContactRelation_txt)
                                        <p>{{ $teacherDetail->emergencyContactRelation_txt }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Contact Num 1</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($teacherDetail->emergencyContactNum1_txt)
                                        <p>{{ $teacherDetail->emergencyContactNum1_txt }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="school-name-section">
                                <div class="school-heading-text">
                                    <h2>Contact Num 2</h2>
                                </div>
                                <div class="school-name-text">
                                    @if ($teacherDetail->emergencyContactNum2_txt)
                                        <p>{{ $teacherDetail->emergencyContactNum2_txt }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
