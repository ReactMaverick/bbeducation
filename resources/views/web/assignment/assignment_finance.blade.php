@extends('web.layout')
@section('content')
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.assignment.assignment_sidebar')

            <div class="col-md-10 topbar-sec">
                <div class="topbar-Section">
                    <i class="fa-solid fa-crown"></i>
                    <a href="#"> <i class="fa-solid fa-trash trash-icon"></i></a>
                </div>
                <div class="school-assignment-sec">
                    <div class="assignment-finance-section">
                        <div class="assignment-finance-heading-section">
                            <h2>Finance</h2>
                            <div class="assignment-finance-icon-section">
                                <a href="#"><i class="fa-solid fa-square-check"></i></a>
                                <a href="#"><i class="fa-solid fa-file-lines"></i></a>
                                <a href="#"><i class="fa-solid fa-envelope"></i></a>
                            </div>

                        </div>
                        <div class="assignment-finance-table-section">
                            <table class="table school-detail-page-table" id="myTable">
                                <thead>
                                    <tr class="school-detail-table-heading">
                                        <th>Invoice ID</th>
                                        <th>Invoice Date</th>
                                        <th>Net</th>
                                        <th>Vat</th>
                                        <th>Gross</th>
                                        <th>Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-sec">
                                    @foreach ($invoiceList as $key1 => $invoice)
                                        @if ($invoice->invoice_id)
                                            <tr class="school-detail-table-data">
                                                <td>{{ $invoice->invoice_id }}</td>
                                                <td>{{ date('d-m-Y', strtotime($invoice->invoiceDate_dte)) }}</td>
                                                <td>{{ $invoice->net_dec }}</td>
                                                <td>{{ $invoice->vat_dec }}</td>
                                                <td>{{ $invoice->gross_dec }}</td>
                                                <td>{{ date('d-m-Y', strtotime($invoice->paidOn_dte)) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
