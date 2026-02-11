<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexSite Temp Admin</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f2f5;
        }

        .login-box {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Admin Inloggen</h2>
        <form method="post" action="/admin/login">
            <input type="text" name="username" placeholder="Gebruikersnaam / Email" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <button type="submit">Inloggen</button>
        </form>
        <p><small><a href="/">Terug naar website</a></small></p>
    </div>
</body>

</html>