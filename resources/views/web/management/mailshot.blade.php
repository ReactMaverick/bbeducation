@extends('web.layout')
@section('content')
<div class="assignment-section-col">

    <div class="teacher-all-section">
        <div class="finance-section">
            <div class="management-mailshot-heading-section">
                <h2>Management Mailshot</h2>
            </div>

            <div class="management-mailshot-all-section">
                <div class="management-mailshot-left-sec">
                    <div class="mailshot-page-sub-heading">
                        <h2>Email Message</h2>
                    </div>

                    <div class="management-mailshot-input-section">
                        <div class="management-mailshot-section">
                            <div class="management-mailshot-text-sec">
                                <label for="inputCity">Title</label>
                            </div>
                            <div class="management-mailshot-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>

                        <div class="management-mailshot-section">
                            <div class="management-mailshot-text-sec">
                                <label for="inputCity">Description</label>
                            </div>
                            <div class="management-mailshot-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>
                    </div>

                    <div class="assignment-finance-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Type</th>
                                    <th>Item</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data editContactRow">
                                    <td>Email</td>
                                    <td>alberto.ojaguren@gmail.com</td>
                                </tr>
                                <tr class="school-detail-table-data editContactRow">
                                    <td>Mobile phone (main)</td>
                                    <td>07438145122</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="management-mailshot-btn-section">
                            <div class="management-mailshot-bottom-text">
                                <span>Character Limit of 10000 characters</span>
                            </div>
                            <div class="management-mailshot-btn">
                                <button>Remove Permission</button>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="management-mailshot-right-sec">
                    <div class="mailshot-page-sub-heading">
                        <h2>Mailshot Target Lists</h2>
                    </div>

                    <div class="management-mailshot-table-section">
                        <table class="table school-detail-page-table" id="myTable">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Type</th>
                                    <th>Item</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                <tr class="school-detail-table-data editContactRow">
                                    <td>Email</td>
                                    <td>alberto.ojaguren@gmail.com</td>
                                </tr>
                                <tr class="school-detail-table-data editContactRow">
                                    <td>Mobile phone (main)</td>
                                    <td>07438145122</td>
                                </tr>
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
    $('#myTable, #myTable1').DataTable();
});
</script>
@endsection