{{-- @extends('web.layout') --}}
@extends('web.teacher.teacher_layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .teacher-document-second-heading-text {
            width: 30%;
        }

        .teacher-document-second-name-text {
            width: 5%;
        }

        .teacher-document-third-name-text {
            width: 65%;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.teacher.teacher_header')
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

                        <div class="school-detail-right-sec">
                            <div class="row my_row_gap">
                                <div class="col-md-8 col-lg-8 col-xl-8 col-12 col-sm-12">
                                    <div class="teacher-health-second-sec sec_box_edit" style="width: 100%;">
                                        <div class="details-heading">
                                            <h2>Vetting History</h2>
                                        </div>

                                        <div class="teacher-document-first-sec">
                                            <div class="teacher-document-section about-school-section">
                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Vetting Update Service</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->vetUpdateService_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetUpdateServiceChecked_dte']))
                                                                @foreach ($vettingHistory['vetUpdateServiceChecked_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">List 99</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->vetList99Checked_dte != null ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetList99Checked_dte']))
                                                                @foreach ($vettingHistory['vetList99Checked_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Nctl Check</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->vetNCTLChecked_dte != null ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetNCTLChecked_dte']))
                                                                @foreach ($vettingHistory['vetNCTLChecked_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                {{-- <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Disqualification Check</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1" disabled
                                                            {{ $teacherDetail->vetDisqualAssociation_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetDisqualAssociation_dte']))
                                                                @foreach ($vettingHistory['vetDisqualAssociation_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div> --}}

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">Safeguarding Induction</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->safeguardingInduction_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['safeguardingInduction_dte']))
                                                                @foreach ($vettingHistory['safeguardingInduction_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <label for="vehicle1">s128 Management Check</label>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->vets128_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vets128_dte']))
                                                                @foreach ($vettingHistory['vets128_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>EEA Restriction Check</h2>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->vetEEARestriction_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetEEARestriction_dte']))
                                                                @foreach ($vettingHistory['vetEEARestriction_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>
                                                            Right to Work
                                                            @if ($teacherDetail->rightToWork_txt)
                                                                ({{ $teacherDetail->rightToWork_txt }})
                                                            @endif
                                                        </h2>
                                                    </div>
                                                    {{-- <div class="teacher-document-second-text">
                                                        <p>{{ $teacherDetail->rightToWork_txt }}</p>
                                                    </div> --}}
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1"
                                                            disabled
                                                            {{ $teacherDetail->rightToWork_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['rightToWork_dte']))
                                                                @foreach ($vettingHistory['rightToWork_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>
                                                            Overseas Police
                                                            @if ($teacherDetail->overseasPolicy_txt)
                                                                ({{ $teacherDetail->overseasPolicy_txt }})
                                                            @endif
                                                        </h2>
                                                    </div>
                                                    {{-- <div class="teacher-document-second-text">
                                                        <p>{{ $teacherDetail->overseasPolicy_txt }}</p>
                                                    </div> --}}
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->overseasPolicy_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['overseasPolicy_dte']))
                                                                @foreach ($vettingHistory['overseasPolicy_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                {{-- <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>Redicalisation Check</h2>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name="" value="1" disabled
                                                            {{ $teacherDetail->vetRadical_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetRadical_dte']))
                                                                @foreach ($vettingHistory['vetRadical_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div> --}}

                                                <div class="school-name-section">
                                                    <div class="teacher-document-second-heading-text">
                                                        <h2>Qualifications Check</h2>
                                                    </div>
                                                    <div class="teacher-document-second-name-text">
                                                        <input type="checkbox" id="" name=""
                                                            value="1" disabled
                                                            {{ $teacherDetail->vetQualification_status == '-1' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="teacher-document-third-name-text">
                                                        <p>
                                                            @if (isset($vettingHistory['vetQualification_dte']))
                                                                @foreach ($vettingHistory['vetQualification_dte'] as $key => $val)
                                                                    @if ($key > 0)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                    {{ date('d-m-Y', strtotime($val->check_date)) }}
                                                                    <a style="cursor: pointer;"
                                                                        onclick="historyEdit('{{ $val->vetting_check_history_id }}')"><i
                                                                            class="fa-solid fa-pencil"></i></a>
                                                                @endforeach
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

                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="vettingHistoryEditModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content" style="width:65%;">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Edit Date</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Edit Date</h2>
                </div>

                <form action="{{ url('/teacherVettingHistoryUpdate') }}" method="post" class="form-validate"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-input-field-section">
                        <input type="hidden" name="vetting_check_history_id" id="vettingCheckHistoryId" value="">

                        <div class="row" id="vettingHistoryEditDiv"></div>
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

    <script>
        function historyEdit(vetting_check_history_id) {
            if (vetting_check_history_id) {
                $('#vettingCheckHistoryId').val(vetting_check_history_id);
                $.ajax({
                    type: 'POST',
                    url: '{{ url('fetchVettingHistory') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        vetting_check_history_id: vetting_check_history_id
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#vettingHistoryEditDiv').html(data.html);
                    }
                });
                $('#vettingHistoryEditModal').modal("show");
            }
        }
    </script>
@endsection
