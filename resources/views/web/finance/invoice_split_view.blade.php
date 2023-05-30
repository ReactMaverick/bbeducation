<input type="hidden" name="splitInvoiceId" id="splitInvoiceId" value="{{ $invoiceDetail->invoice_id }}">
<input type="hidden" name="splitInvoiceSchoolId" id="splitInvoiceSchoolId" value="{{ $invoiceDetail->school_id }}">

<span>School</span>
<p>{{ $invoiceDetail->name_txt }}</p>

<div class="row">
    <div class="col-md-6">
        <div class="modal-input-field form-group">
            <label class="form-check-label">Invoice Date</label>
            <input type="text" class="form-control datePickerPaste" name="invoiceDate_dte" id=""
                value="{{ $invoiceDetail->invoiceDate_dte != null ? date('d/m/Y', strtotime($invoiceDetail->invoiceDate_dte)) : '' }}">
        </div>


        <div class="modal-input-field form-group">
            <label class="form-check-label">Paid On</label>
            <input type="text" class="form-control datePickerPaste" name="paidOn_dte" id=""
                value="{{ $invoiceDetail->paidOn_dte != null ? date('d/m/Y', strtotime($invoiceDetail->paidOn_dte)) : '' }}">
        </div>
    </div>
    <div class="col-md-6"></div>

    <input type="hidden" name="splitInvoiceItemCount" id="splitInvoiceItemCount" value="{{ count($invoiceItemList) }}">
    <input type="hidden" name="splitInvoiceSelectedItems" id="splitInvoiceSelectedItems" value="">

    <div class="col-md-12" style="width: 100%;">
        <table class="table school-detail-page-table" id="splitItemTable" style="width: 100%;">
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
            <tbody class="table-body-sec">
                @foreach ($invoiceItemList as $key => $invoiceItem)
                    <tr class="school-detail-table-data splitInvItemRow"
                        onclick="splitItemRowSelect({{ $invoiceItem->invoiceItem_id }})"
                        id="splitInvItemRow{{ $invoiceItem->invoiceItem_id }}">
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

<script>
    $(document).ready(function() {
        $('#splitItemTable').DataTable({
            searching: false,
            paging: false,
            info: false
        });

        $('.datePickerPaste').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            weekStart: 1
        });
    });

    var itemArray = [];

    function splitItemRowSelect(invoiceItem_id) {
        if ($('#splitInvItemRow' + invoiceItem_id).hasClass('tableRowActive')) {
            $('#splitInvItemRow' + invoiceItem_id).removeClass('tableRowActive');
        } else {
            $('#splitInvItemRow' + invoiceItem_id).addClass('tableRowActive');
        }
        var tempArr = addOrRemove(itemArray, invoiceItem_id);
        // console.log("===>>>>>", tempArr);
        var itemString = tempArr.toString();
        $('#splitInvoiceSelectedItems').val(itemString);
    }


    function addOrRemove(array, item) {
        var exists = array.includes(item)
        if (exists) {
            var index = array.indexOf(item);
            if (index !== -1) {
                array.splice(index, 1);
            }
            return array;
        } else {
            var result = array
            result.push(item)
            return result
        }
    }
</script>
