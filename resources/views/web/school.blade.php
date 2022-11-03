@extends('web.layout')
@section('content')
<div class="tab-content dashboard-tab-content" id="myTabContent">
    <div class="assignment-section-col">

        <div class="teacher-all-section">
            <div class="teacher-section">
                <div class="teacher-page-sec">
                    <h2>Schools</h2>
                </div>
                <div class="teacher-left-sec">
                    <div class="about-teacher">
                        <a href="#"> <i class="fa-solid fa-magnifying-glass"></i>
                            <p>Find School</p>
                        </a>
                    </div>

                    <div class="about-teacher">
                        <a href="#"> <i class="fa-solid fa-school-circle-check"></i>
                            <p>Add New</p>
                            <p>School</p>
                        </a>
                    </div>
                </div>
                



            </div>

            <div class="teacher-page-table-section">
                <table class="table teacher-page-table">
                    <thead>
                        <tr class="table-heading">

                            <th><i class="fa-solid fa-star">Favourites</i></th>
                        </tr>
                    </thead>
                    <tbody class="table-body-sec">
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                        <tr class="table-data">
                            <td>Alexandra Primary Schhol</td>
                            <td>Primary</td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>
@endsection