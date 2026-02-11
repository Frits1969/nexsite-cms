<?php

namespace NexSite;

require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Installer.php';

require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Controllers/BaseController.php';
require_once __DIR__ . '/Controllers/FrontController.php';
require_once __DIR__ . '/Controllers/AdminController.php';

use NexSite\Language;
use NexSite\Config;
use NexSite\Controllers\FrontController;
use NexSite\Controllers\AdminController;

class App
{
    const VERSION = '0.0.4';
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

        // Check if already installed
        if (file_exists(__DIR__ . '/../install.lock')) {
            // Load Configuration
            Config::load(__DIR__ . '/../.env');

            $uri = $_SERVER['REQUEST_URI'] ?? '/';
            $uri = strtok($uri, '?');

            // Simple Routing
            if (strpos($uri, '/admin') === 0) {
                $controller = new AdminController();
                if ($uri === '/admin/login') {
                    $controller->login();
                } else {
                    $controller->index();
                }
            } else {
                $controller = new FrontController();
                $controller->index();
            }
            return;
        }

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

        // Install Action
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'install') {
            header('Content-Type: application/json');

            try {
                // Validate required fields
                $required = ['site_name', 'site_desc', 'domain', 'username', 'email', 'password', 'db_host', 'db_name', 'db_user', 'db_pass'];
                foreach ($required as $field) {
                    if (empty($_POST[$field])) {
                        throw new \Exception("Missing required field: $field");
                    }
                }

                // Create installer instance
                $installer = new Installer(
                    $_POST['db_host'],
                    $_POST['db_user'],
                    $_POST['db_pass'],
                    $_POST['db_name']
                );

                // Run installation
                if ($installer->run($_POST)) {
                    echo json_encode(['success' => true, 'message' => $lang['install_success']]);
                } else {
                    $errors = implode(', ', $installer->getErrors());
                    throw new \Exception($errors);
                }
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
