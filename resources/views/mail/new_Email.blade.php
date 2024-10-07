<!DOCTYPE html>
<html>
<head>
    <title>Novo E-mail</title>
</head>
<body>
    <h1>Olá, {{ $name }}</h1>
    <p>{{ $messageContent }}</p>

    <p>Atenciosamente,</p>
    <p>Equipe {{ config('app.name') }}</p>
</body>
</html>
