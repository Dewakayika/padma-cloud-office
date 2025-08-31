<!DOCTYPE html>
<html>
<head>
    <title>Invitation to Join {{ $company->company_name }}</title>
</head>
<body>
    <h1>You've Been Invited!</h1>
    <p>Hello,</p>
    <p>{{ $invitingUser->name }} has invited you to join {{ $company->company_name }}.</p>

    @if($isExistingUser)
        <p>Since you already have an account, please log in and click the link below to accept the invitation:</p>
        <a href="{{ $invitationLink }}">Accept Invitation</a>
        <p>You'll be added to the company's team and can start collaborating on projects.</p>
    @else
        <p>Click the link below to accept the invitation and create your account:</p>
        <a href="{{ $invitationLink }}">Accept Invitation & Register</a>
        <p>This will create your account and add you to the company's team.</p>
    @endif

    <p>This invitation link will expire soon.</p>
    <p>Thanks,<br>{{ $company->company_name }}</p>
</body>
</html>
