<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('web.common.meta')

<body>
    <div class="container">
        <div>
            <button onclick="window.print();">Print</button>

            <a href="mailto:kumarbarun137@gmail.com?subject='test mail'&body='test mail body'">Send Email with
                Attachment</a>
        </div>
        <div class="assignment-detail-page-section" style="width: 35%" id="abcd">
            <div class="row assignment-detail-row">
                <div class="col-md-12 topbar-sec">

                    <div class="about-school-section mt-5">
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>School</h2>
                            </div>
                            <div class="school-name-text">
                                <p>{{ $schoolDet->name_txt }}</p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Teacher</h2>
                            </div>
                            <div class="school-name-text">
                                <p>
                                    @if ($teacherDet->knownAs_txt == null && $teacherDet->knownAs_txt == '')
                                        {{ $teacherDet->firstName_txt . ' ' . $teacherDet->surname_txt }}
                                    @else
                                        {{ $teacherDet->knownAs_txt . ' ' . $teacherDet->surname_txt }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="school-name-section">
                            <div class="school-heading-text">
                                <h2>Date</h2>
                            </div>
                            <div class="school-name-text">
                                <p>{{ date('d/m/Y', strtotime($weekStartDate)) . ' - ' . date('d/m/Y', strtotime($weekEndDate)) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="details-table mt-5">
                        <div class="contact-heading">
                            <div class="contact-heading-text">
                                <h2>Teacher Timesheet</h2>
                            </div>
                        </div>

                        <table class="table school-detail-page-table" id="">
                            <thead>
                                <tr class="school-detail-table-heading">
                                    <th>Date</th>
                                    <th>Part</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-sec">
                                @foreach ($teacherList as $key2 => $teacher)
                                    <tr class="school-detail-table-data editContactItemRow">
                                        <td>{{ $teacher->asnDate_dte }}</td>
                                        <td>{{ $teacher->datePart_txt }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('web.common.scripts')
</body>

</html>
