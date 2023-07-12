<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reference request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="{{ asset('web/js/jquery.min.js') }}"></script>

    <style>
        .form-group.has-error {
            border-color: #dd4b39 !important;
        }

        .clear_btn_outer {
            display: flex;
            justify-content: flex-end;
            /* margin-right: 120px; */
            margin-top: 10px;
        }

        button#clearButton {
            background-color: #fff;
            border: 2px solid #40A0ED;
            padding: 5px 25px;
            border-radius: 5px;
            color: #40A0ED;
        }

        .reset-password-form-outer {
            margin: 50px 0 100px 0;
        }

        .canvas_outer {
            width: 280px;
        }
    </style>
</head>

<body>
    <div class="container-fluid reset-password-section" style="height: fit-content;">
        <div class="reset-password-form-outer reference_form_outer">
            <img src="{{ count($companyDetail) > 0 ? asset($companyDetail[0]->company_logo) : '' }}" alt="">
            <h1>{{ count($companyDetail) > 0 ? $companyDetail[0]->company_name : '' }}</h1>
            <span>Reference Request</span>
            <form action="{{ url('/addReferenceRequest') }}" method="post"
                class="reset-password-form-sec form-validate" id="reqRefForm">
                @csrf
                <input type="hidden" name="teacherReference_id" value="{{ $teacherReference_id }}">
                <input type="hidden" name="adminMail" value="{{ $adminMail }}">
                <div class="row">
                    <label class="form-check-label reference_form_label  col-md-12">REFERENCE REQUEST FOR<span
                            style="color: red;">*</span></label>
                    <div class="modal-input-field form-group col-md-6">
                        <input type="text" class="form-control field-validate" name="ref_request_firstname"
                            id="" value="{{ $refDetail->firstName_txt }}" placeholder="First Name" readonly>
                    </div>
                    <div class="modal-input-field form-group col-md-6">
                        <input type="text" class="form-control field-validate" name="ref_request_lastname"
                            id="" value="{{ $refDetail->surname_txt }}" placeholder="Last Name" readonly>
                    </div>

                    <label class="form-check-label reference_form_label  col-md-12">Your Name<span
                            style="color: red;">*</span></label>
                    <div class="modal-input-field form-group col-md-6">
                        <input type="text" class="form-control field-validate" name="your_firstname" id=""
                            value="" placeholder="First Name">
                    </div>
                    <div class="modal-input-field form-group col-md-6">
                        <input type="text" class="form-control field-validate" name="your_lastname" id=""
                            value="" placeholder="Last Name">
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Your Position<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control field-validate" name="your_location" id=""
                            value="">
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Name of Company / Educational
                            Institution<span style="color: red;">*</span></label>
                        <input type="text" class="form-control field-validate" name="institute_name" id=""
                            value="">
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Date Employed From<span
                                style="color: red;">*</span></label>
                        <input type="date" class="form-control field-validate" name="employed_from" id=""
                            value="">
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Date Employed To<span
                                style="color: red;">*</span></label>
                        <input type="date" class="form-control field-validate" name="employed_to" id=""
                            value="">
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Candidate's Job Title<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control field-validate" name="job_title" id=""
                            value="">
                    </div>

                    <div class="col-md-6"></div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Professional Conduct<span
                                style="color: red;">*</span></label><br>

                        <div style="display: flex;align-items: center;">
                            <input type="radio" id="professionalConduct1" name="professional_conduct"
                                value="Excellent" style="margin-right: 5px;" class="field-validate">
                            <label for="professionalConduct1" style="margin-bottom: 0;">Excellent</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="professionalConduct2"
                                name="professional_conduct" value="Good" style="margin-right: 5px;">
                            <label for="professionalConduct2" style="margin-bottom: 0;">Good</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="professionalConduct3"
                                name="professional_conduct" value="Satisfactory" style="margin-right: 5px;">
                            <label for="professionalConduct3" style="margin-bottom: 0;">Satisfactory</label>
                        </div>

                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Timekeeping<span
                                style="color: red;">*</span></label><br>

                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="timekeep1" name="timekeeping"
                                value="Excellent" style="margin-right: 5px;">
                            <label for="timekeep1" style="margin-bottom: 0;">Excellent</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="timekeep2" name="timekeeping"
                                value="Good" style="margin-right: 5px;">
                            <label for="timekeep2" style="margin-bottom: 0;">Good</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="timekeep3" name="timekeeping"
                                value="Satisfactory" style="margin-right: 5px;">
                            <label for="timekeep3" style="margin-bottom: 0;">Satisfactory</label>
                        </div>

                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Relationship with colleagues<span
                                style="color: red;">*</span></label><br>

                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="colleageRelation1"
                                name="relationship_colleagues" value="Excellent" style="margin-right: 5px;">
                            <label for="colleageRelation1" style="margin-bottom: 0;">Excellent</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="colleageRelation2"
                                name="relationship_colleagues" value="Good" style="margin-right: 5px;">
                            <label for="colleageRelation2" style="margin-bottom: 0;">Good</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="colleageRelation3"
                                name="relationship_colleagues" value="Satisfactory" style="margin-right: 5px;">
                            <label for="colleageRelation3" style="margin-bottom: 0;">Satisfactory</label>
                        </div>
                    </div>

                    <div class="col-md-6"></div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Are there any substantiated or outstanding
                            disciplinary
                            proceedings against this candidate?<span style="color: red;">*</span></label><br>

                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="suitability1"
                                name="outstanding_disciplnary" value="Yes" style="margin-right: 5px;">
                            <label for="suitability1" style="margin-bottom: 0;">Yes</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="suitability2"
                                name="outstanding_disciplnary" value="No" style="margin-right: 5px;">
                            <label for="suitability2" style="margin-bottom: 0;">No</label>
                        </div>
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Do you have any safeguarding concerns
                            about the candidate's
                            suitability to work with children?<span style="color: red;">*</span></label><br>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="workChildren1"
                                name="work_with_children" value="Yes" style="margin-right: 5px;">
                            <label for="workChildren1" style="margin-bottom: 0;">Yes</label>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <input type="radio" class="field-validate" id="workChildren2"
                                name="work_with_children" value="No" style="margin-right: 5px;">
                            <label for="workChildren2" style="margin-bottom: 0;">No</label>
                        </div>
                    </div>

                    <div class="modal-input-field form-group col-md-12">
                        <label class="form-check-label reference_form_label">I declare that to the best of my knowledge
                            that the information
                            I have given in this reference is correct and I agree to share this information with a
                            future employer<span style="color: red;">*</span></label>
                        <div style="display: flex;align-items: center;">
                            <input type="checkbox" class="field-validate" name="agree_chk" id="agreeid"
                                value="1" style="margin-right: 5px;">
                            <label class="form-check-label" for="agreeid" style="margin-bottom: 0;">I Agree</label>
                        </div>
                    </div>

                    <label class="form-check-label reference_form_label col-md-12">Signature</label>
                    <div class="modal-input-field form-group col-md-6">
                        <div class="canvas_outer">
                            <canvas id="signatureCanvas" width="275" height="150"
                                style="border: 2px solid #40A0ED;border-radius: 5px;background-color: #fff;">
                            </canvas>
                            <input type="hidden" id="signatureInput" name="signature" value="">
                            <div class="clear_btn_outer">
                                <button type="button" id="clearButton">Clear</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-input-field form-group col-md-6">
                        <label class="form-check-label reference_form_label">Date<span
                                style="color: red;">*</span></label>
                        <input type="date" class="form-control field-validate" name="signature_date"
                            id="" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <input type="submit" id="reqSendBtn" value="Send">

            </form>
        </div>
        <div class="container-fluid reset-password-footer-sec">
            <span>© 2023 All Rights Reserved. by <a href="javascript:void(0);">Bumblebee</a></span>
        </div>
    </div>

    <script src="{!! asset('plugins/sweetalert/sweetalert.min.js') !!}"></script>
    <?php if (Session::has('error')) { ?>
    <script>
        $(document).ready(function() {
            swal(
                'Failed!',
                '<?php echo session('error'); ?>'
            );
        });
    </script>
    <?php } ?>

    <?php if (Session::has('success')) { ?>
    <script>
        $(document).ready(function() {
            swal(
                'Success!',
                '<?php echo session('success'); ?>'
            );
            setTimeout(function() {
                window.close();
            }, 3000);
        });
    </script>
    <?php } ?>

    <script>
        $(document).ready(function() {
            var canvas = $('#signatureCanvas')[0];
            var context = canvas.getContext('2d');
            var isDrawing = false;
            var lastX = 0;
            var lastY = 0;

            // Set up canvas properties
            context.lineWidth = 2;
            context.strokeStyle = 'black';

            // Set the canvas background color to white
            context.fillStyle = 'white';
            context.fillRect(0, 0, canvas.width, canvas.height);

            // Event handlers for drawing
            $(canvas).mousedown(function(e) {
                isDrawing = true;
                lastX = e.offsetX;
                lastY = e.offsetY;
            }).mousemove(function(e) {
                if (isDrawing) {
                    drawLine(lastX, lastY, e.offsetX, e.offsetY);
                    lastX = e.offsetX;
                    lastY = e.offsetY;
                }
            }).mouseup(function() {
                isDrawing = false;
            }).mouseleave(function() {
                isDrawing = false;
            });

            // Function to draw a line
            function drawLine(x1, y1, x2, y2) {
                context.beginPath();
                context.moveTo(x1, y1);
                context.lineTo(x2, y2);
                context.stroke();
                context.closePath();
            }

            // Form submission
            $('#reqRefForm').submit(function(e) {
                e.preventDefault();
                var error = "";

                //to validate text field
                $(".field-validate").each(function() {
                    if ($(this).is(':radio') || $(this).is(':checkbox')) {
                        var groupName = $(this).attr('name');
                        if ($('input[name="' + groupName + '"]:checked').length === 0) {
                            $(this).closest(".form-group").addClass('has-error');
                            error = "has error";
                        } else {
                            $(this).closest(".form-group").removeClass('has-error');
                        }
                    } else {
                        if (this.value == '') {
                            $(this).closest(".form-group").addClass('has-error');
                            error = "has error";
                        } else {
                            $(this).closest(".form-group").removeClass('has-error');
                        }
                    }
                });

                if (error == "has error") {
                    swal(
                        'Failed!',
                        'Kindly fill all the mandatory fields.'
                    );
                    return false;
                } else {
                    var imageData = canvas.toDataURL('image/png');
                    $('#signatureInput').val(imageData);

                    this.submit();
                    $("#reqSendBtn").prop('disabled', true);
                }
            });

            // Clear canvas on button click
            $('#clearButton').click(function() {
                context.clearRect(0, 0, canvas.width, canvas.height);
            });
        });


        /******* field validate 1 ********/
        // $(document).on('submit', '.form-validate', function(e) {
        //     var error = "";

        //     //to validate text field
        //     $(".field-validate").each(function() {

        //         if (this.value == '') {

        //             $(this).closest(".form-group").addClass('has-error');
        //             //$(this).next(".error-content").removeClass('hidden');
        //             error = "has error";
        //         } else {
        //             $(this).closest(".form-group").removeClass('has-error');
        //             //$(this).next(".error-content").addClass('hidden');
        //         }
        //     });

        //     if (error == "has error") {
        //         return false;
        //     }

        // });

        $(document).on('keyup change', '.field-validate', function(e) {
            if ($(this).is(':radio') || $(this).is(':checkbox')) {
                if (!$(this).is(':checked')) {
                    $(this).closest(".form-group").addClass('has-error');
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            } else {
                if (this.value == '') {
                    $(this).closest(".form-group").addClass('has-error');
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            }
        });
        /******* field validate 1 ********/
    </script>

</body>

</html>
