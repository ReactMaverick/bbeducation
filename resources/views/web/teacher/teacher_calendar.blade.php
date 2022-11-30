@extends('web.layout')
@section('content')
<div class="tab-content assignment-tab-content">

    <div class="assignment-section-col">
        <div class="teacher-calendar-sec">
            <div class="teacher-calendar-sidebar-section">
                <div class="form-check sidebar-mode-check">
                    <label for="html"><a href="#"><i class="fa-solid fa-desktop"></i></a></label>
                    <input type="radio" id="html" name="fav_language" value="HTML">
                </div>
                <div class="form-check sidebar-mode-check">
                    <label for="html"><a href="#"><i class="fa-regular fa-calendar-days"></i></a></label>
                    <input type="radio" id="html" name="fav_language" value="HTML">
                </div>
                <div class="form-check sidebar-mode-check">
                    <label for="html"><a href="#"><i class="fa-solid fa-graduation-cap"></i></a></label>
                    <input type="radio" id="html" name="fav_language" value="HTML">
                </div>
                <div class="form-check sidebar-mode-check">
                    <label for="html"><a href="#"><i class="fa-solid fa-school-flag"></i></a></label>
                    <input type="radio" id="html" name="fav_language" value="HTML">
                </div>
            </div>

            <div class="teacher-calendar-table-section">
                <div class="total-days-slider-sec">
                    <div class="total-days-text">
                        <div class="assignment-date">
                            <i class="fa-solid fa-caret-left"></i>
                        </div>
                        <div class="teacher-calendar-date-text">
                            <span>Mon 28 November 2022</span>
                        </div>
                        <div class="assignment-date2">
                            <i class="fa-solid fa-caret-right"></i>
                        </div>
                    </div>
                </div>

                <div class="teacher-calendar-days-sec">
                    <div class="teacher-calendar-total-days-text">
                        <p>211 days total:</p>
                    </div>
                    <div class="teacher-calendar-days-text">
                        <p>Monday</p>
                        <p class="teacher-calendar-bottom-text">41.46</p>
                    </div>
                    <div class="teacher-calendar-days-text">
                        <p>Tuesday</p>
                        <p class="teacher-calendar-bottom-text">43.46</p>
                    </div>
                    <div class="teacher-calendar-days-text">
                        <p>Wednesday</p>
                        <p class="teacher-calendar-bottom-text">43.46</p>
                    </div>
                    <div class="teacher-calendar-days-text">
                        <p>Thursday</p>
                        <p class="teacher-calendar-bottom-text">42.3</p>
                    </div>
                    <div class="teacher-calendar-days-text">
                        <p>Friday</p>
                        <p class="teacher-calendar-bottom-text">40.3</p>
                    </div>

                    <!-- <div class="teacher-calendar-days-text">
                        <p>Sun</p>
                    </div> -->
                </div>
                <div class="calendar-section">

                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field3">
                            <p>Bede Abii</p>
                            <p>5.4 Days for BB</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>West hampstead Primary School: Whole Day</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>West hampstead Primary School: Whole Day</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>West hampstead Primary School: Whole Day</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>West hampstead Primary School: Whole Day</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>West hampstead Primary School: Whole Day</p>
                        </div>
                    </div>

                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field3">
                            <p>Bede Abii</p>
                            <p>5.4 Days for BB</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field2">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field2">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field2">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field2">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field2">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>

                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field3">
                            <p>Bede Abii</p>
                            <p>5.4 Days for BB</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>
                    <div class="date-left-teacher-calendar">
                        <div class="teacher-calendar-days-field">
                            <p>Tetherdown Primary School: 1.08 Hours</p>
                        </div>
                    </div>

                </div>

                <!-- <form class="status-section">
                    <div class="row">
                        <div class="form-group col-md-6 second-filter-sec">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>


                        <div class="form-group col-md-6 second-filter-sec">
                            <label for="inputCity">First Date</label>
                            <input type="date" class="form-control" id="inputCity" placeholder="&#163 80.00">
                        </div>
                    </div>
                </form> -->
            </div>
        </div>
    </div>

</div>
@endsection