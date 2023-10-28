<div class="calendar-heading-sec" style="align-items: baseline;">
    <i class="fas fa-edit school-edit-icon"></i>
    <h2>Edit Calendar Item</h2>
</div>

<form action="{{ url('/teacherEventUpdate') }}" method="post" id="TeacherCalEventEditForm">
    @csrf
    <div class="modal-input-field-section">
        <h6>
            @if ($eventCalDetails->knownAs_txt == '' || $eventCalDetails->knownAs_txt == null)
                {{ $eventCalDetails->firstName_txt }} {{ $eventCalDetails->surname_txt }}
            @else
                {{ $eventCalDetails->knownAs_txt }} {{ $eventCalDetails->surname_txt }}
            @endif
        </h6>
        <span>Date</span>
        <p>{{ date('d-m-Y', strtotime($eventCalDetails->date_dte)) }}</p>
        <input type="hidden" name="calendarItem_id" value="{{ $eventCalDetails->calendarItem_id }}">
        <input type="hidden" name="date_dte" value="{{ $eventCalDetails->date_dte }}">
        <input type="hidden" name="teacher_id" value="{{ $eventCalDetails->teacher_id }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group calendar-form-filter">
                    <label for="">Calendar Reason</label>
                    <select class="form-control" name="reason_int" style="width:100%;">
                        @foreach ($reasonList as $key1 => $reason)
                            <option value="{{ $reason->description_int }}"
                                {{ $eventCalDetails->reason_int == $reason->description_int ? 'selected' : '' }}>
                                {{ $reason->description_txt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group calendar-form-filter">
                    <label for="">Part of Day</label>
                    <select class="form-control" name="part_int" id="part_int_id" style="width:100%;">
                        @foreach ($dayPartList as $key2 => $dayPart)
                            <option value="{{ $dayPart->description_int }}"
                                {{ $eventCalDetails->part_int == $dayPart->description_int ? 'selected' : '' }}>
                                {{ $dayPart->description_txt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group modal-input-field">
                    <label class="form-check-label">Start Time (for set hours)</label>
                    <input type="time" class="form-control" name="start_tm" id="start_tm_id"
                        value="{{ $eventCalDetails->start_tm }}"
                        {{ $eventCalDetails->part_int == 4 ? '' : 'disabled' }}>
                </div>

                <div class="form-group modal-input-field">
                    <label class="form-check-label">End Time (for set hours)</label>
                    <input type="time" class="form-control" name="end_tm" id="end_tm_id"
                        value="{{ $eventCalDetails->end_tm }}"
                        {{ $eventCalDetails->part_int == 4 ? '' : 'disabled' }}>
                </div>
            </div>
            <div class="col-md-6 modal-form-right-sec">
                <div class="modal-side-field mb-2">
                    <label class="form-check-label" for="block_booking">Block Booking</label>
                    <input type="checkbox" class="" name="block_booking" id="block_booking" value="1">
                </div>

                <div class="form-group modal-input-field">
                    <label class="form-check-label">End Date (block booking)</label>
                    <input type="date" class="form-control" name="block_booking_dte"
                        value="{{ $eventCalDetails->date_dte }}">
                </div>

                <div class="modal-side-field mb-2">
                    <label class="form-check-label" for="exclude_weekend">Exclude Weekends</label>
                    <input type="checkbox" class="" name="exclude_weekend" id="exclude_weekend" value="1"
                        checked>
                </div>

                <div class="form-group modal-input-field">
                    <label class="form-check-label">Notes</label>
                    <textarea name="notes_txt" id="" cols="30" rows="3" class="form-control">{{ $eventCalDetails->notes_txt }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer calendar-modal-footer">
        <button type="button" class="btn btn-secondary" id="TeacherCalEventSaveBtn">Save</button>

        <button type="button" class="btn btn-danger cancel-btn" id="TeacherCalEventDeleteBtn">Delete</button>
    </div>
</form>
