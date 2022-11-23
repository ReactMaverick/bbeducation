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
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
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
                                    {{ date('M d Y H:i', strtotime($schoolDetail->contactOn_dtm)) }}
                                    @endif
                                    {{ '. Spoke to: ' . $schoolDetail->spokeTo_txt . ' and noted: ' . $schoolDetail->notes_txt . '.' }}
                                </p>
                                @else
                                <p>We have no record of previous contact with this school.</p>
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
                            <a href="#" class="disabled-link" id="deleteContactBttn">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            <a data-toggle="modal" data-target="#ContactAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                <i class="fa-solid fa-pencil school-edit-icon"></i>
                            </a>
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
                            @foreach ($schoolContacts as $key1 => $Contacts)
                            <tr class="school-detail-table-data" onclick="contactRowSelect({{ $Contacts->contact_id }})"
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
                <div class="school-details-first-sec">
                    <div class="details-table">
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
                                @foreach ($contactItems as $key2 => $Items)
                                <tr class="school-detail-table-data">
                                    <td>
                                        @if ($Items->schoolContact_id == '')
                                        {{ 'School Main' }}
                                        @else
                                        @if ($Items->firstName_txt != '' && $Items->surname_txt != '')
                                        {{ $Items->firstName_txt . ' ' . $Items->surname_txt }}
                                        @elseif ($Items->firstName_txt != '' && $Items->surname_txt == '')
                                        {{ $Items->firstName_txt }}
                                        @elseif ($Items->title_int != '' && $Items->surname_txt != '')
                                        {{ $Items->title_txt . ' ' . $Items->surname_txt }}
                                        @elseif ($Items->jobRole_int != '')
                                        {{ $Items->jobRole_txt . ' (name unknown)' }}
                                        @else
                                        {{ 'Name unknown' }}
                                        @endif
                                        @endif
                                    </td>
                                    <td>{{ $Items->type_txt }}</td>
                                    <td>{{ $Items->contactItem_txt }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div class="modal fade" id="DetailModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit School Address</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Address</h2>
                </div>

                <form action="{{ url('/schoolAddressUpdate') }}" method="post">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>{{ $schoolDetail->name_txt }}</h6>
                        <h6>ID</h6>
                        <h6>{{ $schoolDetail->school_id }}</h6>
                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                        <div class="modal-input-field">
                            <label class="form-check-label">Address</label>
                            <input type="text" class="form-control mb-1" name="address1_txt" id=""
                                value="{{ $schoolDetail->address1_txt }}">
                            <input type="text" class="form-control mb-1" name="address2_txt" id=""
                                value="{{ $schoolDetail->address2_txt }}">
                            <input type="text" class="form-control mb-1" name="address3_txt" id=""
                                value="{{ $schoolDetail->address3_txt }}">
                            <input type="text" class="form-control" name="address4_txt" id=""
                                value="{{ $schoolDetail->address4_txt }}">
                            {{-- <input type="text" class="form-control" name="" id="" value="{{ $schoolDetail->address5_txt }}">
                            --}}
                        </div>

                        <div class="modal-input-field">
                            <label class="form-check-label">Postcode</label>
                            <input type="text" class="form-control" name="postcode_txt" id=""
                                value="{{ $schoolDetail->postcode_txt }}">
                        </div>

                        <div class="modal-input-field">
                            <label class="form-check-label">Base Rate</label>
                            <input type="number" class="form-control" name="baseRate_dec" id=""
                                value="{{ $schoolDetail->baseRate_dec }}">
                        </div>

                        <a href="#">Get Grid References</a>

                        <div class="modal-input-field">
                            <label class="form-check-label">Grid References</label>
                            <h6>{{ $schoolDetail->lat_txt . ', ' . $schoolDetail->lon_txt }}</h6>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Address Modal -->

    <!-- Contact Add Modal -->
    <div class="modal fade" id="ContactAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Add School Contact Person</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Add Contact Person</h2>
                </div>

                <form action="{{ url('/schoolContactInsert') }}" method="post">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>{{ $schoolDetail->name_txt }}</h6>
                        <h6>ID</h6>
                        <h6>{{ $schoolDetail->school_id }}</h6>
                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

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

                        <div class="modal-input-field">
                            <label class="form-check-label">First Name</label>
                            <input type="text" class="form-control" name="firstName_txt" id="" value="">
                        </div>

                        <div class="modal-input-field">
                            <label class="form-check-label">Surname</label>
                            <input type="text" class="form-control" name="surname_txt" id="" value="">
                        </div>

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
                            <label class="form-check-label" for="receiveVetting_status">Receive Vetting
                                Confirmations</label>
                            <input type="checkbox" class="" name="receiveVetting_status" id="receiveVetting_status"
                                value="1">
                        </div>

                        <div class="modal-side-field">
                            <label class="form-check-label" for="receiveTimesheets_status">Receive
                                Timesheets/Invoices</label>
                            <input type="checkbox" class="" name="receiveTimesheets_status"
                                id="receiveTimesheets_status" value="1">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Contact Add Modal -->

    <!-- Contact Edit Modal -->
    <div class="modal fade" id="ContactEditModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit School Contact Person</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Contact Person</h2>
                </div>

                <form action="{{ url('/schoolContactUpdate') }}" method="post">
                    @csrf
                    <input type="hidden" name="editContactId" id="editContactId" value="">
                    <div class="modal-input-field-section">
                        <h6>{{ $schoolDetail->name_txt }}</h6>
                        <h6>ID</h6>
                        <h6>{{ $schoolDetail->school_id }}</h6>
                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

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

                        <div class="modal-input-field">
                            <label class="form-check-label">First Name</label>
                            <input type="text" class="form-control" name="firstName_txt" id="" value="">
                        </div>

                        <div class="modal-input-field">
                            <label class="form-check-label">Surname</label>
                            <input type="text" class="form-control" name="surname_txt" id="" value="">
                        </div>

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
                            <label class="form-check-label" for="receiveVetting_status">Receive Vetting
                                Confirmations</label>
                            <input type="checkbox" class="" name="receiveVetting_status" id="receiveVetting_status"
                                value="1">
                        </div>

                        <div class="modal-side-field">
                            <label class="form-check-label" for="receiveTimesheets_status">Receive
                                Timesheets/Invoices</label>
                            <input type="checkbox" class="" name="receiveTimesheets_status"
                                id="receiveTimesheets_status" value="1">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Contact Edit Modal -->

    <script>
    function contactRowSelect(contact_id) {
        if ($('#editContactRow' + contact_id).hasClass('tableRowActive')) {
            $('#editContactId').val('');
            $('#editContactRow' + contact_id).removeClass('tableRowActive');
            $('#deleteContactBttn').addClass('disabled-link');
            $('#editContactBttn').addClass('disabled-link');
        } else {
            $('#editContactId').val(contact_id);
            $('#editContactRow' + contact_id).addClass('tableRowActive');
            $('#deleteContactBttn').removeClass('disabled-link');
            $('#editContactBttn').removeClass('disabled-link');
        }
    }

    // $(document).ready(function(){
    //     $('#editContactBttn').click(function(){
    //         $('#ContactEditModal').modal('show');
    //     })
    // })

    $(document).on('click', '#editContactBttn', function() {
        console.log('edit modal');
        $('#ContactEditModal').modal("show");
    });
    </script>
    @endsection