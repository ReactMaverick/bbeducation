@extends('web.layout')
@section('content')
<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">

        <div class="col-md-2 sidebar-col">
            <div class="assignment-detail-sidebar-sec">
                <div class="sidebar-top-text">
                    <h2>Alberto Alonso</h2>
                    <div class="teacher-detail-user-img-sec">
                        <div class="management-user-img-sec">
                            <img src="{{ asset('web/images/user-img.png') }}" alt="">
                                <a href="#">
                                    <i class="fa-solid fa-plus"></i>
                                </a>

                        </div>
                    </div>
                    <div class="management-user-sidebar-top-text">
                        <p>Age: 41</p>
                    </div>
                </div>

                <div class="sidebar-pages-section @if ($title['pageTitle']=='Teacher Detail') sidebar-active @endif">
                    <a href="{{ URL::to('/management-user/') }}" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-address-book"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Details</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-10 topbar-sec">
            <div class="school-detail-right-sec">
                <div class="management-user-first-sec">
                    <div class="details-heading">
                        <h2>Details</h2>
                    </div>

                    <div class="about-school-section">

                        <div class="management-user-section">
                            <div class="form-group management-user-select-sec">
                                <label for="inputState">Title</label>
                                <select id="inputState" class="form-control">
                                    <option selected="">Mr</option>
                                    <option>Ms</option>
                                    <option>Mrs</option>
                                </select>
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">First Name</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">Surname Name</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">Known As</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">Date of Birth</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="vehicle1">Is Current</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">Work Email</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">Start Date</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>

                        <div class="management-user-section">
                            <div class="management-user-text-sec">
                                <label for="inputCity">Last Date</label>
                            </div>
                            <div class="management-user-input-sec">
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="school-detail-right-sec">

                <div class="management-user-second-sec">
                    <div class="contact-heading">
                        <div class="contact-heading-text">
                            <h2>Permission</h2>
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

                        <div class="management-user-btn-section">
                            <div class="management-user-btn">
                                <button>Add Permission</button>
                            </div>
                            <div class="management-user-btn">
                                <button>Remove Permission</button>
                            </div>
                        </div>

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