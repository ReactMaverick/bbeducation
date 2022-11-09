@extends('web.layout')
@section('content')
<!-- <div class="assignment-section-col">
    <div class="teacher-all-section">
        <div class="finance-section">
            <div class="teacher-page-sec">
                <h2>Finance</h2>
            </div>
        </div>
    </div>
</div> -->

<div class="assignment-detail-page-section">
    <div class="row">
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
                    <div class="form-group filter-group-sec">
                        <label for="inputState">Age Range</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>

                        <label for="inputState">Age Range</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>

                        <label for="inputState">Age Range</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>

                        <label for="inputState">Age Range</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>

                        <label for="inputState">Age Range</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>

                        <label for="inputState">Age Range</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>

                    <div class="row filter-input-sec">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Daily Charge</label>
                            <input type="text" class="form-control" id="inputCity">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputCity">Daily Pay</label>
                            <input type="text" class="form-control" id="inputCity">
                        </div>
                    </div>
                </form>

                <div class="assignment-time-table-section">
                    <div class="total-days-section">
                        <div class="days-slider-sec">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>

                        <div class="date-section">
                            <div class="total-days-text">
                                <div class="assignment-date">
                                    <span>1.41</span>
                                </div>
                                <div class="assignment-date-text">
                                    <span>Total Days: 2.41</span>
                                </div>
                                <div class="assignment-date">
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
                                <div class="assignment-date">
                                    <i class="fa-solid fa-caret-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="total-days-section">
                        <div class="days-slider-sec">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>

                        
                            
                        </div>
                    </div> -->
                </div>


            </div>

        </div>


    </div>
</div>

@endsection