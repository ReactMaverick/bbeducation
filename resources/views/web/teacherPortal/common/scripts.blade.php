<script src="{!! asset('plugins/select2/select2.full.min.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"
    integrity="sha512-XKa9Hemdy1Ui3KSGgJdgMyYlUg1gM+QhL6cnlyTe2qzMCYm4nAZ1PsVerQzTTXzonUR+dmswHqgJPuwCq1MaAg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{!! asset('plugins/sweetalert/sweetalert.min.js') !!}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.14.0/jquery.timepicker.js"
    integrity="sha512-v84GNWs/NREzyztDm0s2NCXR9tIXH4aD/pe3uktyJeCWICr+/J38obdjXx1wxPRzTXHY54Hf0zBD5fbuRSNvGw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php if (Session::has('success')){ ?>
<script>
    $(document).ready(function() {
        swal(
            'Success!',
            '<?php echo session('success'); ?>',
            'success'
        );
    });
</script>
<?php } ?>

<?php if (Session::has('error')){ ?>
<script>
    $(document).ready(function() {
        swal(
            'Failed!',
            '<?php echo session('error'); ?>',
            'warning'
        );
    });
</script>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#fullLoader').hide();
        $(".select2").select2();

        $('.datePickerPaste').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            weekStart: 1
        });
    });

    $(document).on('keyup', '.onlynumber', function(e) {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });

    /******* field validate 1 ********/
    $(document).on('submit', '.form-validate', function(e) {
        var error = "";

        //to validate text field
        $(".field-validate").each(function() {

            if (this.value == '') {

                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        $(".number-validate").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        //focus form field
        $(".price-validate").each(function() {

            if (this.value == '' || this.value < 1 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });

        //
        $(".email-validate").each(function() {
            var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.value != '' && validEmail.test(this.value)) {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');

            } else {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            }
        });

        //phone validate
        $(".phone-validate").each(function() {
            if (this.value == '' || this.value.length < 10 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //postcode validate
        $(".postcode-validate").each(function() {
            if (this.value == '' || this.value.length < 6 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //file validate
        $(".file-validate").each(function() {
            if ($('.file-validate').get(0).files.length === 0) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                var ext = $('.file-validate').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            }
        });

        $(".datepaste-validate").each(function() {
            var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (this.value == '' || !dateRegex.test(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        if (error == "has error") {
            return false;
        }

    });

    $(document).on('keyup change', '.datepaste-validate', function(e) {
        var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
        if (this.value == '' || !dateRegex.test(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.phone-validate', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 10) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.postcode-validate', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 6) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup change', '.field-validate', function(e) {

        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.number-validate', function(e) {

        if (this.value == '' || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.price-validate', function(e) {

        if (this.value == '' || this.value < 1 || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup focusout', '.email-validate', function(e) {
        var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (this.value != '' && validEmail.test(this.value)) {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        } else {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
            error = "has error";
        }
    });

    $(document).on('change', '.file-validate', function(e) {
        if ($('.file-validate').get(0).files.length === 0) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";
        } else {
            var ext = $('.file-validate').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        }
    });
    /******* field validate 1 ********/

    /******* field validate 2 ********/
    $(document).on('submit', '.form-validate-2', function(e) {
        var error = "";

        //to validate text field
        $(".field-validate-2").each(function() {

            if (this.value == '') {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        $(".number-validate-2").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        //focus form field
        $(".price-validate-2").each(function() {

            if (this.value == '' || this.value < 1 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });

        //
        $(".email-validate-2").each(function() {
            var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.value != '' && validEmail.test(this.value)) {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');

            } else {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            }
        });

        //phone validate
        $(".phone-validate-2").each(function() {
            if (this.value == '' || this.value.length < 10 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //postcode validate
        $(".postcode-validate-2").each(function() {
            if (this.value == '' || this.value.length < 6 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //file validate
        $(".file-validate-2").each(function() {
            if ($('.file-validate-2').get(0).files.length === 0) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                var ext = $('.file-validate-2').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            }
        });

        $(".datepaste-validate-2").each(function() {
            var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (this.value == '' || !dateRegex.test(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        if (error == "has error") {
            return false;
        }

    });

    $(document).on('keyup change', '.datepaste-validate-2', function(e) {
        var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
        if (this.value == '' || !dateRegex.test(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.phone-validate-2', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 10) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.postcode-validate-2', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 6) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup change', '.field-validate-2', function(e) {

        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.number-validate-2', function(e) {

        if (this.value == '' || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.price-validate-2', function(e) {

        if (this.value == '' || this.value < 1 || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup focusout', '.email-validate-2', function(e) {
        var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (this.value != '' && validEmail.test(this.value)) {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        } else {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
            error = "has error";
        }
    });

    $(document).on('change', '.file-validate-2', function(e) {
        if ($('.file-validate-2').get(0).files.length === 0) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";
        } else {
            var ext = $('.file-validate-2').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        }
    });
    /******* field validate 2 ********/

    /******* field validate 3 ********/
    $(document).on('submit', '.form-validate-3', function(e) {
        var error = "";

        //to validate text field
        $(".field-validate-3").each(function() {

            if (this.value == '') {

                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        $(".number-validate-3").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        //focus form field
        $(".price-validate-3").each(function() {

            if (this.value == '' || this.value < 1 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });

        //
        $(".email-validate-3").each(function() {
            var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.value != '' && validEmail.test(this.value)) {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');

            } else {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            }
        });

        //phone validate
        $(".phone-validate-3").each(function() {
            if (this.value == '' || this.value.length < 10 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //postcode validate
        $(".postcode-validate-3").each(function() {
            if (this.value == '' || this.value.length < 6 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //file validate
        $(".file-validate-3").each(function() {
            if ($('.file-validate-3').get(0).files.length === 0) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                var ext = $('.file-validate-3').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            }
        });

        $(".checkbox-validate-3").each(function() {
            if ($('.checkbox-validate-3').is(':checked')) {
                $('.checkbox-validate-3').closest(".form-group").removeClass('has-error');
            } else {
                $('.checkbox-validate-3').closest(".form-group").addClass('has-error');
                error = "has error";
            }
        });

        $(".datepaste-validate-3").each(function() {
            var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (this.value == '' || !dateRegex.test(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        if (error == "has error") {
            return false;
        }

    });

    $(document).on('keyup change', '.datepaste-validate-3', function(e) {
        var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
        if (this.value == '' || !dateRegex.test(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.phone-validate-3', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 10) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.postcode-validate-3', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 6) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup change', '.field-validate-3', function(e) {

        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.number-validate-3', function(e) {

        if (this.value == '' || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.price-validate-3', function(e) {

        if (this.value == '' || this.value < 1 || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup focusout', '.email-validate-3', function(e) {
        var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (this.value != '' && validEmail.test(this.value)) {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        } else {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
            error = "has error";
        }
    });

    $(document).on('change', '.file-validate-3', function(e) {
        if ($('.file-validate-3').get(0).files.length === 0) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";
        } else {
            var ext = $('.file-validate-3').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        }
    });

    $(document).on('change', '.checkbox-validate-3', function(e) {
        if ($('.checkbox-validate-3').is(':checked')) {
            $('.checkbox-validate-3').closest(".form-group").removeClass('has-error');
        } else {
            $('.checkbox-validate-3').closest(".form-group").addClass('has-error');
            error = "has error";
        }
    });
    /******* field validate 3 ********/

    /******* field validate 4 ********/
    $(document).on('submit', '.form-validate-4', function(e) {
        var error = "";

        //to validate text field
        $(".field-validate-4").each(function() {

            if (this.value == '') {

                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        $(".number-validate-4").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        //focus form field
        $(".price-validate-4").each(function() {

            if (this.value == '' || this.value < 1 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });

        //
        $(".email-validate-4").each(function() {
            var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.value != '' && validEmail.test(this.value)) {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');

            } else {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            }
        });

        //phone validate
        $(".phone-validate-4").each(function() {
            if (this.value == '' || this.value.length < 10 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //postcode validate
        $(".postcode-validate-4").each(function() {
            if (this.value == '' || this.value.length < 6 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //file validate
        $(".file-validate-4").each(function() {
            if ($('.file-validate-4').get(0).files.length === 0) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                var ext = $('.file-validate-4').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            }
        });

        $(".datepaste-validate-4").each(function() {
            var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (this.value == '' || !dateRegex.test(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        if (error == "has error") {
            return false;
        }

    });

    $(document).on('keyup change', '.datepaste-validate-4', function(e) {
        var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
        if (this.value == '' || !dateRegex.test(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.phone-validate-4', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 10) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.postcode-validate-4', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 6) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup change', '.field-validate-4', function(e) {

        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.number-validate-4', function(e) {

        if (this.value == '' || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.price-validate-4', function(e) {

        if (this.value == '' || this.value < 1 || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup focusout', '.email-validate-4', function(e) {
        var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (this.value != '' && validEmail.test(this.value)) {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        } else {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
            error = "has error";
        }
    });

    $(document).on('change', '.file-validate-4', function(e) {
        if ($('.file-validate-4').get(0).files.length === 0) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";
        } else {
            var ext = $('.file-validate-4').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        }
    });
    /******* field validate 4 ********/

    /******* field validate 4 ********/
    $(document).on('submit', '.form-validate-5', function(e) {
        var error = "";

        //to validate text field
        $(".field-validate-5").each(function() {

            if (this.value == '') {

                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        $(".number-validate-5").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        //focus form field
        $(".price-validate-5").each(function() {

            if (this.value == '' || this.value < 1 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });

        //
        $(".email-validate-5").each(function() {
            var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.value != '' && validEmail.test(this.value)) {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');

            } else {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            }
        });

        //phone validate
        $(".phone-validate-5").each(function() {
            if (this.value == '' || this.value.length < 10 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //postcode validate
        $(".postcode-validate-5").each(function() {
            if (this.value == '' || this.value.length < 6 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        $(".datepaste-validate-5").each(function() {
            var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (this.value == '' || !dateRegex.test(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        if (error == "has error") {
            return false;
        }

    });

    $(document).on('keyup change', '.datepaste-validate-5', function(e) {
        var dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/;
        if (this.value == '' || !dateRegex.test(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.phone-validate-5', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 10) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.postcode-validate-5', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 6) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup change', '.field-validate-5', function(e) {

        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.number-validate-5', function(e) {

        if (this.value == '' || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.price-validate-5', function(e) {

        if (this.value == '' || this.value < 1 || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup focusout', '.email-validate-5', function(e) {
        var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (this.value != '' && validEmail.test(this.value)) {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        } else {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
            error = "has error";
        }
    });
    /******* field validate 5 ********/

    /******* field validate 6 ********/
    $(document).on('submit', '.form-validate-6', function(e) {
        var error = "";

        //to validate text field
        $(".field-validate-6").each(function() {

            if (this.value == '') {

                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        $(".number-validate-6").each(function() {
            if (this.value == '' || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }
        });

        //focus form field
        $(".price-validate-6").each(function() {

            if (this.value == '' || this.value < 1 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');
            }

        });

        //
        $(".email-validate-6").each(function() {
            var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.value != '' && validEmail.test(this.value)) {
                $(this).closest(".form-group").removeClass('has-error');
                //$(this).next(".error-content").addClass('hidden');

            } else {
                $(this).closest(".form-group").addClass('has-error');
                //$(this).next(".error-content").removeClass('hidden');
                error = "has error";
            }
        });

        //phone validate
        $(".phone-validate-6").each(function() {
            if (this.value == '' || this.value.length < 10 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //postcode validate
        $(".postcode-validate-6").each(function() {
            if (this.value == '' || this.value.length < 6 || isNaN(this.value)) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";

            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        });

        //file validate
        $(".file-validate-6").each(function() {
            if ($('.file-validate-6').get(0).files.length === 0) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                var ext = $('.file-validate-6').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['jpg', 'png', 'jpeg']) == -1) {
                    $(this).closest(".form-group").addClass('has-error');
                    error = "has error";
                } else {
                    $(this).closest(".form-group").removeClass('has-error');
                }
            }
        });

        if (error == "has error") {
            return false;
        }

    });

    $(document).on('keyup focusout', '.phone-validate-6', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 10) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup focusout', '.postcode-validate-6', function(e) {

        if (this.value == '' || isNaN(this.value) || this.value.length < 6) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";

        } else {
            $(this).closest(".form-group").removeClass('has-error');
        }
    });

    $(document).on('keyup change', '.field-validate-6', function(e) {

        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.number-validate-6', function(e) {

        if (this.value == '' || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup', '.price-validate-6', function(e) {

        if (this.value == '' || this.value < 1 || isNaN(this.value)) {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }

    });

    $(document).on('keyup focusout', '.email-validate-6', function(e) {
        var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (this.value != '' && validEmail.test(this.value)) {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        } else {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
            error = "has error";
        }
    });

    $(document).on('change', '.file-validate-6', function(e) {
        if ($('.file-validate-6').get(0).files.length === 0) {
            $(this).closest(".form-group").addClass('has-error');
            error = "has error";
        } else {
            var ext = $('.file-validate-6').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg', 'png', 'jpeg']) == -1) {
                $(this).closest(".form-group").addClass('has-error');
                error = "has error";
            } else {
                $(this).closest(".form-group").removeClass('has-error');
            }
        }
    });
    /******* field validate 6 ********/

    $(document).on('keyup change', '.vetting-field-validate', function(e) {
        if (this.value == '') {
            $(this).closest(".form-group").addClass('has-error');
            //$(this).next(".error-content").removeClass('hidden');
        } else {
            $(this).closest(".form-group").removeClass('has-error');
            //$(this).next(".error-content").addClass('hidden');
        }
    });
</script>
