<div style="width: 100%; display:block;">
    {{-- <h2>Welcome</h2> --}}
    <p>
        <strong>Hi {{ $mailData['contactDet']->firstName_txt }} {{ $mailData['contactDet']->surname_txt }}!</strong>
    </p><br>

    {!! $mailData['temp_description'] !!}
</div>

<div style="width: 100%; display:block;">
    <p>
        <strong>Sincerely,</strong><br>
        BBEDUCATION
    </p>
</div>
