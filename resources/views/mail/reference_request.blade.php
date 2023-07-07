<div style="width: 100%; display:block;">
    <h2>{{ $mailData['subject'] }}</h2>
    <p>
        <strong>Dear!</strong><br>
    <p>The above-named candidate ({{ $mailData['teacherName'] }}) is being considered for registration with BumbleBee
        Education Ltd and has indicated
        that you would be willing to provide a reference.</p>

    <p>You can complete the reference easily online at the following location: <a href="{{ $mailData['refUrl'] }}"
            target="_blank">Online Reference Form</a></p>

    <p>At BumbleBee Education, we strive only to employ staff of the highest calibre and who will have a positive impact
        on the schools in which we place them. If an applicant is deemed unsuitable, by not meeting certain criteria, we
        will not continue the registration process. Any information you can give will be treated in the strictest
        confidence.</p>

    <p>May I take this opportunity to thank you in advance for any help you are able to give. Your prompt reply would be
        much appreciated.</p>

    <strong>Sincerely,</strong><br>
    BBEDUCATION
    </p>
</div>
