@extends('web.layout')
@section('content')
<style>
.disabled-link {
    pointer-events: none;
}
</style>
<div class="assignment-detail-page-section">
    <div class="row assignment-detail-row">

        @include('web.teacher.teacher_sidebar')

        <div class="col-md-10 topbar-sec">

            @include('web.teacher.teacher_header')

            <div class="school-detail-right-sec">
                <div class="school-details-first-sec">
                    <div class="details-heading">
                        <h2>Details</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="about-school-section">
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>ID</h2>
                            </div>
                            <div class="school-name-text">
                                <p>10280</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Title</h2>
                            </div>
                            <div class="school-name-text">
                                <p>Mr</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>First Name</h2>
                            </div>
                            <div class="grid-refs-sec">
                                <div class="grid-refs-text1">
                                    <p>Alberto</p>
                                </div>

                                <div class="grid-refs-text1">
                                    <p>Alonso</p>
                                </div>

                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Known As</h2>
                            </div>
                            <div class="school-name-text">
                                <p>abc</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Maiden Nameas</h2>
                            </div>
                            <div class="school-name-text">
                                <p>abc</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Date of Birth</h2>
                            </div>
                            <div class="school-name-text">
                                <p>12-04-1992</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Nationality</h2>
                            </div>
                            <div class="school-name-text">
                                <p>Spanish</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="school-details-second-sec">
                    <div>
                        <div class="details-heading">
                            <h2>Address</h2>
                            <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </div>

                        <!-- <div class="about-school-section"> -->
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Full Address</h2>
                            </div>
                            <div class="school-name-text">
                                <p>Flat 3, 14 Cholmeley Park</p>
                                <p>N6 5EU</p>
                            </div>
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Grid Refs</h2>
                            </div>
                            <div class="school-name-text">
                                <p>51.5742105</p>
                                <p>-0.1434667</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="school-detail-right-sec">

                <div class="school-details-contact-second-sec">
                    <div class="contact-heading">
                        <div class="contact-heading-text">
                            <h2>Contacts</h2>
                        </div>
                        <div class="contact-icon-sec">
                            <a style="cursor: pointer" class="disabled-link" id="phoneContactItemBttn">
                                <i class="fa-solid fa-mobile-screen"></i>
                            </a>
                            <a style="cursor: pointer" class="disabled-link" id="mailContactItemBttn">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                            <a data-toggle="modal" data-target="#ContactItemAddModal" style="cursor: pointer;">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a style="cursor: pointer;" class="disabled-link" id="editContactBttn">
                                <i class="fa-solid fa-pencil school-edit-icon"></i>
                            </a>
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
                    </div>
                </div>


                <div class="school-details-first-sec">
                    <div class="details-heading">
                        <h2>Emergency Contact</h2>
                        <a data-toggle="modal" data-target="#DetailModal" style="cursor: pointer;"><i
                                class="fa-solid fa-pencil"></i></a>
                    </div>

                    <div class="about-school-section">
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Emergency Contact</h2>
                            </div>
                            <div class="school-name-text">
                                <p>0208 432 9844</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Relationship</h2>
                            </div>
                            <!-- <div class="school-name-text">
                                <p>Mr</p>
                            </div> -->
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Contact Num 1</h2>
                            </div>
                            <!-- <div class="grid-refs-sec">
                                <div class="grid-refs-text1">
                                    <p>Alberto</p>
                                </div>

                                <div class="grid-refs-text1">
                                    <p>Alonso</p>
                                </div>
                            </div> -->
                        </div>

                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Contact Num 2</h2>
                            </div>
                            <!-- <div class="school-name-text">
                                <p>abc</p>
                            </div> -->
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