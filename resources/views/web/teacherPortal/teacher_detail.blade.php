@extends('web.teacherPortal.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.teacherPortal.teacher_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- /.content-header -->
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 topbar-sec">

                        <div class="school-detail-right-sec">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Details</h2>
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
                                                    <p>{{ date('d M Y', strtotime($teacherDetail->DOB_dte)) }}</p>
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
                                </div>

                                <div class="col-md-6">
                                    <div class="school-details-second-sec sec_box_edit">
                                        <div>
                                            <div class="details-heading">
                                                <h2>Address</h2>
                                            </div>

                                            <div class="about-school-section">
                                                <div class="school-name-section">
                                                    <div class="school-heading-text">
                                                        <h2>Full Address</h2>
                                                    </div>
                                                    <div class="school-name-text">
                                                        <p>
                                                            @if ($teacherDetail->address1_txt)
                                                                {{ $teacherDetail->address1_txt }}
                                                            @endif
                                                            @if ($teacherDetail->address2_txt)
                                                                {{ ', ' . $teacherDetail->address2_txt }}
                                                            @endif
                                                            @if ($teacherDetail->address3_txt)
                                                                {{ ', ' . $teacherDetail->address3_txt }}
                                                            @endif
                                                            @if ($teacherDetail->address4_txt)
                                                                {{ ', ' . $teacherDetail->address4_txt }}
                                                            @endif
                                                            @if ($teacherDetail->postcode_txt)
                                                                {{ ', ' . $teacherDetail->postcode_txt }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="school-heading-text">
                                                        <h2>Grid Refs</h2>
                                                    </div>
                                                    <div class="school-name-text">
                                                        <p>
                                                            @if ($teacherDetail->lat_txt)
                                                                {{ $teacherDetail->lat_txt }}
                                                            @endif
                                                            @if ($teacherDetail->lon_txt)
                                                                {{ ', ' . $teacherDetail->lon_txt }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="school-detail-right-sec mt-3">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Contacts</h2>
                                            </div>
                                            <div class="contact-icon-sec header_icon">
                                                <a data-toggle="modal" data-target="#ContactItemAddModal"
                                                    style="cursor: pointer;">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link" id="editContactItemBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="assignment-finance-table-section">
                                            <table class="table table-bordered table-striped" id="myTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Type</th>
                                                        <th>Item</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($contactItemList as $key => $contactItem)
                                                        <tr class="school-detail-table-data editContactRow"
                                                            id="editContactRow{{ $contactItem->contactItemTch_id }}"
                                                            onclick="contactItemRowSelect({{ $contactItem->contactItemTch_id }})">
                                                            <td>{{ $contactItem->type_txt }}</td>
                                                            <td>{{ $contactItem->contactItem_txt }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" name="" id="teacherContactItemId" value="">
                                </div>

                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>Emergency Contact</h2>
                                            {{-- <a data-toggle="modal" data-target="#editEmergencyContactModal"
                                                style="cursor: pointer;"><i class="fas fa-edit school-edit-icon"></i></a> --}}
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
                </div>
            </div>

        </div>
    </section>

    <!-- Detail Edit Modal -->
    <div class="modal fade" id="editDetailModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Detail</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherDetailUpdate') }}" method="post" class="form-validate">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Title</label>
                                        <select class="form-control" name="title_int" style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($titleList as $key1 => $title)
                                                <option value="{{ $title->description_int }}"
                                                    {{ $teacherDetail->title_int == $title->description_int ? 'selected' : '' }}>
                                                    {{ $title->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">First Name</label><span
                                            style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="firstName_txt"
                                            id="" value="{{ $teacherDetail->firstName_txt }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Surname</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate" name="surname_txt"
                                            id="" value="{{ $teacherDetail->surname_txt }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Known As (nickname/preferred name)</label>
                                        <input type="text" class="form-control" name="knownAs_txt" id=""
                                            value="{{ $teacherDetail->knownAs_txt }}">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Middle Name</label>
                                        <input type="text" class="form-control" name="middleNames_txt" id=""
                                            value="{{ $teacherDetail->middleNames_txt }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Maiden (or previous) Name</label>
                                        <input type="text" class="form-control" name="maidenPreviousNames_txt"
                                            id="" value="{{ $teacherDetail->maidenPreviousNames_txt }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Date of Birth</label><span
                                            style="color: red;">*</span>
                                        <input type="date" class="form-control field-validate" name="DOB_dte"
                                            id=""
                                            value="{{ date('Y-m-d', strtotime($teacherDetail->DOB_dte)) }}">
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Nationality</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate select2" name="nationality_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($nationalityList as $key2 => $nationality)
                                                <option value="{{ $nationality->description_int }}"
                                                    {{ $teacherDetail->nationality_int == $nationality->description_int ? 'selected' : '' }}>
                                                    {{ $nationality->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Detail Edit Modal -->

    <!-- Address Edit Modal -->
    <div class="modal fade" id="editAddressModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Address</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Address</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherAddressUpdate') }}" method="post"
                        class="form-validate-2">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modal-input-field">
                                        <label class="form-check-label">Address</label>
                                        <input type="text" class="form-control mb-1" name="address1_txt"
                                            id="" value="{{ $teacherDetail->address1_txt }}">
                                        <input type="text" class="form-control mb-1" name="address2_txt"
                                            id="" value="{{ $teacherDetail->address2_txt }}">
                                        <input type="text" class="form-control mb-1" name="address3_txt"
                                            id="" value="{{ $teacherDetail->address3_txt }}">
                                        <input type="text" class="form-control" name="address4_txt" id=""
                                            value="{{ $teacherDetail->address4_txt }}">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate-2" name="postcode_txt"
                                            id="" value="{{ $teacherDetail->postcode_txt }}">
                                    </div>

                                    <div class="modal-grid-reference-text">
                                        <a href="javascript:void(0)">Get Grid References</a>
                                    </div>

                                    <div class="modal-input-field">
                                        <label class="form-check-label">Grid References</label>
                                        <h2></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Address Edit Modal -->

    <!-- Emergency Contact Edit Modal -->
    <div class="modal fade" id="editEmergencyContactModal">
        <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Emergency Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Emergency Contact</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherEmerContactUpdate') }}" method="post" class="">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Emergency Contact</label>
                                        <input type="text" class="form-control" name="emergencyContactName_txt"
                                            id="" value="{{ $teacherDetail->emergencyContactName_txt }}">
                                    </div>

                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Contact Num 1</label>
                                        <input type="text" class="form-control" name="emergencyContactNum1_txt"
                                            id="" value="{{ $teacherDetail->emergencyContactNum1_txt }}">
                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-right-sec">
                                    <div class="form-group modal-input-field">
                                        <label class="form-check-label">Contact Num 2</label>
                                        <input type="text" class="form-control" name="emergencyContactNum2_txt"
                                            id="" value="{{ $teacherDetail->emergencyContactNum2_txt }}">
                                    </div>

                                    <div class="form-group calendar-form-filter">
                                        <label for="">Relationship</label>
                                        <select class="form-control" name="emergencyContactRelation_int"
                                            style="width:100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($ralationshipList as $key1 => $ralationship)
                                                <option value="{{ $ralationship->description_int }}"
                                                    {{ $teacherDetail->emergencyContactRelation_int == $ralationship->description_int ? 'selected' : '' }}>
                                                    {{ $ralationship->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Emergency Contact Edit Modal -->

    <!-- Contact Item Add Modal -->
    <div class="modal fade" id="ContactItemAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add Teacher Contact Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Add Contact Item</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherContactItemInsert') }}" method="post"
                        class="form-validate-3" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group calendar-form-filter">
                                        <label for="">Contact Type</label><span style="color: red;">*</span>
                                        <select class="form-control field-validate-3" name="type_int" id=""
                                            style="width: 100%;">
                                            <option value="">Choose one</option>
                                            @foreach ($contactTypeList as $key1 => $contactType)
                                                <option value="{{ $contactType->description_int }}">
                                                    {{ $contactType->description_txt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field form-group">
                                        <label class="form-check-label">Details</label><span style="color: red;">*</span>
                                        <input type="text" class="form-control field-validate-3"
                                            name="contactItem_txt" id="" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Contact Item Add Modal -->

    <!-- Contact Item Edit Modal -->
    <div class="modal fade" id="contactItemEditModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Teacher Contact Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="calendar-heading-sec">
                        <i class="fas fa-edit school-edit-icon"></i>
                        <h2>Edit Contact Item</h2>
                    </div>

                    <form action="{{ url('/candidate/logTeacherContactItemUpdate') }}" method="post"
                        class="form-validate-4" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-input-field-section">
                            <h6>
                                @if ($teacherDetail->knownAs_txt == '' || $teacherDetail->knownAs_txt == null)
                                    {{ $teacherDetail->firstName_txt }} {{ $teacherDetail->surname_txt }}
                                @else
                                    {{ $teacherDetail->knownAs_txt }} {{ $teacherDetail->surname_txt }}
                                @endif
                            </h6>
                            <span>ID</span>
                            <p>{{ $teacherDetail->teacher_id }}</p>
                            <input type="hidden" name="teacher_id" value="{{ $teacherDetail->teacher_id }}">
                            <input type="hidden" name="contactItemTch_id" id="ContactItemIdEdit" value="">

                            <div class="row" id="contactItemEditAjax"></div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer calendar-modal-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>

                            <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Contact Item Edit Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollY: '200px',
                paging: false,
                // footer: false,
                info: false,
                ordering: false
            });
        });

        function contactItemRowSelect(contactItemTch_id) {
            if ($('#editContactRow' + contactItemTch_id).hasClass('tableRowActive')) {
                $('#teacherContactItemId').val('');
                $('#editContactRow' + contactItemTch_id).removeClass('tableRowActive');
                $('#phoneContactItemBttn').addClass('disabled-link');
                $('#mailContactItemBttn').addClass('disabled-link');
                $('#editContactItemBttn').addClass('disabled-link');
            } else {
                $('#teacherContactItemId').val(contactItemTch_id);
                $('.editContactRow').removeClass('tableRowActive');
                $('#editContactRow' + contactItemTch_id).addClass('tableRowActive');
                $('#phoneContactItemBttn').removeClass('disabled-link');
                $('#mailContactItemBttn').removeClass('disabled-link');
                $('#editContactItemBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editContactItemBttn', function() {
            var teacherContactItemId = $('#teacherContactItemId').val();
            if (teacherContactItemId) {
                $('#ContactItemIdEdit').val(teacherContactItemId);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('teacherContactItemEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teacherContactItemId: teacherContactItemId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#contactItemEditAjax').html(data.html);
                    }
                });
                $('#contactItemEditModal').modal("show");
            } else {
                swal("", "Please select one contact.");
            }
        });
    </script>
@endsection
