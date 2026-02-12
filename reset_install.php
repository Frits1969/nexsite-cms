<?php
// reset_install.php
// Dit script reset de CMS installatie zodat je opnieuw kunt beginnen.
// Gebruik: Open dit bestand in je browser (http://localhost/reset_install.php) of voer het uit via de command line (php reset_install.php).

// Helper functie om berichten weer te geven
function logMsg($msg)
{
    echo $msg . "<br>\n";
}

logMsg("Start reset installatie...");

// Stap 1: install.lock verwijderen
// install.lock voorkomt dat de installer opnieuw loopt. We moeten dit verwijderen.
$lockFile = __DIR__ . '/install.lock';
if (file_exists($lockFile)) {
    if (unlink($lockFile)) {
        logMsg("✅ install.lock succesvol verwijderd.");
    } else {
        logMsg("❌ Kon install.lock niet verwijderen. Controleer de rechten.");
    }
} else {
    logMsg("ℹ️ install.lock bestond niet.");
}

// Stap 2: Database leegmaken
// We moeten de database credentials uit .env halen om verbinding te maken.
$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    // Lees .env regel voor regel
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue; // Sla commentaar over
        list($name, $value) = explode('=', $line, 2);
        $env[trim($name)] = trim($value);
    }

    // Haal DB gevevens op
    $dbHost = $env['DB_HOST'] ?? '127.0.0.1';
    $dbName = $env['DB_DATABASE'] ?? '';
    $dbUser = $env['DB_USERNAME'] ?? 'root';
    $dbPass = $env['DB_PASSWORD'] ?? '';

    if (!empty($dbName)) {
        try {
            // Maak verbinding met de database
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            logMsg("Verbonden met database '$dbName'. Tabellen verwijderen...");

            // Haal alle tabellen op die beginnen met NSCMS_ of gewoon alles (voor de zekerheid alleen NSCMS_ prefixes als dat de standaard is, maar de user zei 'Leeg je database')
            // De user noemde specifiek 'NSCMS_settings, NSCMS_users, etc.', dus we zoeken naar tabellen met die prefix of we droppen alles.
            // Voor veiligheid doen we vaak alleen specifieke tabellen, maar 'reset' impliceert alles van deze app.

            // Laten we alle tabellen in deze specifieke database droppen om 'Leeg je database' te honoreren.
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if ($tables) {
                // Zet foreign key checks uit om errors te voorkomen bij droppen
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

                foreach ($tables as $table) {
                    $pdo->exec("DROP TABLE IF EXISTS `$table`");
                    logMsg("🗑️ Tabel '$table' verwijderd.");
                }

                $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
                logMsg("✅ Database volledig leeggemaakt.");
            } else {
                logMsg("ℹ️ Geen tabellen gevonden in de database.");
            }

        } catch (PDOException $e) {
            logMsg("❌ Kon niet verbinden met database of tabellen verwijderen: " . $e->getMessage());
            logMsg("⚠️ Zorg dat je de database handmatig leegmaakt als dit script faalt.");
        }
    } else {
        logMsg("⚠️ Geen DB_DATABASE gevonden in .env, kan database niet automatisch legen.");
    }
} else {
    logMsg("ℹ️ .env bestand niet gevonden. Database stap overgeslagen (hopelijk is die al leeg).");
}

// Stap 3: .env bestand verwijderen
// Dit bestand bevat de configuratie. Door dit te verwijderen, denkt de CMS dat het nog niet geïnstalleerd is.
if (file_exists($envFile)) {
    if (unlink($envFile)) {
        logMsg("✅ .env bestand succesvol verwijderd.");
    } else {
        logMsg("❌ Kon .env niet verwijderen. Verwijder dit bestand handmatig.");
    }
} else {
    logMsg("ℹ️ .env bestand bestond al niet meer.");
}

logMsg("<hr><strong>Reset voltooid!</strong><br>Je wordt binnen 3 seconden doorgestuurd naar de installatie...");
logMsg("<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>");
logMsg("<noscript><meta http-equiv='refresh' content='3;url=index.php'></noscript>");
?>