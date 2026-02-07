<?php

namespace NexSite;

require_once __DIR__ . '/Language.php';

class App
{
    const VERSION = '0.0.2';
    protected static $instance;

    public function __construct()
    {
        // Constructor logic
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function run()
    {
        session_start();

        // taal bepalen
        if (isset($_GET['lang'])) {
            $_SESSION['lang'] = $_GET['lang'];
        }

        $selected = $_SESSION['lang'] ?? 'nl';

        // taalbestand laden
        $lang = Language::load($selected);

        // DB Test Action
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'test_db') {
            header('Content-Type: application/json');

            $host = $_POST['host'] ?? 'localhost';
            $user = $_POST['user'] ?? '';
            $pass = $_POST['pass'] ?? '';
            $name = $_POST['name'] ?? '';

            try {
                // Suppress warnings for connection errors
                $conn = @new \mysqli($host, $user, $pass, $name);

                if ($conn->connect_error) {
                    throw new \Exception($conn->connect_error);
                }

                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }

        // view tonen
        $version = self::VERSION;
        include __DIR__ . '/Views/splash.php';
    }

}
