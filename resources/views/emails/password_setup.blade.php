<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Setup</title>
        <link rel="stylesheet" href="{{ asset('mailstyle.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="image">
                <img src="{{ asset('icon/CURSA.png') }}" width="150" height="150">
            </div>
            
            <p>Gentile utente,</p>
            <p>Si prega di cliccare sul seguente link per inserire una nuova password per il vostro account:</p>
            <p>
                <a href="{{ route('password.setup') }}?token={{ $token }}">Reset password</a>
            </p>
            <p>Se questa mail non è stata richiesta si prega di ignorarla.</p>
        </div>
    </body>
</html>
