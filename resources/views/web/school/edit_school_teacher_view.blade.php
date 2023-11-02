<div class="col-md-8 col-lg-8 col-xl-8 col-12 col-sm-12">
    <div class="school-search-section add-school-search-section details-heading">
        <div class="school-search-field add-school-search-field">
            <h2>Teacher</h2>
            {{-- <label for="">Search For</label>
            <input type="text" class="form-control" id="searchTeacherKey" name="searchTeacherKey" value=""> --}}
        </div>
    </div>

    <div class="assignment-finance-table-section mt-3">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-heading add-school-teacher-table">
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Days Here</th>
                    <th>Specialism</th>
                </tr>
            </thead>
            <tbody class="table-body-sec" id="editSearchTeacherView">
                <tr class="table-data">
                    @foreach ($teacherList as $key => $teacher)
                        <td>
                            @if ($teacher->knownAs_txt == null && $teacher->knownAs_txt == '')
                                {{ $teacher->firstName_txt . ' ' . $teacher->surname_txt }}
                            @else
                                {{ $teacher->firstName_txt . ' (' . $teacher->knownAs_txt . ') ' . $teacher->surname_txt }}
                            @endif
                        </td>
                        <td>{{ $teacher->professionalType_txt }}</td>
                        <td>{{ $teacher->appStatus_txt }}</td>
                        <td>{{ $teacher->daysWorked_dec }}</td>
                        <td>{{ $teacher->ageRangeSpecialism_txt }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

<input type="hidden" name="editSearchTeacherId" id="editSearchTeacherId" value="{{ $Detail->teacher_id }}">

<div class="col-md-4 col-lg-4 col-xl-4 col-12 col-sm-12">
    <div class="calendar-heading-sec" style="align-items: baseline;">
        <i class="fas fa-edit school-edit-icon"></i>
        <h2>Edit Teacher Addition</h2>
    </div>

    <div class="modal-input-field-section">
        <p>{{ $editSchoolDetail->name_txt }}</p>
        {{-- <h6>ID</h6>
        <h6>{{ $editSchoolDetail->school_id }}</h6> --}}

        <div class="form-group calendar-form-filter">
            <label for="">Reason for List Addition</label>
            <select class="form-control field-validate-2" name="rejectOrPreferred_int">
                <option value="">Choose one</option>
                <option value="1" {{ $Detail->rejectOrPreferred_int == '1' ? 'selected' : '' }}>Preferred
                </option>
                <option value="2" {{ $Detail->rejectOrPreferred_int == '2' ? 'selected' : '' }}>Rejected
                </option>
            </select>
        </div>

        <div class="form-group modal-input-field">
            <label class="form-check-label">Notes</label>
            <textarea name="notes_txt" id="" cols="30" rows="5" class="form-control">{{ $Detail->notes_txt }}</textarea>
        </div>

    </div>

    <!-- Modal footer -->
    <div class="modal-footer calendar-modal-footer">
        <button type="button" class="btn btn-secondary" id="schoolTeacherEditBtn">Submit</button>

        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
    </div>

</div>

<script>
    $(document).on('keyup', '#editSearchTeacherKey', function() {
        var editSearchTeacherKey = $(this).val();
        if (editSearchTeacherKey.length > 3) {
            $('#editSearchTeacherId').val('');
            $.ajax({
                type: 'POST',
                url: '{{ url('editSearchTeacherList') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    searchTeacherKey: editSearchTeacherKey
                },
                success: function(data) {
                    // console.log(data);
                    if (data == 'login') {
                        var loginUrl = '<?php echo url('/'); ?>';
                        window.location.assign(loginUrl);
                    } else {
                        $('#editSearchTeacherView').html(data.html);
                    }
                }
            });
        }
    });

    function editSearchTeacherRowSelect(teacher_id) {
        if ($('#editSearchTeacherRow' + teacher_id).hasClass('tableRowActive')) {
            $('#editSearchTeacherId').val('');
            $('#editSearchTeacherRow' + teacher_id).removeClass('tableRowActive');
        } else {
            $('#editSearchTeacherId').val(teacher_id);
            $('.editSearchTeacherRow').removeClass('tableRowActive');
            $('#editSearchTeacherRow' + teacher_id).addClass('tableRowActive');
        }
    }
</script>
