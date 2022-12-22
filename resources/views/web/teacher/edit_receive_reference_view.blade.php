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
                        <input type="text" class="form-control" name="" id=""
                            value="{{ $textQn->question_txt }}">
                            <input type="text" class="form-control" name="" id=""
                            value="{{ $textQn->questionType_int }}">
                        <input type="text" class="form-control" name="" id=""
                            value="">
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

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="second-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"
                            checked>
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio"
                            value="option2">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="second-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="optradio"
                            value="option1" checked>
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio"
                            value="option2">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="second-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="optradio"
                            value="option1" checked>
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio"
                            value="option2">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="second-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="optradio"
                            value="option1" checked>
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio"
                            value="option2">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="second-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="optradio"
                            value="option1" checked>
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio"
                            value="option2">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>
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

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="third-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="third-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="third-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="third-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>

            <div class="first-inner-sec2">
                <div class="second-inner-input">
                    <span>Lorem Ipsum ?</span>
                </div>
                <div class="third-inner-input2">
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio3" name="optradio"
                            value="option3">
                    </div>
                    <div class="form-check-inline option-question-form-check">
                        <input type="radio" class="form-check-input" id="radio4" name="optradio"
                            value="option4">
                    </div>
                </div>

                <div class="second-inner-input3">
                    <input type="text" class="form-control" name="employedUntil_dte" id=""
                        value="">
                </div>
            </div>
        </div>

        <div class="modal-bottom-sec">
            <div class="form-check reference-check-sec">
                <label for="vehicle1">Reference is Valid</label>
                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            </div>
            <div class="form-check reference-check-sec">
                <label for="vehicle1">Verbal Reference</label>
                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            </div>

            <div class="form-group select-feedback-field">
                <label for="">Feedback Quality</label>
                <select id="" class="form-control">
                    @foreach ($feedbackList as $key2 => $feedback)
                        <option value="{{ $feedback->description_int }}">
                            {{ $feedback->description_txt }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>
