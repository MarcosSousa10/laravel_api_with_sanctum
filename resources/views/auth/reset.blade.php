<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
        <label for="email">E-mail:</label>
        <input id="email" type="email" name="email" required>
    </div>
    <div>
        <label for="password">Nova Senha:</label>
        <input id="password" type="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirme a Senha:</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Redefinir Senha</button>
</form>
