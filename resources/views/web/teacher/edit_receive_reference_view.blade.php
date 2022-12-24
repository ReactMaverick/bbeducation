<div class="col-md-3 modal-col">
    <div class="form-group modal-input-field">
        <label class="form-check-label">Employer Name</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-3" name="employer_txt" id=""
            value="{{ $Detail->employer_txt }}">
    </div>
    <div class="form-group modal-input-field">
        <label class="form-check-label">Referee Name</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-3" name="refereeName_txt" id=""
            value="{{ $Detail->refereeName_txt }}">
    </div>
    <div class="form-group modal-input-field">
        <label class="form-check-label">Referee Email</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-3" name="refereeEmail_txt" id=""
            value="{{ $Detail->refereeEmail_txt }}">
    </div>
    <div class="form-group modal-input-field">
        <label class="form-check-label">Employed From</label><span style="color: red;">*</span>
        <input type="date" class="form-control field-validate-3" name="employedFrom_dte" id=""
            value="{{ $Detail->employedFrom_dte }}">
    </div>
    <div class="form-group modal-input-field">
        <label class="form-check-label">Employed Until</label><span style="color: red;">*</span>
        <input type="date" class="form-control field-validate-3" name="employedUntil_dte" id=""
            value="{{ $Detail->employedUntil_dte }}">
    </div>
    <div class="form-group modal-input-field">
        <label class="form-check-label">Address</label>
        <input type="text" class="form-control mb-1" name="address1_txt" id=""
            value="{{ $Detail->address1_txt }}">
        <input type="text" class="form-control mb-1" name="address2_txt" id=""
            value="{{ $Detail->address2_txt }}">
        <input type="text" class="form-control mb-1" name="address3_txt" id=""
            value="{{ $Detail->address3_txt }}">
        <input type="text" class="form-control" name="addrress4_txt" id=""
            value="{{ $Detail->addrress4_txt }}">
    </div>
    <div class="form-group modal-input-field">
        <label class="form-check-label">Postcode</label><span style="color: red;">*</span>
        <input type="text" class="form-control field-validate-3" name="postcode_txt" id=""
            value="{{ $Detail->postcode_txt }}">
    </div>

</div>
<div class="col-md-9 modal-col">
    <div class="outer-sec pl-3">
        <span class="top-text">Text Questions</span>
        <div class="first-outer-sec">
            <div class="first-inner-sec">
                <div class="first-inner-heading">
                    <h2>Question</h2>
                </div>
                <div class="first-inner-heading2">
                    <h2>Answer</h2>
                </div>
            </div>

            @foreach ($textQnList as $key3 => $textQn)
                <div class="first-inner-sec2">
                    <div class="first-inner-input">
                        <span>{{ $textQn->question_txt }}</span>
                    </div>
                    <div class="first-inner-input2">
                        <input type="hidden" class="form-control" name="textQn_qnId[]" id=""
                            value="{{ $textQn->question_id }}">
                        <input type="hidden" class="form-control" name="textQn_qnTxt_{{ $textQn->question_id }}"
                            id="" value="{{ $textQn->question_txt }}">
                        <input type="hidden" class="form-control" name="textQn_qnType_{{ $textQn->question_id }}"
                            id="" value="{{ $textQn->questionType_int }}">

                        <input type="text" class="form-control" name="textQn_answer_{{ $textQn->question_id }}"
                            id="" value="{{ $textQn->det_answer_txt }}">
                    </div>
                </div>
            @endforeach
        </div>

        <span class="top-text">Option Questions</span>
        <div class="first-outer-sec">
            <div class="first-inner-sec">
                <div class="second-inner-heading">
                    <h2>Question</h2>
                </div>
                <div class="second-inner-heading2">
                    <h2>Poor - Excellent</h2>
                </div>
                <div class="second-inner-heading3">
                    <h2>Answer</h2>
                </div>
            </div>

            @foreach ($optQnList as $key4 => $optQn)
                <div class="first-inner-sec2">
                    <div class="second-inner-input">
                        <span>{{ $optQn->question_txt }}</span>
                    </div>

                    <input type="hidden" class="form-control" name="optQn_qnId[]" id=""
                        value="{{ $optQn->question_id }}">
                    <input type="hidden" class="form-control" name="optQn_qnTxt_{{ $optQn->question_id }}"
                        id="" value="{{ $optQn->question_txt }}">
                    <input type="hidden" class="form-control" name="optQn_qnType_{{ $optQn->question_id }}"
                        id="" value="{{ $optQn->questionType_int }}">

                    <div class="second-inner-input2">
                        @foreach ($rateList as $key5 => $rate)
                            <div class="form-check-inline option-question-form-check">
                                <input type="radio" class="form-check-input" id=""
                                    name="optQn_rateVal_{{ $optQn->question_id }}" value="{{ $rate->value_int }}"
                                    {{ $optQn->det_answer_int == $rate->value_int ? 'checked' : '' }}>
                            </div>
                        @endforeach
                    </div>

                    <div class="second-inner-input3">
                        <input type="text" class="form-control" name="optQn_answer_{{ $optQn->question_id }}"
                            id="" value="{{ $optQn->det_answer_txt }}">
                    </div>
                </div>
            @endforeach
        </div>

        <span class="top-text">Yes/No Questions</span>
        <div class="first-outer-sec">
            <div class="first-inner-sec">
                <div class="second-inner-heading">
                    <h2>Question</h2>
                </div>
                <div class="second-inner-heading2">
                    <h2>Yes/No</h2>
                </div>
                <div class="second-inner-heading3">
                    <h2>Notes</h2>
                </div>
            </div>

            @foreach ($yesNoQnList as $key6 => $yesNoQn)
                <div class="first-inner-sec2">
                    <div class="second-inner-input">
                        <span>{{ $yesNoQn->question_txt }}</span>
                    </div>

                    <input type="hidden" class="form-control" name="yesNoQn_qnId[]" id=""
                        value="{{ $yesNoQn->question_id }}">
                    <input type="hidden" class="form-control" name="yesNoQn_qnTxt_{{ $yesNoQn->question_id }}"
                        id="" value="{{ $yesNoQn->question_txt }}">
                    <input type="hidden" class="form-control" name="yesNoQn_qnType_{{ $yesNoQn->question_id }}"
                        id="" value="{{ $yesNoQn->questionType_int }}">

                    <div class="third-inner-input2">
                        <div class="form-check-inline option-question-form-check">
                            <input type="radio" class="form-check-input" id=""
                                name="yesNoQn_yesno_{{ $yesNoQn->question_id }}" value="1"
                                {{ $yesNoQn->det_answer_ysn == 1 ? 'checked' : '' }}>
                        </div>
                        <div class="form-check-inline option-question-form-check">
                            <input type="radio" class="form-check-input" id=""
                                name="yesNoQn_yesno_{{ $yesNoQn->question_id }}" value="2"
                                {{ $yesNoQn->det_answer_ysn == '0' ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="second-inner-input3">
                        <input type="text" class="form-control" name="yesNoQn_answer_{{ $yesNoQn->question_id }}"
                            id="" value="{{ $yesNoQn->det_answer_txt }}">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="modal-bottom-sec">
            <div class="form-group form-check reference-check-sec">
                <label for="isValid_statusId">Reference is Valid</label>
                <input type="checkbox" class="" id="isValid_statusId" name="isValid_status" value="1"
                    {{ $Detail->isValid_status == '-1' ? 'checked' : '' }}>
            </div>

            <input type="hidden" name="prev_isValid_status" id="" value="{{ $Detail->isValid_status }}">
            <input type="hidden" name="prev_receivedOn_dtm" id="" value="{{ $Detail->receivedOn_dtm }}">

            <div class="form-check reference-check-sec">
                <label for="verbalReference_statusId">Verbal Reference</label>
                <input type="checkbox" id="verbalReference_statusId" name="verbalReference_status" value="1"
                    {{ $Detail->verbalReference_status == '-1' ? 'checked' : '' }}>
            </div>

            <div class="form-group select-feedback-field">
                <label for="">Feedback Quality</label>
                <select id="" class="form-control" name="feedbackQuality_int">
                    <option value="">Choose one</option>
                    @foreach ($feedbackList as $key2 => $feedback)
                        <option value="{{ $feedback->description_int }}"
                            {{ $Detail->feedbackQuality_int == $feedback->description_int ? 'selected' : '' }}>
                            {{ $feedback->description_txt }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>
