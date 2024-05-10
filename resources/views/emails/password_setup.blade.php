<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Setup</title>
</head>
<body>
    <p>Hello,</p>
    <p>Please click the following link to set up your password:</p>
    <a href="{{ route('password.setup') }}?token={{ $token }}">Set Up Password</a>
    <p>If you didn't request this, you can ignore this email.</p>
</body>
</html>
