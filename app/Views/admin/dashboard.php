<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NexSite CMS</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            display: flex;
        }

        aside {
            width: 250px;
            background: #333;
            color: white;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <aside>
        <h2>NexSite Admin</h2>
        <nav>
            <a href="/admin">Dashboard</a>
            <a href="/" target="_blank">Bekijk Website</a>
            <a href="/admin/logout">Uitloggen</a>
        </nav>
    </aside>
    <main>
        <h1>Dashboard</h1>
        <p>Welkom in de backoffice!</p>
        <p>Hier komen straks functies om pagina's en instellingen te beheren.</p>
    </main>
</body>

</html>