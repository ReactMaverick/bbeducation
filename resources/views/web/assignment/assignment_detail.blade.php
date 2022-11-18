@extends('web.layout')
@section('content')

<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">
        <div class="col-md-2 sidebar-col">
            <div class="assignment-detail-sidebar-sec">
                <div class="sidebar-top-text">
                    <h2>Hendon Preparatory School</h2>
                    <span>100960</span>
                    <i class="fa-solid fa-square-check"></i>
                </div>

                <div class="sidebar-pages-section sidebar-active">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-person-chalkboard"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Assignment</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-comment"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Contact</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Candidates</span>
                        </div>
                    </a>
                </div>

                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>School Details</span>
                        </div>
                    </a>
                </div>
                <div class="sidebar-pages-section">
                    <a href="#" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-money-bills"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Finance</span>
                        </div>
                    </a>
                </div>

                <div class="teacher-name">
                    <span>Dalila Kesri</span>
                </div>

                <div class="user-img-sec">
                    <img src="{{ asset('web/images/user-img.png') }}" alt="">
                </div>

                <div class="sidebar-user-number">
                    <span>11297</span>
                </div>

                <div class="sidebar-check-icon">
                    <i class="fa-solid fa-square-check"></i>
                </div>
                <div class="assignment-id-text-sec">
                    <span>Assignment ID :</span>
                    <span>3294</span>
                </div>

            </div>
        </div>

        <div class="col-md-10 topbar-sec">
            <div class="topbar-Section">
                <i class="fa-solid fa-crown"></i>
                <a href="#"> <i class="fa-solid fa-trash trash-icon"></i></a>
            </div>

            <div class="assignment-detail-right-sec">
                <form class="filter-section">
                    <div class="filter-group-sec">
                        <div class="form-group">
                            <label for="inputState">Age Range</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Age Range</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Age Range</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Age Range</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Age Range</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Age Range</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div>

                    <div class="row filter-input-sec">
                        <div class="form-group filter-input-sec-group col-md-6">
                            <label for="inputCity">Daily Charge</label>
                            <input type="text" class="form-control" id="inputCity" placeholder="&#163 130">
                        </div>

                        <div class="form-group filter-input-sec-group2 col-md-6">
                            <label for="inputCity">Daily Pay</label>
                            <input type="text" class="form-control" id="inputCity" placeholder="&#163 80.00">
                        </div>
                    </div>
                </form>

                <div class="assignment-time-table-section">
                    <div class="total-days-section">
                        <div class="days-slider-sec">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>

                        <div class="date-section">
                            <div class="total-days-slider-sec">
                                <div class="total-days-text">
                                    <div class="assignment-date">
                                        <span>1.41</span>
                                    </div>
                                    <div class="assignment-date-text">
                                        <span>Total Days: 2.41</span>
                                    </div>
                                    <div class="assignment-date2">
                                        <span>1</span>
                                    </div>
                                </div>
                                <div class="total-days-text">
                                    <div class="assignment-date">
                                        <i class="fa-solid fa-caret-left"></i>
                                    </div>
                                    <div class="assignment-date-text">
                                        <span>10 October 2022</span>
                                    </div>
                                    <div class="assignment-date2">
                                        <i class="fa-solid fa-caret-right"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="calendar-days-sec">
                                <div class="calendar-days-text">
                                    <p>Mon</p>
                                </div>
                                <div class="calendar-days-text">
                                    <p>Tue</p>
                                </div>
                                <div class="calendar-days-text">
                                    <p>Wed</p>
                                </div>
                                <div class="calendar-days-text">
                                    <p>Thu</p>
                                </div>
                                <div class="calendar-days-text">
                                    <p>Fri</p>
                                </div>
                                <div class="calendar-days-text">
                                    <p>Sat</p>
                                </div>
                                <div class="calendar-days-text">
                                    <p>Sun</p>
                                </div>
                            </div>
                            <div class="calendar-section">

                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>

                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                                <div class="date-left-calendar">
                                    <h2>10 10 2022</h2>
                                    <div class="calendar-days-field">

                                    </div>
                                </div>
                            </div>

                            <form class="status-section">
                                <div class="row">
                                    <div class="form-group col-md-6 second-filter-sec">
                                        <label for="inputState">Status</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="inputCity">First Date</label>
                                        <input type="date" class="form-control" id="inputCity"
                                            placeholder="&#163 80.00">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mode-section">
                    <div class="mode-text-sec">
                        <p>Mode</p>
                        <div class="form-check mode-check">
                            <label for="html"><a href="#"><i class="fa-solid fa-plus"></i></a></label>
                            <input type="radio" id="html" name="fav_language" value="HTML">
                        </div>
                        <div class="form-check mode-check">
                            <label for="html"><a href="#"><i class="fa-solid fa-pencil"></i></a></label>
                            <input type="radio" id="html" name="fav_language" value="HTML">
                        </div>
                        <div class="form-check mode-check">
                            <label for="html"><a href="#"><i
                                        class="fa-solid fa-right-long next-arrow-icon"></i></a></label>
                            <input type="radio" id="html" name="fav_language" value="HTML">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row assignment-notes-sec">
                <div class="form-group col-md-6 label-heading">
                    <label for="comment">Last Contact re. Assignment</label>
                    <textarea class="form-control" rows="5" id="comment"></textarea>
                </div>
                <div class="form-group col-md-6 label-heading">
                    <label for="comment">Assignment Notes</label>
                    <textarea class="form-control" rows="5" id="comment"></textarea>
                </div>
            </div>

            <div class="button-section">
                <button class="button-1">Candidate Vetting</button>
                <!-- <button class="button-2">Block Booking -->

                <button type="button" class="btn btn-primary button-2" data-toggle="modal" data-target="#myModal">
                    Block Booking
                </button>

                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-dialog-centered calendar-modal-section">
                        <div class="modal-content calendar-modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header calendar-modal-header">
                                <h4 class="modal-title">Edit Working Day</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="calendar-heading-sec">
                                <i class="fa-solid fa-pencil school-edit-icon"></i>
                                <h2>Edit Assignment Day</h2>
                            </div>

                            <div class="modal-input-field-section">
                                <div class="modal-input-field">
                                    <label class="form-check-label">Date</label>
                                    <input type="date" class="form-control" name="booked_day" id="booked_day" value="">
                                </div>

                                <div class="form-group calendar-form-filter">
                                    <label for="inputState">Part of Day</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Percentage of a day</label>
                                    <input type="number" class="form-control" name="booked_day" id="booked_day"
                                        value="">
                                </div>

                                <div class="modal-input-field">
                                    <label class="form-check-label">Hours</label>
                                    <input type="time" class="form-control" name="booked_day" id="booked_day" value="">
                                </div>

                                <div class="modal-side-field">
                                    <label class="form-check-label">Charge</label>
                                    <input type="text" class="form-control" name="booked_day" id="booked_day" value="">
                                </div>
                                <div class="modal-side-field second">
                                    <label class="form-check-label">Pay</label>
                                    <input type="text" class="form-control" name="booked_day" id="booked_day" value="">
                                </div>
                            </div>


                            <!-- Modal body
                            <div class="modal-body">
                                Modal body..
                            </div> -->

                            <!-- Modal footer -->
                            <div class="modal-footer calendar-modal-footer">
                                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- </button> -->
                <button type="submit" class="btn btn-primary button-3">Submit</button>
            </div>

        </div>
    </div>
</div>
@endsection