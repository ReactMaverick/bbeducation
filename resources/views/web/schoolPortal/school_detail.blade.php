@extends('web.schoolPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.schoolPortal.school_header')
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
                                                    {{-- @if ($schoolDetail->address5_txt)
                                                        <p>{{ $schoolDetail->address5_txt }}</p>
                                                    @endif --}}
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
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="school-detail-right-sec">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="school-details-contact-second-sec sec_box_edit">
                                        <div class="details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Contacts</h2>
                                            </div>
                                            <div class="contact-icon-sec">
                                                {{-- <a style="cursor: pointer" class="disabled-link" id="deleteContactBttn">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a> --}}
                                                <a data-toggle="modal" data-target="#ContactAddModal"
                                                    style="cursor: pointer;">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                                    <i class="fas fa-edit school-edit-icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="about-school-section">
                                            <table class="table table-striped" id="myTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Job Role</th>
                                                        <th>Name</th>
                                                        <th>T/S</th>
                                                        <th>Vet.</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($schoolContacts as $key1 => $Contacts)
                                                        <tr class="school-detail-table-data editContactRow"
                                                            onclick="contactRowSelect({{ $Contacts->contact_id }}, {{ $school_id }})"
                                                            id="editContactRow{{ $Contacts->contact_id }}">
                                                            <td>{{ $Contacts->jobRole_txt }}</td>
                                                            <td>
                                                                @if ($Contacts->firstName_txt != '' && $Contacts->surname_txt != '')
                                                                    {{ $Contacts->firstName_txt . ' ' . $Contacts->surname_txt }}
                                                                @elseif ($Contacts->firstName_txt != '' && $Contacts->surname_txt == '')
                                                                    {{ $Contacts->firstName_txt }}
                                                                @elseif ($Contacts->title_int != '' && $Contacts->surname_txt != '')
                                                                    {{ $Contacts->title_txt . ' ' . $Contacts->surname_txt }}
                                                                @elseif ($Contacts->jobRole_int != '')
                                                                    {{ $Contacts->jobRole_txt . ' (name unknown)' }}
                                                                @else
                                                                    {{ 'Name unknown' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($Contacts->receiveTimesheets_status != 0)
                                                                    {{ 'Y' }}
                                                                @else
                                                                    {{ 'N' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($Contacts->receiveVetting_status != 0)
                                                                    {{ 'Y' }}
                                                                @else
                                                                    {{ 'N' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="school-details-first-sec sec_box_edit">
                                        <div class="details-table">
                                            <div class="details-heading">
                                                <div class="contact-heading-text">
                                                    <h2>Contact Items</h2>
                                                </div>
                                                <div class="contact-icon-sec">
                                                    {{-- <a style="cursor: pointer" class="disabled-link"
                                                        id="deleteContactItemBttn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a> --}}
                                                    <a data-toggle="modal" data-target="#ContactItemAddModal"
                                                        style="cursor: pointer;">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </a>
                                                    <a style="cursor: pointer;" class="disabled-link"
                                                        id="editContactItemBttn">
                                                        <i class="fas fa-edit school-edit-icon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                            <div class="about-school-section">
                                                <input type="hidden" name="editContactItemName" id="editContactItemName"
                                                    value="">
                                                <table class="table table-striped" id="">
                                                    <thead>
                                                        <tr class="school-detail-table-heading">
                                                            <th>Person</th>
                                                            <th>Type</th>
                                                            <th>Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-body-sec" id="contactItemAjxView">
                                                        @if (count($contactItems) > 0)
                                                            @foreach ($contactItems as $key2 => $Items)
                                                                <?php
                                                                $pName = '';
                                                                if ($Items->schoolContact_id == '') {
                                                                    $pName = 'School Main';
                                                                } else {
                                                                    if ($Items->firstName_txt != '' && $Items->surname_txt != '') {
                                                                        $pName = $Items->firstName_txt . ' ' . $Items->surname_txt;
                                                                    } elseif ($Items->firstName_txt != '' && $Items->surname_txt == '') {
                                                                        $pName = $Items->firstName_txt;
                                                                    } elseif ($Items->title_int != '' && $Items->surname_txt != '') {
                                                                        $pName = $Items->title_txt . ' ' . $Items->surname_txt;
                                                                    } elseif ($Items->jobRole_int != '') {
                                                                        $pName = $Items->jobRole_txt . ' (name unknown)';
                                                                    } else {
                                                                        $pName = 'Name unknown';
                                                                    }
                                                                }
                                                                ?>

                                                                <tr class="school-detail-table-data editContactItemRow"
                                                                    id="editContactItemRow{{ $Items->contactItemSch_id }}"
                                                                    onclick="contactItemRowSelect({{ $Items->contactItemSch_id }}, '<?php echo $pName; ?>')">
                                                                    <td>
                                                                        {{ $pName }}
                                                                    </td>
                                                                    <td>{{ $Items->type_txt }}</td>
                                                                    <td>{{ $Items->contactItem_txt }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3">
                                                                    Empty contact item.
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Modal -->
                <div class="modal fade" id="DetailModal">
                    <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
                        <div class="modal-content calendar-modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header calendar-modal-header">
                                <h4 class="modal-title">Edit School Address</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="calendar-heading-sec">
                                    <i class="fas fa-edit school-edit-icon"></i>
                                    <h2>Edit Address</h2>
                                </div>

                                <form action="{{ url('/schoolAddressUpdate') }}" method="post">
                                    @csrf
                                    <div class="modal-input-field-section">
                                        <div class="skd_content">
                                            <h6>{{ $schoolDetail->name_txt }}</h6>

                                            <p>ID: {{ $schoolDetail->school_id }}</p>
                                        </div>

                                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">Address</label>
                                                    <input type="text" class="form-control mb-1" name="address1_txt"
                                                        id="" value="{{ $schoolDetail->address1_txt }}">
                                                    <input type="text" class="form-control mb-1" name="address2_txt"
                                                        id="" value="{{ $schoolDetail->address2_txt }}">
                                                    <input type="text" class="form-control mb-1" name="address3_txt"
                                                        id="" value="{{ $schoolDetail->address3_txt }}">
                                                    <input type="text" class="form-control" name="address4_txt"
                                                        id="" value="{{ $schoolDetail->address4_txt }}">
                                                    {{-- <input type="text" class="form-control" name="" id="" value="{{ $schoolDetail->address5_txt }}">
                                    --}}
                                                </div>

                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">Postcode</label>
                                                    <input type="text" class="form-control" name="postcode_txt"
                                                        id="" value="{{ $schoolDetail->postcode_txt }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 modal-form-right-sec">
                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">Website</label>
                                                    <input type="text" class="form-control" name="website_txt"
                                                        id="" value="{{ $schoolDetail->website_txt }}">
                                                </div>

                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">Base Rate</label>
                                                    <input type="number" class="form-control" name="baseRate_dec"
                                                        id="" value="{{ $schoolDetail->baseRate_dec }}">
                                                </div>
                                                <div class="modal-grid-reference-text">
                                                    <a href="#">Get Grid References</a>
                                                </div>


                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">Grid References</label>
                                                    <h2>{{ $schoolDetail->lat_txt . ', ' . $schoolDetail->lon_txt }}</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer calendar-modal-footer">
                                        <button type="submit" class="btn btn-secondary">Submit</button>

                                        <button type="button" class="btn btn-danger cancel-btn"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Address Modal -->

                <!-- Contact Add Modal -->
                <div class="modal fade" id="ContactAddModal">
                    <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
                        <div class="modal-content calendar-modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header calendar-modal-header">
                                <h4 class="modal-title">Add School Contact Person</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="calendar-heading-sec">
                                    <i class="fas fa-edit school-edit-icon"></i>
                                    <h2>Add Contact Person</h2>
                                </div>

                                <form action="{{ url('/school/logSchoolContactInsert') }}" method="post">
                                    @csrf
                                    <div class="modal-input-field-section">
                                        <div class="skd_content">
                                            <h6>{{ $schoolDetail->name_txt }}</h6>

                                            <p>ID: {{ $schoolDetail->school_id }}</p>
                                        </div>
                                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group calendar-form-filter">
                                                    <label for="">Title</label>
                                                    <select class="form-control" name="title_int">
                                                        <option value="">Choose one</option>
                                                        @foreach ($titleList as $key1 => $title)
                                                            <option value="{{ $title->description_int }}">
                                                                {{ $title->description_txt }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">First Name</label>
                                                    <input type="text" class="form-control" name="firstName_txt"
                                                        id="" value="">
                                                </div>

                                                <div class="modal-input-field form-group">
                                                    <label class="form-check-label">Surname</label>
                                                    <input type="text" class="form-control" name="surname_txt"
                                                        id="" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 modal-form-right-sec">
                                                <div class="form-group calendar-form-filter">
                                                    <label for="">Job Role</label>
                                                    <select class="form-control" name="jobRole_int">
                                                        <option value="">Choose one</option>
                                                        @foreach ($jobRoleList as $key2 => $jobRole)
                                                            <option value="{{ $jobRole->description_int }}">
                                                                {{ $jobRole->description_txt }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="modal-side-field">
                                                    <label class="form-check-label" for="receiveVetting_status">Receive
                                                        Vetting
                                                        Confirmations</label>
                                                    <input type="checkbox" class="" name="receiveVetting_status"
                                                        id="receiveVetting_status" value="1">
                                                </div>

                                                <div class="modal-side-field">
                                                    <label class="form-check-label" for="receiveTimesheets_status">Receive
                                                        Timesheets/Invoices</label>
                                                    <input type="checkbox" class="" name="receiveTimesheets_status"
                                                        id="receiveTimesheets_status" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer calendar-modal-footer">
                                        <button type="submit" class="btn btn-secondary">Submit</button>

                                        <button type="button" class="btn btn-danger cancel-btn"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Contact Add Modal -->

                <!-- Contact Edit Modal -->
                <div class="modal fade" id="ContactEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
                        <div class="modal-content calendar-modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header calendar-modal-header">
                                <h4 class="modal-title">Edit School Contact Person</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="calendar-heading-sec">
                                    <i class="fas fa-edit school-edit-icon"></i>
                                    <h2>Edit Contact Person</h2>
                                </div>
                                <form action="{{ url('/school/logSchoolContactUpdate') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="editContactId" id="editContactId" value="">
                                    <div class="modal-input-field-section">
                                        <div class="skd_content">
                                            <h6>{{ $schoolDetail->name_txt }}</h6>

                                            <p>ID: {{ $schoolDetail->school_id }}</p>
                                        </div>
                                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                                        <div id="contactEditAjax"></div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer calendar-modal-footer">
                                        <button type="submit" class="btn btn-secondary">Submit</button>

                                        <button type="button" class="btn btn-danger cancel-btn"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Edit Modal -->

                <!-- Contact Item Add Modal -->
                <div class="modal fade" id="ContactItemAddModal">
                    <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
                        <div class="modal-content calendar-modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header calendar-modal-header">
                                <h4 class="modal-title">Add School Contact Item</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="calendar-heading-sec">
                                    <i class="fas fa-edit school-edit-icon"></i>
                                    <h2>Add Contact Item</h2>
                                </div>

                                <form action="{{ url('/school/logSchoolContactItemInsert') }}" method="post"
                                    class="form-validate">
                                    @csrf
                                    <div class="modal-input-field-section">
                                        <div class="skd_content">
                                            <h6>{{ $schoolDetail->name_txt }}</h6>

                                            <p>ID: {{ $schoolDetail->school_id }}</p>
                                        </div>
                                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group calendar-form-filter">
                                                    <label for="">Contact Method</label>
                                                    <select class="form-control field-validate" name="type_int"
                                                        id="contactMethodId">
                                                        <option value="">Choose one</option>
                                                        @foreach ($contactMethodList as $key1 => $contactMethod)
                                                            <option value="{{ $contactMethod->description_int }}">
                                                                {{ $contactMethod->description_txt }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="modal-side-field">
                                                    <label class="form-check-label" for="invoiceContact">Invoice
                                                        Contact</label>
                                                    <input type="checkbox" class="" name="receiveInvoices_status"
                                                        id="invoiceContact" value="1" disabled>
                                                </div>

                                                <div class="form-group modal-input-field">
                                                    <label class="form-check-label">Details (number/email etc.)</label>
                                                    <input type="text" class="form-control field-validate"
                                                        name="contactItem_txt" id="" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 modal-form-right-sec">
                                                <div class="modal-side-field">
                                                    <label class="form-check-label" for="schoolMainId">School Main (not
                                                        specific
                                                        person)</label>
                                                    <input type="checkbox" class="" name="schoolMainId"
                                                        id="schoolMainId" value="1" checked>
                                                </div>

                                                <div class="form-group calendar-form-filter">
                                                    <label for="">Contact Person</label>
                                                    <select class="form-control" name="schoolContact_id"
                                                        id="schoolContactId">
                                                        <option value="">Choose one</option>
                                                        @foreach ($schoolContacts as $key2 => $Contacts)
                                                            <?php
                                                            $cName = '';
                                                            if ($Contacts->firstName_txt != '' && $Contacts->surname_txt != '') {
                                                                $cName = $Contacts->firstName_txt . ' ' . $Contacts->surname_txt;
                                                            } elseif ($Contacts->firstName_txt != '' && $Contacts->surname_txt == '') {
                                                                $cName = $Contacts->firstName_txt;
                                                            } elseif ($Contacts->title_int != '' && $Contacts->surname_txt != '') {
                                                                $cName = $Contacts->title_txt . ' ' . $Contacts->surname_txt;
                                                            } elseif ($Contacts->jobRole_int != '') {
                                                                $cName = $Contacts->jobRole_txt . ' (name unknown)';
                                                            } else {
                                                                $cName = 'Name unknown';
                                                            }
                                                            ?>

                                                            <option value="{{ $Contacts->contact_id }}">
                                                                {{ $cName }}
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

                                        <button type="button" class="btn btn-danger cancel-btn"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Contact Item Add Modal -->

                <!-- Contact Item Edit Modal -->
                <div class="modal fade" id="ContactItemEditModal">
                    <div class="modal-dialog modal-lg modal-dialog-centered calendar-modal-section">
                        <div class="modal-content calendar-modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header calendar-modal-header">
                                <h4 class="modal-title">Edit School Contact Item</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="calendar-heading-sec">
                                    <i class="fas fa-edit school-edit-icon"></i>
                                    <h2>Edit Contact Item</h2>
                                </div>

                                <form action="{{ url('/school/logSchoolContactItemUpdate') }}" method="post"
                                    class="form-validate-2">
                                    @csrf
                                    <input type="hidden" name="editContactItemId" id="editContactItemId"
                                        value="">
                                    <div class="modal-input-field-section">
                                        <div class="skd_content">
                                            <h6>{{ $schoolDetail->name_txt }}</h6>

                                            <p>ID: {{ $schoolDetail->school_id }}</p>
                                        </div>

                                        <input type="hidden" name="school_id" id="contactItemSchoolId"
                                            value="{{ $schoolDetail->school_id }}">

                                        <div id="AjaxContactItemEdit"></div>

                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer calendar-modal-footer">
                                        <button type="submit" class="btn btn-secondary">Submit</button>

                                        <button type="button" class="btn btn-danger cancel-btn"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Item Edit Modal -->

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        function contactRowSelect(contact_id, school_id) {
            if ($('#editContactRow' + contact_id).hasClass('tableRowActive')) {
                $('#editContactId').val('');
                $('#editContactRow' + contact_id).removeClass('tableRowActive');
                $('#deleteContactBttn').addClass('disabled-link');
                $('#editContactBttn').addClass('disabled-link');

                $('#editContactItemId').val('');
                $('#deleteContactItemBttn').addClass('disabled-link');
                $('#editContactItemBttn').addClass('disabled-link');

                var selectStat = 'No';
                fetchContactItem(school_id, contact_id, selectStat);

                $('#schoolContactId').val('');
                $('#schoolMainId').prop('checked', true);
            } else {
                $('#editContactId').val(contact_id);
                $('.editContactRow').removeClass('tableRowActive');
                $('#editContactRow' + contact_id).addClass('tableRowActive');
                $('#deleteContactBttn').removeClass('disabled-link');
                $('#editContactBttn').removeClass('disabled-link');

                var selectStat = 'Yes';
                fetchContactItem(school_id, contact_id, selectStat);

                $('#schoolContactId').val(contact_id);
                $('#schoolMainId').prop('checked', false);
            }
        }

        $(document).on('click', '#editContactBttn', function() {
            var contact_id = $('#editContactId').val();
            if (contact_id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/school/logSchoolContactDetail') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        contact_id: contact_id
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#contactEditAjax').html(data.html);
                    }
                });
                $('#ContactEditModal').modal("show");
            } else {
                swal("", "Please select one contact.");
            }
        });

        $(document).on('click', '#deleteContactBttn', function() {
            var contact_id = $('#editContactId').val();
            if (contact_id) {
                swal({
                        title: "",
                        text: "Are you sure you wish to remove this member of staff?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('/school/logSchoolContactDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        contact_id: contact_id
                                    },
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one contact.");
            }
        });

        $(document).on('change', '#contactMethodId', function() {
            var contactMethodId = $(this).val();
            if (contactMethodId == 1) {
                $("#invoiceContact").attr("disabled", false);
            } else {
                $('#invoiceContact').prop('checked', false);
                $("#invoiceContact").attr("disabled", true);
            }
        });

        $(document).on('change', '#schoolMainId', function() {
            if ($(this).is(":checked")) {
                $('#schoolContactId').val('');
            }
        });

        $(document).on('change', '#schoolContactId', function() {
            var schoolContactId = $(this).val();
            if (schoolContactId != '') {
                $('#schoolMainId').prop('checked', false);
            } else {
                $('#schoolMainId').prop('checked', true);
            }
        });

        function fetchContactItem(school_id, contact_id, selectStat) {
            $.ajax({
                type: 'POST',
                url: '{{ url('fetchContactItemList') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    school_id: school_id,
                    contact_id: contact_id,
                    selectStat: selectStat
                },
                success: function(data) {
                    //console.log(data);
                    $('#contactItemAjxView').html(data.html);
                }
            });
        }

        function contactItemRowSelect(contactItemSch_id, name) {
            if ($('#editContactItemRow' + contactItemSch_id).hasClass('tableRowActive')) {
                $('#editContactItemId').val('');
                $('#editContactItemName').val('');
                $('#editContactItemRow' + contactItemSch_id).removeClass('tableRowActive');
                $('#deleteContactItemBttn').addClass('disabled-link');
                $('#editContactItemBttn').addClass('disabled-link');
            } else {
                $('#editContactItemId').val(contactItemSch_id);
                $('#editContactItemName').val(name);
                $('.editContactItemRow').removeClass('tableRowActive');
                $('#editContactItemRow' + contactItemSch_id).addClass('tableRowActive');
                $('#deleteContactItemBttn').removeClass('disabled-link');
                $('#editContactItemBttn').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editContactItemBttn', function() {
            var editContactItemId = $('#editContactItemId').val();
            var contactItemSchoolId = $('#contactItemSchoolId').val();
            if (editContactItemId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/school/logSchoolContactItemDetail') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        editContactItemId: editContactItemId,
                        contactItemSchoolId: contactItemSchoolId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#AjaxContactItemEdit').html(data.html);
                    }
                });
                $('#ContactItemEditModal').modal("show");
            } else {
                swal("", "Please select one contact item.");
            }
        });

        $(document).on('change', '#editContactMethodId', function() {
            var editContactMethodId = $(this).val();
            if (editContactMethodId == 1) {
                $("#editInvoiceContact").attr("disabled", false);
            } else {
                $('#editInvoiceContact').prop('checked', false);
                $("#editInvoiceContact").attr("disabled", true);
            }
        });

        $(document).on('change', '#editSchoolMainId', function() {
            if ($(this).is(":checked")) {
                $('#editSchoolContactId').val('');
            }
        });

        $(document).on('change', '#editSchoolContactId', function() {
            var editSchoolContactId = $(this).val();
            if (editSchoolContactId != '') {
                $('#editSchoolMainId').prop('checked', false);
            } else {
                $('#editSchoolMainId').prop('checked', true);
            }
        });

        $(document).on('click', '#deleteContactItemBttn', function() {
            var editContactItemId = $('#editContactItemId').val();
            var editContactItemName = $('#editContactItemName').val();
            if (editContactItemId) {
                swal({
                        title: "",
                        text: "Are you sure you wish to delete this contact item for " + editContactItemName +
                            "?",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('/school/logSchoolContactItemDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        editContactItemId: editContactItemId
                                    },
                                    success: function(data) {
                                        $('#editContactItemRow' + editContactItemId).remove();
                                        // location.reload();
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one contact item.");
            }
        });
    </script>
@endsection
