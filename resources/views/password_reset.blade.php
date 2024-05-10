<form method="POST" action="{{ route('passoword.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>
    <button type="submit">Set Password</button>
</form>
