<div class="topbar-Section skd_new_topbar">
    <span class="crown_icon">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512"
            height="512" x="0" y="0" viewBox="0 0 6.827 6.827" style="enable-background:new 0 0 512 512"
            xml:space="preserve" fill-rule="evenodd" class="">
            <g>
                <path
                    d="M1.341 4.39.855 2.383a.053.053 0 0 1 .02-.056.054.054 0 0 1 .059-.003l1.167.68a.053.053 0 0 1 .036.091.417.417 0 1 0 .52-.048.054.054 0 0 1-.016-.071l.5-.827a.053.053 0 0 1 .073-.018.382.382 0 0 0 .399 0 .053.053 0 0 1 .073.018l.5.827a.053.053 0 0 1-.016.071.417.417 0 1 0 .52.048.053.053 0 0 1-.013-.058.053.053 0 0 1 .049-.034l1.167-.679a.054.054 0 0 1 .059.003.054.054 0 0 1 .02.056L5.485 4.39H4.098l-.562-.67a.16.16 0 0 0-.07-.048v-.265a.053.053 0 0 0-.053-.054.053.053 0 0 0-.053.054v.266a.16.16 0 0 0-.07.047l-.561.67H1.34zm3.806-.118a.053.053 0 0 1-.04-.065l.3-1.233a.053.053 0 1 1 .105.025l-.3 1.233c-.007.028-.037.048-.065.04zm-3.532-.04L1.315 3a.053.053 0 1 1 .104-.025l.3 1.234a.053.053 0 1 1-.104.025z"
                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
                <path
                    d="m1.453 4.85-.068-.288a.054.054 0 0 1 .01-.045.054.054 0 0 1 .042-.02h1.342l.594-.708a.054.054 0 0 1 .082 0l.594.708h1.34a.053.053 0 0 1 .053.065l-.069.288h-3.92zM5.257 5.507H1.57a.275.275 0 1 1 0-.55h3.687a.275.275 0 1 1 0 .55zM3.413 2.293a.484.484 0 0 1-.486-.486.484.484 0 0 1 .486-.487.484.484 0 0 1 .487.487.484.484 0 0 1-.487.486z"
                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
            </g>
        </svg>
    </span>
    <a class="crown_icon delete_icon" style="cursor: pointer;" onclick="assignmentDeleteHeader('{{ $asn_id }}')">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512"
            height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
            xml:space="preserve" class="">
            <g>
                <path fill="#fc0005" fill-rule="evenodd"
                    d="M170.8 14.221A14.21 14.21 0 0 1 185 .014L326.991.006a14.233 14.233 0 0 1 14.2 14.223v35.117H170.8zm233.461 477.443a21.75 21.75 0 0 1-21.856 20.33H127.954a21.968 21.968 0 0 1-21.854-20.416L84.326 173.06H427.5l-23.234 318.6zm56.568-347.452H51.171v-33A33.035 33.035 0 0 1 84.176 78.2l343.644-.011a33.051 33.051 0 0 1 33 33.02v33zm-270.79 291.851a14.422 14.422 0 1 0 28.844 0V233.816a14.42 14.42 0 0 0-28.839-.01v202.257zm102.9 0a14.424 14.424 0 1 0 28.848 0V233.816a14.422 14.422 0 0 0-28.843-.01z"
                    opacity="1" data-original="#fc0005"></path>
            </g>
        </svg>
    </a>
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
                text: "Are you sure you want to completely delete this assignment?",
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
