<input type="hidden" name="file_location" value="{{ $docDetail->file_location }}">
<div class="row">
    <div class="col-md-12">
        <div class="modal-input-field form-group">
            <label class="form-check-label">Document Name</label>
            <input type="text" class="form-control field-validate-2" name="file_name" id="" value="{{ $docDetail->file_name }}">
        </div>

        <div class="modal-input-field form-group">
            <label class="form-check-label">Upload Document</label>
            <input type="file" class="form-control file-validate-2" name="file" id="" value=""><span> *Only file type 'jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx'</span>
        </div>
    </div>                            
</div>