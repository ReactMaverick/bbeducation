<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
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

        .date-left-teacher-calendar {
            width: 13%
        }

        .teacher-timesheet-btn-outer {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
        }

        .teacher-timesheet-btn-outer .approve-btn {
            background-color: #70AD47;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 5px 15px;
            margin-left: 15px;
        }

        .teacher-timesheet-btn-outer .reject-btn {
            background-color: #ee0000;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 5px 15px;
            margin-left: 15px;
        }
    </style>
</head>

<body>

</body>

<script src="{!! asset('plugins/sweetalert/sweetalert.min.js') !!}"></script>
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

<?php if(app('request')->input('status') == 'approve'){?>
<script>
    var asnId = "{{ $asnId }}";
    var school_id = "{{ $school_id }}";
    if (asnId) {
        $.ajax({
            type: 'POST',
            url: '{{ url('/school/logSchoolTimesheetLogDir') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                approveAsnId: asnId,
                school_id: school_id,
                weekStartDate: "{{ $weekStartDate }}",
                weekEndDate: "{{ $plusFiveDate }}"
            },
            success: function(data) {
                if (data.add == 'Yes') {
                    var popTxt =
                        'You have just logged a timesheet for ' + data
                        .schoolName +
                        '. Timesheet ID : ' + data.timesheet_id;
                    swal("", popTxt);
                } else {
                    swal("", "Action has been already taken.");
                }
            }
        });
    }
</script>
<?php } ?>

<?php if(app('request')->input('status') == 'reject'){?>
<script>
    var asnId = "{{ $asnId }}";
    var school_id = "{{ $school_id }}";
    $.ajax({
        type: 'POST',
        url: '{{ url('/school/logSchoolTimesheetRejectDir') }}',
        data: {
            "_token": "{{ csrf_token() }}",
            asnId: asnId,
            school_id: school_id,
            weekStartDate: "{{ $weekStartDate }}",
            weekEndDate: "{{ $plusFiveDate }}"
        },
        success: function(data) {
            if (data.add == 'Yes') {
                swal("", "Timesheet rejected successfully");
            } else {
                swal("", "Action has been already taken.");
            }

        }
    });
</script>
<?php } ?>

</html>
