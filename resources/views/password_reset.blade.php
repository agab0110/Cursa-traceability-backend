<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset password</title>
        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>

    <body>
        <div class="container">
            <div class="image">
                <img src="{{ asset('icon/CURSA.png') }}" width="200" height="200">
            </div>

            <form method="POST" action="{{ route('passoword.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="password">Nuova password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Conferma password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn">Seleziona password</button>
            </form>
        </div>
    </body>
</html>

