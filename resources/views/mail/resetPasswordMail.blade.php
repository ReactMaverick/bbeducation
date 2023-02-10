<div style="width: 100%; display:block;">
    <h2>Welcome</h2>
    <p>
        <strong>Hi {{ $mailData['firstName_txt'] }} {{ $mailData['surname_txt'] }}!</strong><br>
        Your login user name is '{{ $mailData['mail'] }}'.<br>
        Please click the bellow link to reset your login password.<br>
        {{ $mailData['rUrl'] }}<br><br>
        <strong>Sincerely,</strong><br>
        BBEDUCATION
    </p>
</div>
