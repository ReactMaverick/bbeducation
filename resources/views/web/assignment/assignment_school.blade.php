{{-- @extends('web.layout') --}}
@extends('web.assignment.assignment_layout')
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

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="assignment-school-detail-right-sec">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="assignment-school-details-first-sec sec_box_edit">
                                        <div class="details-heading">
                                            <h2>School Details</h2>
                                            <a href="{{ url('/school-detail/' . $school_id) }}"
                                                class="contact-icon-sec icon_all" target="_blank">
                                                <i class="fas fa-school"></i>
                                            </a>
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
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12"></div>
                            </div>
                        </div>

                        <div class="assignment-school-detail-right-sec mt-3">
                            <div class="row my_row_gap">
                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="assignment-school-details-contact-second-sec sec_box_edit">
                                        <div class="contact-heading details-heading">
                                            <div class="contact-heading-text">
                                                <h2>Contacts</h2>
                                            </div>
                                        </div>

                                        <div class="assignment-candidate-table-section">
                                            <table class="table table-bordered table-striped" id="myTable">
                                                <thead>
                                                    <tr class="school-detail-table-heading">
                                                        <th>Job Role</th>
                                                        <th>Name</th>
                                                        <th>Vet.</th>
                                                        <th>T/S </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-body-sec">
                                                    @foreach ($schoolContacts as $key1 => $Contacts)
                                                        <tr class="school-detail-table-data">
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

                                <div class="col-md-6 col-lg-6 col-xl-6 col-12 col-sm-12">
                                    <div class="assignment-school-details-first-sec sec_box_edit">
                                        <div class="details-table">
                                            <div class="contact-heading details-heading">
                                                <div class="contact-heading-text">
                                                    <h2>Contact Items</h2>
                                                </div>
                                                <div class="contact-icon-sec">
                                                    <a style="cursor: pointer;" class="disabled-link icon_all"
                                                        id="phoneContactItemBttn">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </a>
                                                    <a style="cursor: pointer;" class="disabled-link icon_all"
                                                        id="mailContactItemBttn">
                                                        <i class="fas fa-envelope-open-text"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <input type="hidden" name="editContactItemName" id="editContactItemName"
                                                value="">
                                            <div class="assignment-candidate-table-section">
                                                <table class="table table-bordered table-striped" id="myTable1">
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
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        $(document).ready(function() {
            $('#myTable, #myTable1').DataTable({
                scrollY: '300px',
                paging: false,
                footer: false,
                info: false,
                ordering: false,
                searching: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function contactItemRowSelect(contactItemSch_id, name) {
            if ($('#editContactItemRow' + contactItemSch_id).hasClass('tableRowActive')) {
                $('#editContactItemId').val('');
                $('#editContactItemName').val('');
                $('#editContactItemRow' + contactItemSch_id).removeClass('tableRowActive');
                $('#phoneContactItemBttn').addClass('disabled-link');
                $('#mailContactItemBttn').addClass('disabled-link');
            } else {
                $('#editContactItemId').val(contactItemSch_id);
                $('#editContactItemName').val(name);
                $('.editContactItemRow').removeClass('tableRowActive');
                $('#editContactItemRow' + contactItemSch_id).addClass('tableRowActive');
                $('#phoneContactItemBttn').removeClass('disabled-link');
                $('#mailContactItemBttn').removeClass('disabled-link');
            }
        }
    </script>
@endsection
