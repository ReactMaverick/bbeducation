@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.school.school_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.school.school_header')

                <div class="school-assignment-sec">
                    <div class="school-assignment-section">
                        <div class="contact-history-heading-section">
                            <h2>Contact History</h2>
                            <a data-toggle="modal" data-target="#ContactHistoryAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th style="width: 40%">Contact Notes</th>
                                    <th>Spoke To</th>
                                    <th>Contact By</th>
                                    <th>Contact On</th>
                                    <th>Method</th>
                                    <th>CB Due</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                {{ $dueCallCount = 0 }}
                                @foreach ($ContactHistory as $key => $History)
                                    <tr class="school-detail-table-data">
                                        <td style="width: 40%">{{ $History->notes_txt }}</td>
                                        <td>{{ $History->spokeTo_txt }}</td>
                                        <td>{{ $History->firstName_txt . ' ' . $History->surname_txt }}</td>
                                        <td>{{ date('d-m-Y H:i', strtotime($History->contactOn_dtm)) }}</td>
                                        <td>{{ $History->method_txt }}</td>
                                        <td>
                                            @if ($History->callbackOn_dtm == null)
                                                {{ 'N' }}
                                            @elseif ($History->callbackOn_dtm >= date('Y-m-d H:i:s'))
                                                {{ 'Y' }}
                                                {{ $dueCallCount += 1 }}
                                            @else
                                                {{ 'N' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="assignment-first-sec">
                        <div class="assignment-left-sidebar-section">
                            <div class="sidebar-sec">
                                <div class="assignment-sidebar-data">
                                    <h2>{{ count($ContactHistory) }}</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Total Contacts</span>
                                </div>
                            </div>
                            <div class="sidebar-sec">
                                <div class="assignment-sidebar-data2">
                                    <h2>{{ $dueCallCount }}</h2>
                                </div>
                                <div class="sidebar-sec-text">
                                    <span>Callbacks Due</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Contact Add Modal -->
    <div class="modal fade" id="ContactHistoryAddModal">
        <div class="modal-dialog modal-dialog-centered calendar-modal-section">
            <div class="modal-content calendar-modal-content">

                <!-- Modal Header -->
                <div class="modal-header calendar-modal-header">
                    <h4 class="modal-title">Log School Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="calendar-heading-sec">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                    <h2>Log School Contact</h2>
                </div>

                <form action="{{ url('/schoolContactLogInsert') }}" method="post" class="form-validate">
                    @csrf
                    <div class="modal-input-field-section">
                        <h6>{{ $schoolDetail->name_txt }}</h6>
                        {{-- <h6>ID</h6>
                        <h6>{{ $schoolDetail->school_id }}</h6> --}}
                        <input type="hidden" name="school_id" value="{{ $schoolDetail->school_id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Spoke to (specific contact)</label>
                                    <select class="form-control field-validate SpokeToId" name="" id="SpokeToId" onchange="selectSpokeTo(this.value, this.options[this.selectedIndex].getAttribute('sName'))" >
                                        <option value="">Choose one</option>
                                        @foreach ($schoolContacts as $key1 => $Contacts)
                                            {{ $name = '' }}
                                            @if ($Contacts->firstName_txt != '' && $Contacts->surname_txt != '')
                                                {{ $name = $Contacts->firstName_txt . ' ' . $Contacts->surname_txt }}
                                            @elseif ($Contacts->firstName_txt != '' && $Contacts->surname_txt == '')
                                                {{ $name = $Contacts->firstName_txt }}
                                            @elseif ($Contacts->title_int != '' && $Contacts->surname_txt != '')
                                                {{ $name = $Contacts->title_txt . ' ' . $Contacts->surname_txt }}
                                            @elseif ($Contacts->jobRole_int != '')
                                                {{ $name = $Contacts->jobRole_txt . ' (name unknown)' }}
                                            @else
                                                {{ $name = 'Name unknown' }}
                                            @endif
                                            <option sName="{{ $name }}" value="{{ $Contacts->contact_id }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Spoke to</label>
                                    <input type="text" class="form-control" name="" id="sopkeToText" value="">
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Contact Method</label>
                                    <select class="form-control field-validate" name="">
                                        <option value="">Choose one</option>
                                        @foreach ($methodList as $key2 => $method)
                                            <option value="{{ $method->description_int }}">
                                                {{ $method->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 modal-form-right-sec">
                                <div class="form-group modal-input-field">
                                    <label class="form-check-label">Notes</label>
                                    <textarea name="" id="" cols="30" rows="5" class="form-control field-validate"></textarea>
                                </div>

                                <div class="modal-side-field">
                                    <label class="form-check-label" for="callBackId">Callback</label>
                                    <input type="checkbox" class="callBackId" name="" id="callBackId" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group calendar-form-filter">
                                    <label for="">Contact Reason</label>
                                    <select class="form-control" name="title_int">
                                        <option value="">Choose one</option>
                                        @foreach ($reasonList as $key4 => $reason)
                                            <option value="{{ $reason->description_int }}">
                                                {{ $reason->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="">Call Outcome</label>
                                    <select class="form-control" name="title_int">
                                        <option value="">Choose one</option>
                                        @foreach ($outcomeList as $key5 => $outcome)
                                            <option value="{{ $outcome->description_int }}">
                                                {{ $outcome->description_txt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row" id="quickSettingDiv" style="display: none;">
                                    <div class="form-group calendar-form-filter col-md-12">
                                        <label for="">Quick Setting</label>
                                        <select class="form-control" name="">
                                            <option value="">Choose one</option>
                                            @foreach ($quickSettingList as $key3 => $quickSetting)
                                            <option value="{{ $quickSetting->description_int }}">
                                                {{ $quickSetting->description_txt }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-input-field col-md-6">
                                        <label class="form-check-label">Date</label>
                                        <input type="date" class="form-control" name="" id="" value="">
                                    </div>

                                    <div class="modal-input-field col-md-6">
                                        <label class="form-check-label">Time</label>
                                        <input type="time" class="form-control" name="" id="" value="">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer calendar-modal-footer">
                        <button type="button" class="btn btn-secondary">Submit</button>

                        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Contact Add Modal -->

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        function selectSpokeTo(contact_id, contact_name){
            if (contact_id) {
                $('#sopkeToText').val(contact_name);
            } else {
                $('#sopkeToText').val('');
            }
        }

        $(document).on('change', '#callBackId', function() {
                if ($(this).is(":checked")) {
                    $('#quickSettingDiv').show();
                }else{
                    $('#quickSettingDiv').hide();
                }
            });
    </script>
@endsection
