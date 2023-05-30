<form action="{{ url('/updateCandidateVetting') }}" method="post" id="candVettingEditForm">
    @csrf
    <div class="modal-input-field-section">
        <input type="hidden" name="vetting_id" value="{{ $vettingDetail->vetting_id }}">
        <input type="hidden" name="schoolId" value="{{ $schoolId }}">
        <input type="hidden" name="teacherId" value="{{ $teacherId }}">
        <input type="hidden" name="asn_id" value="{{ $asn_id }}">

        <div class="row cand-vetting-modal-left">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group cand-vetting-modal-input-field">
                            <label for="">FAO</label>
                            <input type="text" class="form-control vetting-field-validate" id=""
                                name="fao_txt" value="{{ $vettingDetail->fao_txt }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-icon-sec">
                            <a href="{{ URL::to('/school-detail/' . $schoolId) }}" target="_blank">
                                <i class="fa-solid fa-school-flag"></i>
                            </a>
                            <a href="{{ URL::to('/teacher-detail/' . $teacherId) }}" target="_blank">
                                <i class="fa-solid fa-person"></i>
                            </a>
                            <a href="{{ URL::to('/assignment-details/' . $asn_id) }}" target="_blank">
                                <i class="fa-solid fa-file-signature"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <?php $emailExist = 'No'; ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group cand-vetting-modal-input-field">
                            <label for="">FAO Email</label>
                            <select class="form-control vetting-field-validate" id="" name="faoEmail_txt">
                                <option value="">Choose one</option>
                                @foreach ($contactItems as $key1 => $contact)
                                    <option value="{{ $contact->contactItem_txt }}"
                                        {{ $vettingDetail->faoEmail_txt == $contact->contactItem_txt ? 'selected' : '' }}>
                                        {{ $contact->contactItem_txt }}
                                    </option>
                                    <?php
                                    if ($emailExist == 'No' && $vettingDetail->faoEmail_txt == $contact->contactItem_txt) {
                                        $emailExist = 'Yes';
                                    }
                                    ?>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Candidate</p>
                            <span>{{ $vettingDetail->candidateName_txt }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">

                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Date of Birth</p>
                            <span>{{ $vettingDetail->dateOfBirth_dte != '' ? date('d-m-Y', strtotime($vettingDetail->dateOfBirth_dte)) : '' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Identity</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Original ID Seen</p>
                            @if ($vettingDetail->IDType_txt)
                                <span>{{ $vettingDetail->IDType_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->IDSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->IDSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Proof of Address</p>
                            @if ($vettingDetail->addressType_txt)
                                <span>{{ $vettingDetail->addressType_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->addressSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->addressSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Qualification</p>
                            @if ($vettingDetail->qualificationType_txt)
                                <span>{{ $vettingDetail->qualificationType_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if ($vettingDetail->qualificationSeen_dte)
                            <span>{{ date('d-m-Y', strtotime($vettingDetail->qualificationSeen_dte)) }}</span>
                        @else
                            <div class="cand-vetting-modal-field"></div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Reference History</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>References Recieved</p>
                            @if ($vettingDetail->referencesReceived_int)
                                <span>{{ $vettingDetail->referencesReceived_int }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->referencesSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->referencesSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Employment History</p>
                            @if ($vettingDetail->employmentHistory_txt)
                                <span>{{ $vettingDetail->employmentHistory_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->employmentHistory_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->employmentHistory_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Health Declaration</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Health Declaration</p>
                            @if ($vettingDetail->healthDeclaration_txt)
                                <span>{{ $vettingDetail->healthDeclaration_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->healthDeclarationSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->healthDeclarationSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Occupational Health</p>
                            @if ($vettingDetail->occupationalHealth_txt)
                                <span>{{ $vettingDetail->occupationalHealth_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Health Issues</p>
                            @if ($vettingDetail->healthIssues_txt)
                                <span>{{ $vettingDetail->healthIssues_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            <span></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Child Protection</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>DBS Enhanced Disclosure Number</p>
                            @if ($vettingDetail->dbsNumber_txt)
                                <span>{{ $vettingDetail->dbsNumber_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->dbsSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->dbsSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>DBS Enhanced Disclosure Date</p>
                            @if ($vettingDetail->dbsDate_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->dbsDate_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            <!-- <span>26-07-2016</span> -->
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Candidate on Update Service</p>
                            @if ($vettingDetail->updateService_txt)
                                <span>{{ $vettingDetail->updateService_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->updateServiceSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->updateServiceSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>List 99 Check Result</p>
                            @if ($vettingDetail->list99CheckResult_txt)
                                <span>{{ $vettingDetail->list99CheckResult_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->list99Seen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->list99Seen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Disqualification by Association Act</p>
                            @if ($vettingDetail->disqualAssociation_txt)
                                <span>{{ $vettingDetail->disqualAssociation_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->disqualAssociation_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->disqualAssociation_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Mandatory Induction into Safeguarding</p>
                            @if ($vettingDetail->safeguardingInduction_txt)
                                <span>{{ $vettingDetail->safeguardingInduction_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->safeguardingInduction_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->safeguardingInduction_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>NCTL Check</p>
                            @if ($vettingDetail->NCTLCheck_txt)
                                <span>{{ $vettingDetail->NCTLCheck_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->NCTLSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->NCTLSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>s128 Management Check</p>
                            @if ($vettingDetail->s128MgmtCheck_txt)
                                <span>{{ $vettingDetail->s128MgmtCheck_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->s128MgmtCheck_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->s128MgmtCheck_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>EEA Restriction Check</p>
                            @if ($vettingDetail->EEARestrictCheck_txt)
                                <span>{{ $vettingDetail->EEARestrictCheck_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->EEARestrictCheck_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->EEARestrictCheck_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Other</p>
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Right To Work</p>
                            @if ($vettingDetail->rightToWork_txt)
                                <span>{{ $vettingDetail->rightToWork_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Face to Face Interview Date</p>
                            @if ($vettingDetail->interviewDate_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->interviewDate_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>NI Number</p>
                            @if ($vettingDetail->NINumber_txt)
                                <span>{{ $vettingDetail->NINumber_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Emergency Name/Number</p>
                            @if ($vettingDetail->emergencyNameNumber_txt)
                                <span>{{ $vettingDetail->emergencyNameNumber_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Teacher Reference Number</p>
                            @if ($vettingDetail->TRN_txt)
                                <span>{{ $vettingDetail->TRN_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Likeness of Candidate</p>
                        </div>

                        <div class="cand-vetting-modal-user-img">
                            @if ($vettingDetail->imageLocation_txt)
                                <img src="{{ asset($vettingDetail->imageLocation_txt) }}" alt="">
                            @else
                                <img src="{{ asset('web/images/user-img.png') }}" alt="">
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="sidebar" value="{{ $sidebar }}">

    <!-- Modal footer -->
    <div class="modal-footer calendar-modal-footer cand-vetting-modal-btn">
        @if ($sidebar)
            <button type="button" class="btn btn-secondary" id="candVettingEditBtnSidebar">Update</button>
        @else
            <button type="button" class="btn btn-secondary" id="candVettingEditBtn">Update</button>
        @endif

        @if ($emailExist == 'Yes')
            <button type="button" class="btn btn-warning"
                onclick="vettingSend('{{ $vettingDetail->vetting_id }}')">Approve and Send</button>
        @else
            <button type="button" class="btn btn-warning cand-vetting-approve-disable-btn">Approve and Send</button>
        @endif

        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
    function vettingSend(vetting_id) {
        if (vetting_id) {
            $('#fullLoader').show();
            $.ajax({
                type: 'POST',
                url: '{{ url('approveVettingSend') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    vetting_id: vetting_id
                },
                dataType: "json",
                async: false,
                success: function(data) {
                    // console.log(data);
                    if (data.exist == 'Yes' && data.invoice_path) {
                        const link = document.createElement('a');
                        link.href = data.invoice_path;
                        link.download = data.pdfName;
                        link.target = '_blank';
                        link.click();
                    }
                    var subject = data.subject;
                    var body = "Hello";
                    window.location = 'mailto:' + data.sendMail + '?subject=' +
                        encodeURIComponent(subject) + '&body=' +
                        encodeURIComponent(body);

                    $('#fullLoader').hide();
                }
            });
        }
    }
</script>
