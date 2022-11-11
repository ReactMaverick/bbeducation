<script src="{!! asset('plugins/select2/select2.full.min.js') !!}"></script>

<script>
    $(document).ready(function() {
        $(".select2").select2();
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

        if (error == "has error") {
            return false;
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

        if (error == "has error") {
            return false;
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

        if (error == "has error") {
            return false;
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
    /******* field validate 3 ********/
</script>
