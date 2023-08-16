@extends('web.teacherPortal.layout')
@section('content')
    <style>
        .disabled-link {
            pointer-events: none;
        }

        .form-group.has-error {
            border-color: #dd4b39 !important;
        }
    </style>
    <div class="assignment-detail-page-section">
        <div class="row assignment-detail-row">

            @include('web.teacherPortal.teacher_sidebar')

            <div class="col-md-10 topbar-sec">

                @include('web.teacherPortal.teacher_header')

                <div class="row">
                    <div class="col-md-12">

                        <div class="calendar-heading-sec mb-4">
                            <i class="fa-solid fa-pencil school-edit-icon"></i>
                            <h2>Update Password</h2>
                        </div>

                        <form action="{{ url('/candidate/LogTeacherPasswordUpdate') }}" method="post" class="form-validate">
                            @csrf

                            <div class="modal-input-field-section">
                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-md-6 modal-form-right-sec">
                                        <div class="form-group reset-password-form-group">
                                            <!-- <label for="pwd">Password:</label> -->
                                            <input type="password" class="form-control field-validate" name="password"
                                                placeholder="Password" id="password-input-sec">
                                            <i class="fa-regular fa-eye" id="password-sec-icon"></i>
                                        </div>

                                        <div class="form-group reset-password-form-group">
                                            <!-- <label for="pwd">Confirm Password:</label> -->
                                            <input type="password" class="form-control field-validate"
                                                name="confirm_password" placeholder="Confirm Password"
                                                id="confirm-password-input-sec">
                                            <i class="fa-regular fa-eye" id="confirm-password-sec-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer calendar-modal-footer">
                                <button type="submit" class="btn btn-secondary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $("body").on('click', '#password-sec-icon', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#password-input-sec");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });

        $("body").on('click', '#confirm-password-sec-icon', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#confirm-password-input-sec");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    </script>
@endsection
