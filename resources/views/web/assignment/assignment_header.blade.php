<div class="topbar-Section">
    <i class="fa-solid fa-crown"></i>
    <a style="cursor: pointer;" onclick="assignmentDeleteHeader('{{ $asn_id }}')"> <i
            class="fa-solid fa-trash trash-icon"></i></a>
</div>

<script>
    function assignmentDeleteHeader(asn_id) {
        $.ajax({
            type: 'POST',
            url: '{{ url('checkAsssignmentUsed') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                asn_id: asn_id
            },
            dataType: "json",
            success: function(data) {
                if (data.exist == 'Yes') {
                    swal("",
                        "You cannot delete this assignment because timesheet(s) or contact logs exist for it.",
                        "warning"
                    );
                } else {
                    assignmentDeleteAjax(asn_id)
                }
            }
        });
    }

    function assignmentDeleteAjax(asn_id) {
        swal({
                title: "",
                text: "You wish to delete this assignment?",
                buttons: {
                    Yes: "Yes",
                    cancel: "No"
                },
            })
            .then((value) => {
                switch (value) {
                    case "Yes":
                        $('#fullLoader').show();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('delete_assignment') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                asn_id: asn_id
                            },
                            dataType: "json",
                            success: function(data) {
                                window.location.href = "{{ URL::to('/assignments') }}" + '?include=';
                            }
                        });
                }
            });
    }
</script>
