@extends('web.schoolPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .form-group.has-error {
            border-color: #dd4b39 !important;
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('web.schoolPortal.school_header')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="assignment-detail-page-section pt-5">
                <div class="row assignment-detail-row">

                    <div class="col-md-6 topbar-sec">

                        <div class="sec_box_edit">
                            <div class="calendar-heading-sec mb-4 details-heading">
                                <h2>Update Password</h2>
                                <i class="fas fa-pen-fancy school-edit-icon"></i>
                            </div>
                            <div class="about-school-section">


                                <form action="{{ url('/school/LogSchoolPasswordUpdate') }}" method="post"
                                    class="form-validate">
                                    @csrf

                                    <div class="modal-input-field-section">
                                        <div class="row">
                                            <div class="col-md-12 modal-form-right-sec">
                                                <div class="form-group form_icon reset-password-form-group">
                                                    <!-- <label for="pwd">Password:</label> -->
                                                    <input type="password" class="form-control field-validate"
                                                        name="password" placeholder="Password" id="password-input-sec">
                                                    <span class="input_icon">
                                                        <i class="fas fa-eye" id="password-sec-icon"></i>
                                                    </span>
                                                </div>

                                                <div class="form-group form_icon reset-password-form-group">
                                                    <!-- <label for="pwd">Confirm Password:</label> -->
                                                    <input type="password" class="form-control field-validate"
                                                        name="confirm_password" placeholder="Confirm Password"
                                                        id="confirm-password-input-sec">
                                                    <span class="input_icon">
                                                        <i class="fas fa-eye" id="confirm-password-sec-icon"></i> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer calendar-modal-footer form_ftr_area">
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </div>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        $("body").on('click', '#password-sec-icon', function() {
            $(this).toggleClass("fa-eye-slash");
            var input = $("#password-input-sec");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $("body").on('click', '#confirm-password-sec-icon', function() {
            $(this).toggleClass("fa-eye-slash");
            var input = $("#confirm-password-input-sec");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endsection
