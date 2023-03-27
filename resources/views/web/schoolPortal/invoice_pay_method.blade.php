<input type="hidden" name="invoice_id" value="{{ $invoiceDetail->invoice_id }}">

<div class="modal-input-field-section">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group modal-input-field">
                <label class="form-check-label">Paid On</label>
                <input type="date" class="form-control field-validate-2" name="school_paid_dte" id=""
                    value="{{ $invoiceDetail->school_paid_dte ? $invoiceDetail->school_paid_dte : date('Y-m-d') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group calendar-form-filter">
                <label for="">Payment Method</label>
                <select class="form-control field-validate-2" name="school_paid_method" id="">
                    <option value="">Choose one</option>
                    @foreach ($paymentMethodList as $key1 => $paymentMethod)
                        <option value="{{ $paymentMethod->description_int }}" <?php echo $invoiceDetail->school_paid_method == $paymentMethod->description_int ? 'selected' : ''; ?>>
                            {{ $paymentMethod->description_txt }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($invoiceDetail->paidOn_dte)
            <p style="color: brown">Invoice already remitted</p>
        @endif
    </div>
</div>

<!-- Modal footer -->
<div class="modal-footer calendar-modal-footer">
    @if ($invoiceDetail->paidOn_dte == null)
        <button type="submit" class="btn btn-secondary">Submit</button>
    @endif

    <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
</div>
