<input type="hidden" name="invoice_id" id="" value="{{ $invoiceDetail->invoice_id }}">

<span>School</span>
<p>{{ $invoiceDetail->name_txt }}</p>

<div class="row">
    <div class="col-md-6">
        <div class="modal-input-field form-group">
            <label class="form-check-label">Invoice Date</label>
            <input type="text" class="form-control datePickerPaste" name="invoiceDate_dte" id=""
                value="{{ $invoiceDetail->invoiceDate_dte != null ? date('d/m/Y', strtotime($invoiceDetail->invoiceDate_dte)) : '' }}">
        </div>

        <div class="modal-side-field form-group">
            <label class="form-check-label" for="factored_status">Factored</label>
            <input type="checkbox" class="" name="factored_status" id="factored_status" value="1"
                <?php echo $invoiceDetail->factored_status == '-1' ? 'checked' : ''; ?>>
        </div>

        <div class="modal-side-field form-group">
            <label class="form-check-label" for="creditNote_status">Is Credit Note</label>
            <input type="checkbox" class="" name="creditNote_status" id="creditNote_status" value="1"
                <?php echo $invoiceDetail->creditNote_status == '-1' ? 'checked' : ''; ?>>
        </div>
    </div>
    <div class="col-md-6">
        <div class="modal-input-field form-group">
            <label class="form-check-label">Paid On</label>
            <input type="text" class="form-control datePickerPaste" name="paidOn_dte" id=""
                value="{{ $invoiceDetail->paidOn_dte != null ? date('d/m/Y', strtotime($invoiceDetail->paidOn_dte)) : '' }}">
        </div>
        <div class="form-group calendar-form-filter">
            <label for="">Payment Method</label>
            <select class="form-control" name="paymentMethod_int" id="">
                <option value="">Choose one</option>
                @foreach ($paymentMethodList as $key1 => $paymentMethod)
                    <option value="{{ $paymentMethod->description_int }}" <?php echo $invoiceDetail->paymentMethod_int == $paymentMethod->description_int ? 'selected' : ''; ?>>
                        {{ $paymentMethod->description_txt }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12" style="width: 100%;">
        <div class="contact-heading mb-2">
            <div class="contact-heading-text">
                <h2>Invoice Items</h2>
            </div>
            <div class="contact-icon-sec">
                <a style="cursor: pointer" class="disabled-link" id="deleteInvItemBttn">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <a data-toggle="modal" data-target="#invoiceItemAddModal" style="cursor: pointer;">
                    <i class="fa-solid fa-plus"></i>
                </a>
                <a style="cursor: pointer;" class="disabled-link" id="editInvItemBttn">
                    <i class="fa-solid fa-pencil school-edit-icon"></i>
                </a>
            </div>
        </div>
        <table class="table school-detail-page-table" id="editInvItemTable" style="width: 100%;">
            <thead>
                <tr class="school-detail-table-heading">
                    <th style="width: 50%;">Description</th>
                    <th>Qty.</th>
                    <th>Charge</th>
                    <th>Cost</th>
                    <th>Asn?</th>
                    <th>Tch?</th>
                </tr>
            </thead>
            <tbody class="table-body-sec" id="invoiceEditTblAdd">
                @foreach ($invoiceItemList as $key => $invoiceItem)
                    <tr class="school-detail-table-data editInvItemRow"
                        onclick="invItemRowSelect({{ $invoiceItem->invoiceItem_id }})"
                        id="editInvItemRow{{ $invoiceItem->invoiceItem_id }}">
                        <td style="width: 50%;">{{ $invoiceItem->description_txt }}</td>
                        <td>{{ (int) $invoiceItem->numItems_dec }}</td>
                        <td>{{ (int) $invoiceItem->charge_dec }}</td>
                        <td>{{ (int) $invoiceItem->cost_dec }}</td>
                        <td>
                            @if ($invoiceItem->asnItem_id != '' || $invoiceItem->asnItem_id != null)
                                {{ 'Y' }}
                            @else
                                {{ 'N' }}
                            @endif
                        </td>
                        <td>
                            @if ($invoiceItem->teacher_id != '' || $invoiceItem->teacher_id != null)
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

<!-- Invoice item add Modal -->
<div class="modal fade" id="invoiceItemAddModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width:65%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Add Invoice Item</h4>
                <button type="button" class="close ajaxInvoiceAddBtnCencel">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Add Invoice Item</h2>
            </div>

            <form action="{{ url('/financeInvItemInsert') }}" method="post" class="form-validate-3"
                enctype="multipart/form-data" id="ajaxInvoiceAddForm">
                @csrf
                <div class="modal-input-field-section">
                    <input type="hidden" name="invoice_id" value="{{ $invoiceDetail->invoice_id }}">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group modal-input-field">
                                <label class="form-check-label">Item Description</label><span
                                    style="color: red;">*</span>
                                <textarea name="description_txt" id="" cols="30" rows="4" class="form-control field-validate-3"></textarea>
                            </div>

                            <div class="modal-input-field form-group">
                                <label class="form-check-label">Number of Items</label><span
                                    style="color: red;">*</span>
                                <input type="text" class="form-control number-validate-3" name="numItems_dec"
                                    id="" value="">
                            </div>

                            <div class="modal-input-field form-group">
                                <label class="form-check-label">Linked Date</label><span style="color: red;">*</span>
                                <input type="text" class="form-control datePickerPaste datepaste-validate-3"
                                    name="dateFor_dte" id="" value="">
                            </div>

                            <div class="modal-input-field form-group">
                                <label class="form-check-label">Charge</label><span style="color: red;">*</span>
                                <input type="text" class="form-control number-validate-3" name="charge_dec"
                                    id="" value="">
                            </div>

                            <div class="modal-input-field form-group">
                                <label class="form-check-label">Cost</label><span style="color: red;">*</span>
                                <input type="text" class="form-control number-validate-3" name="cost_dec"
                                    id="" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer calendar-modal-footer">
                    <button type="button" class="btn btn-secondary" id="ajaxInvoiceAddBtn">Submit</button>

                    <button type="button" class="btn btn-danger cancel-btn ajaxInvoiceAddBtnCencel">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Invoice item add Modal -->

<!-- Invoice item edit Modal -->
<div class="modal fade" id="invoiceItemEditModal">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
        <div class="modal-content calendar-modal-content" style="width:65%;">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Edit Invoice Item</h4>
                <button type="button" class="close ajaxInvoiceEditBtnCencel">&times;</button>
            </div>

            <div class="calendar-heading-sec">
                <i class="fa-solid fa-pencil school-edit-icon"></i>
                <h2>Edit Invoice Item</h2>
            </div>

            <form action="{{ url('/financeInvoiceItemUpdate') }}" method="post" class="form-validate-2"
                enctype="multipart/form-data" id="ajaxInvoiceEditForm">
                @csrf
                <input type="hidden" name="editInvItemId" id="editInvItemId" value="">
                <div class="modal-input-field-section">

                    <input type="hidden" name="invoice_id" value="{{ $invoiceDetail->invoice_id }}">

                    <div class="row" id="invoiceItemEditAjax"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer calendar-modal-footer">
                    <button type="submit" class="btn btn-secondary" id="ajaxInvoiceEditBtn">Submit</button>

                    <button type="button" class="btn btn-danger cancel-btn ajaxInvoiceEditBtnCencel">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Invoice item edit Modal -->

<script>
    $(document).ready(function() {
        $('#editInvItemTable').DataTable({
            searching: false,
            paging: false,
            info: false
        });

        $('.datePickerPaste').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    });

    function invItemRowSelect(invoiceItem_id) {
        if ($('#editInvItemRow' + invoiceItem_id).hasClass('tableRowActive')) {
            $('#editInvItemId').val('');
            $('#editInvItemRow' + invoiceItem_id).removeClass('tableRowActive');
            $('#deleteInvItemBttn').addClass('disabled-link');
            $('#editInvItemBttn').addClass('disabled-link');
        } else {
            $('#editInvItemId').val(invoiceItem_id);
            $('.editInvItemRow').removeClass('tableRowActive');
            $('#editInvItemRow' + invoiceItem_id).addClass('tableRowActive');
            $('#deleteInvItemBttn').removeClass('disabled-link');
            $('#editInvItemBttn').removeClass('disabled-link');
        }
    }

    $(document).on('click', '#ajaxInvoiceAddBtn', function(e) {
        // e.preventDefault();
        var error = "";
        $(".field-validate-3").each(function() {
            if (this.value == '') {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });
        $(".number-validate-3").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });
        if (error == "has error") {
            return false;
        } else {
            $('#fullLoader').show();
            var form = $("#ajaxInvoiceAddForm");
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                async: false,
                success: function(res) {
                    if (res) {
                        if (res.status == 'success') {
                            $('#invoiceEditTblAdd').html(res.html);
                            $('#fullLoader').hide();
                            $('#invoiceItemAddModal').modal("hide");
                        }
                    }
                    $('#fullLoader').hide();
                }
            });
        }
    });

    $(document).on('click', '.ajaxInvoiceAddBtnCencel', function() {
        $('#invoiceItemAddModal').modal("hide");
    });

    $(document).on('click', '#editInvItemBttn', function() {
        var editInvItemId = $('#editInvItemId').val();
        if (editInvItemId) {
            $.ajax({
                type: 'POST',
                url: '{{ url('getInvoiceItemDetail') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    editInvItemId: editInvItemId
                },
                success: function(res) {
                    //console.log(res);
                    $('#invoiceItemEditAjax').html(res.html);
                }
            });
            $('#invoiceItemEditModal').modal("show");
        } else {
            swal("", "Please select one invoice item.");
        }
    });

    $(document).on('click', '#ajaxInvoiceEditBtn', function(e) {
        e.preventDefault();
        var error = "";
        $(".field-validate-2").each(function() {
            if (this.value == '') {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });
        $(".number-validate-2").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });
        if (error == "has error") {
            return false;
        } else {
            $('#fullLoader').show();
            var form = $("#ajaxInvoiceEditForm");
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                async: false,
                success: function(res) {
                    if (res) {
                        if (res.status == 'success') {
                            $('#invoiceEditTblAdd').html(res.html);
                            $('#fullLoader').hide();
                            $('#invoiceItemEditModal').modal("hide");
                        }
                    }
                    $('#fullLoader').hide();
                }
            });
        }
    });

    $(document).on('click', '.ajaxInvoiceEditBtnCencel', function() {
        $('#invoiceItemEditModal').modal("hide");
    });

    $(document).on('click', '#deleteInvItemBttn', function() {
        var editInvItemId = $('#editInvItemId').val();
        if (editInvItemId) {
            swal({
                    title: "",
                    text: "Are you sure you want to delete this invoice item? Once you have removed it from the invoice adding it back with links to assignment/teacher will not be possible.",
                    buttons: {
                        cancel: "No",
                        Yes: "Yes"
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $('#fullLoader').show();
                            $.ajax({
                                type: 'POST',
                                url: '{{ url('financeInvoiceItemDelete') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    editInvItemId: editInvItemId
                                },
                                dataType: "json",
                                async: false,
                                success: function(res) {
                                    if (res) {
                                        if (res.status == 'success') {
                                            $('#invoiceEditTblAdd').html(res.html);
                                            $('#fullLoader').hide();
                                        }
                                    }
                                    $('#fullLoader').hide();
                                }
                            });
                    }
                });
        } else {
            swal("", "Please select one invoice item.");
        }
    });
</script>
