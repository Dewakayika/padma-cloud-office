<!DOCTYPE html>
<html>
<head>
    <title>Invitation to Join {{ $company->company_name }}</title>
</head>
<body>
    <h1>You've Been Invited!</h1>
    <p>Hello,</p>
    <p>{{ $invitingUser->name }} has invited you to join {{ $company->company_name }}.</p>
    <p>Click the link below to accept the invitation and register:</p>
    <a href="{{ $invitationLink }}">Accept Invitation</a>
    <p>This invitation link will expire soon.</p>
    <p>Thanks,<br>{{ $company->company_name }}</p>
</body>
</html>
