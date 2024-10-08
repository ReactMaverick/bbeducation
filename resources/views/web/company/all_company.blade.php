{{-- @extends('web.layout') --}}
@php
    $webUserLoginData = Session::get('webUserLoginData');
@endphp
@extends('web.superAdmin.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="assignment-detail-page-section">
                <div class="row assignment-detail-row">

                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 topbar-sec">

                        <div class="school-assignment-sec">
                            <div class="school-assignment-section sec_box_edit mt-3">

                                <div class="teacher-list-section details-heading">
                                    <div class="school-teacher-heading-text">
                                        <h2>All Companies</h2>
                                    </div>
                                    <div class="school-teacher-list-heading">
                                        <div class="school-assignment-contact-icon-sec contact-icon-sec">
                                            <a style="cursor: pointer;" class="disabled-link icon_all" title="Users"
                                                id="companyUsers">
                                                <i class="fa fa-users" aria-hidden="true"></i>
                                            </a>
                                            <a style="cursor: pointer" class="disabled-link icon_all" id="deleteCompanyBttn"
                                                title="Delete company !">
                                                <i class="fas fa-trash-alt trash-icon"></i>
                                            </a>
                                            <a href="{{ url('/create-company') }}" style="cursor: pointer;" class="icon_all"
                                                title="Add new company">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>

                                            {{-- <a style="cursor: pointer;" class="disabled-link icon_all" id="passwordReset"
                                                title="Send to school">
                                                <i class="fas fa-paper-plane"></i>
                                            </a> --}}
                                            <a style="cursor: pointer;" class="disabled-link icon_all"
                                                id="editContactHistoryBttn" title="Edit Company">
                                                <i class="fas fa-edit school-edit-icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="assignment-finance-table-section">
                                    <table class="table table-bordered table-striped" id="myTable">
                                        <thead>
                                            <tr class="school-detail-table-heading">
                                                <th style="width: 25%">Company Name</th>
                                                <th>Company Telephone</th>
                                                <th>Company Address</th>
                                                <th>Users</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body-sec">
                                            <?php $dueCallCount = 0; ?>
                                            @foreach ($companies as $key => $company)
                                                <tr class="school-detail-table-data editContactHistoryRow"
                                                    id="editContactHistoryRow{{ $company->company_id }}"
                                                    onclick="contactHistoryRowSelect({{ $company->company_id }})"
                                                    data-id={{ $company->company_id }}>
                                                    <td style="width: 25%">{{ $company->company_name }}</td>
                                                    <td>{{ $company->company_phone }}</td>
                                                    <td>
                                                        @if ($company->address1_txt)
                                                            {{ $company->address1_txt . ', ' }}
                                                        @endif
                                                        @if ($company->address2_txt)
                                                            {{ $company->address2_txt . ', ' }}
                                                        @endif
                                                        @if ($company->address3_txt)
                                                            {{ $company->address3_txt . ', ' }}
                                                        @endif
                                                        @if ($company->address4_txt)
                                                            {{ $company->address4_txt . ', ' }}
                                                        @endif
                                                        @if ($company->address5_txt)
                                                            {{ $company->address5_txt . ', ' }}
                                                        @endif
                                                        @if ($company->postcode_txt)
                                                            {{ $company->postcode_txt }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $company->user_count }}</td>
                                                    <td>
                                                        {{ $company->created_at ? date('d M Y', strtotime($company->created_at)) : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="companyId" id="companyId" value="">

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: false,
                responsive: true,
                lengthChange: true,
                autoWidth: true,
            });
        });

        function contactHistoryRowSelect(adminUser_id) {
            if ($('#editContactHistoryRow' + adminUser_id).hasClass('tableRowActive')) {
                $('#companyId').val('');
                $('#editContactHistoryRow' + adminUser_id).removeClass('tableRowActive');
                $('#deleteCompanyBttn').addClass('disabled-link');
                $('#editContactHistoryBttn').addClass('disabled-link');
                $('#companyUsers').addClass('disabled-link');
                $('#passwordReset').addClass('disabled-link');
            } else {
                $('#companyId').val(adminUser_id);
                $('.editContactHistoryRow').removeClass('tableRowActive');
                $('#editContactHistoryRow' + adminUser_id).addClass('tableRowActive');
                $('#deleteCompanyBttn').removeClass('disabled-link');
                $('#editContactHistoryBttn').removeClass('disabled-link');
                $('#companyUsers').removeClass('disabled-link');
                $('#passwordReset').removeClass('disabled-link');
            }
        }

        $(document).on('click', '#editContactHistoryBttn', function() {
            var companyId = $('#companyId').val();
            if (companyId) {
                window.location.href = "{{ url('/editCompany') }}/" + companyId;
            } else {
                swal("", "Please select one contact.");
            }
        });

        $(document).on('click', '#deleteCompanyBttn', function() {
            var companyId = $('#companyId').val();
            if (companyId) {
                swal({
                        title: "Alert",
                        text: "Are you sure you wish to remove this comapny ?",
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
                                    url: "{{ url('/deleteCompany') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        companyId: companyId
                                    },
                                    success: function(data) {
                                        swal({
                                            title: 'Success!',
                                            text: 'Company Deleted Successfully!',
                                            icon: 'success',
                                            buttons: {
                                                confirm: 'OK',
                                            },
                                        }).then((value) => {
                                            if (value) {
                                                location.reload();
                                            }
                                        });
                                    }
                                });
                        }
                    });
            } else {
                swal("", "Please select one user.");
            }
        });

        $(document).on('click', '#companyUsers', function() {
            var companyId = $('#companyId').val();
            if (companyId) {
                window.location.href = "{{ url('/companyUsers') }}/" + companyId;
            } else {
                swal("", "Please select one contact.");
            }
        });
    </script>
@endsection
