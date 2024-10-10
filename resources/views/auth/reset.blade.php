<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .password-container {
            position: relative;
            margin-bottom: 20px;
        }

        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-20%) translateY(1px);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 18px;
        }

        button {
            background-color: #5c67f2;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4a54e1;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Redefinir Senha</h1>

        <!-- Mensagem de erro ou sucesso -->
        @if (isset($errors) && $errors->any())
            <div>
                @if ($errors->any())
                    <div class="error">
                        <strong>{{ $errors->first() }}</strong>
                    </div>
                @endif
            </div>
        @endif

        @if (session('status'))
            <div class="success">
                <strong>{{ session('status') }}</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="password-container">
                <label for="password">Nova Senha:</label>
                <input id="password" type="password" name="password" required>
                <button type="button" class="toggle-password" onclick="togglePassword('password')">👁️</button>
            </div>
            <div class="password-container">
                <label for="password_confirmation">Confirme a Senha:</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">👁️</button>
            </div>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>

    <script>
        function togglePassword(inputId) {
            const inputField = document.getElementById(inputId);
            const inputType = inputField.getAttribute('type');

            if (inputType === 'password') {
                inputField.setAttribute('type', 'text');
            } else {
                inputField.setAttribute('type', 'password');
            }
        }
    </script>
</body>

</html>
