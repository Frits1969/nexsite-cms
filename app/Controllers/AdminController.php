<?php

namespace Fritsion\Controllers;

use Fritsion\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/backoffice';

        // Handle sub-routes manually if needed inside index, 
        // but App.php now routes most specific /backoffice/ paths

        if (strpos($uri, '/backoffice/logout') === 0) {
            $this->logout();
            return;
        }

        // Simple authentication check
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        // Fetch stats
        $pageCount = 0;
        $latestPages = [];

        // Check if pages table exists first to avoid crashes
        $tableExists = false;
        $checkTable = $db->query("SHOW TABLES LIKE '{$prefix}pages'");
        if ($checkTable && $checkTable->num_rows > 0) {
            $tableExists = true;
        }

        if (!$tableExists) {
            // Auto-create table if missing
            $sql = "CREATE TABLE IF NOT EXISTS `{$prefix}pages` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(255) NOT NULL UNIQUE,
                `content` TEXT,
                `status` ENUM('draft', 'published', 'archived') DEFAULT 'draft',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            if ($db->query($sql)) {
                $tableExists = true;
                // Add a welcome page if it's the first time
                $db->query("INSERT INTO `{$prefix}pages` (title, slug, content, status) VALUES ('Welkom', 'welkom', 'Dit is uw eerste pagina.', 'published')");
            }
        }

        if ($tableExists) {
            // Fetch stats
            $res = $db->query("SELECT COUNT(*) as count FROM {$prefix}pages");
            if ($res) {
                $row = $res->fetch_assoc();
                $pageCount = $row['count'];
            }

            // Fetch latest pages for dashboard overview
            $res = $db->query("SELECT * FROM {$prefix}pages ORDER BY created_at DESC LIMIT 5");
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $latestPages[] = $row;
                }
            }
        }

        // Fetch site status
        $siteStatus = 'inactive';
        $res = $db->query("SELECT setting_value FROM {$prefix}settings WHERE setting_key = 'site_status'");
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $siteStatus = $row['setting_value'];
        }

        $this->view('admin/dashboard', [
            'pageCount' => $pageCount,
            'latestPages' => $latestPages,
            'siteStatus' => $siteStatus
        ]);
    }

    public function profile()
    {
        // Simple authentication check
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();
        $userId = $_SESSION['user_id'];
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // 1. Verify current password
            $stmt = $db->prepare("SELECT password_hash FROM {$prefix}users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                $error = "Huidig wachtwoord is onjuist.";
            } else {
                // 2. Perform updates
                $updates = [];
                $params = [];
                $types = "";

                if (!empty($username)) {
                    $updates[] = "username = ?";
                    $params[] = $username;
                    $types .= "s";
                }

                if (!empty($email)) {
                    $updates[] = "email = ?";
                    $params[] = $email;
                    $types .= "s";
                }

                if (!empty($newPassword)) {
                    if ($newPassword !== $confirmPassword) {
                        $error = "Nieuwe wachtwoorden komen niet overeen.";
                    } else {
                        $updates[] = "password_hash = ?";
                        $params[] = password_hash($newPassword, PASSWORD_DEFAULT);
                        $types .= "s";
                    }
                }

                if (!$error && !empty($updates)) {
                    $sql = "UPDATE {$prefix}users SET " . implode(", ", $updates) . " WHERE id = ?";
                    $params[] = $userId;
                    $types .= "i";

                    $stmt = $db->prepare($sql);
                    $stmt->bind_param($types, ...$params);

                    if ($stmt->execute()) {
                        $success = "Profiel succesvol bijgewerkt.";
                        if (!empty($username)) {
                            $_SESSION['username'] = $username;
                        }
                    } else {
                        $error = "Er is een fout opgetreden bij het bijwerken van het profiel.";
                    }
                    $stmt->close();
                } elseif (!$error) {
                    $error = "Geen wijzigingen opgegeven.";
                }
            }
        }

        // Fetch current data
        $stmt = $db->prepare("SELECT username, email FROM {$prefix}users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $userData = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $this->view('admin/profile', [
            'user' => $userData,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $db = \Fritsion\Database::connect();
            $prefix = \Fritsion\Database::getPrefix();

            $stmt = $db->prepare("SELECT id, username, password_hash FROM {$prefix}users WHERE username = ? AND status = 'active'");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /backoffice');
                exit;
            } else {
                // For now, if it's the very first login and DB is empty or something, 
                // we might want a fallback, but let's stick to real auth now.
                $error = "Ongeldige gebruikersnaam of wachtwoord.";
                $this->view('admin/login', ['error' => $error]);
                return;
            }
        }
        $this->view('admin/login');
    }


    public function settings()
    {
        // Simple authentication check
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $siteName = $_POST['site_name'] ?? '';
            $siteDesc = $_POST['site_desc'] ?? '';
            $siteDomain = $_POST['site_domain'] ?? '';
            $dbUser = $_POST['db_user'] ?? '';
            $dbPass = $_POST['db_pass'] ?? '';

            try {
                // 1. Update Database settings
                $stmt = $db->prepare("UPDATE {$prefix}settings SET setting_value = ? WHERE setting_key = ?");

                $dbSettings = [
                    'site_name' => $siteName,
                    'site_description' => $siteDesc,
                    'site_domain' => $siteDomain
                ];

                foreach ($dbSettings as $key => $value) {
                    $stmt->bind_param("ss", $value, $key);
                    $stmt->execute();
                }
                $stmt->close();

                // 2. Update .env file
                $envPath = __DIR__ . '/../../.env';
                if (file_exists($envPath)) {
                    $envContent = file_get_contents($envPath);
                    $replacements = [
                        'APP_NAME' => $siteName,
                        'APP_URL' => "http://" . $siteDomain,
                        'DB_USERNAME' => $dbUser,
                        'DB_PASSWORD' => $dbPass
                    ];

                    foreach ($replacements as $key => $value) {
                        // Match key=value (with optional quotes)
                        $pattern = "/^" . preg_quote($key) . "=(.*)$/m";
                        $replacement = $key . "=\"" . str_replace('"', '\"', $value) . "\"";

                        if (preg_match($pattern, $envContent)) {
                            $envContent = preg_replace($pattern, $replacement, $envContent);
                        } else {
                            // If not found, append it (though it should be there)
                            $envContent .= "\n" . $replacement;
                        }
                    }

                    if (file_put_contents($envPath, $envContent) === false) {
                        throw new \Exception("Kon .env bestand niet schrijven.");
                    }

                    // Reload config to reflect changes immediately in the current request if needed
                    \Fritsion\Config::load($envPath);
                }

                $success = "Instellingen succesvol bijgewerkt.";
            } catch (\Exception $e) {
                $error = "Er is een fout opgetreden: " . $e->getMessage();
            }
        }

        // Fetch DB settings from table
        $stmt = $db->prepare("SELECT setting_key, setting_value FROM {$prefix}settings");
        $stmt->execute();
        $result = $stmt->get_result();
        $settings = [];
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        $stmt->close();

        // Environment settings
        $env = [
            'app_name' => \Fritsion\Config::get('APP_NAME'),
            'app_url' => \Fritsion\Config::get('APP_URL'),
            'db_host' => \Fritsion\Config::get('DB_HOST'),
            'db_name' => \Fritsion\Config::get('DB_DATABASE'),
            'db_user' => \Fritsion\Config::get('DB_USERNAME'),
            'db_prefix' => \Fritsion\Config::get('DB_PREFIX'),
            'language' => \Fritsion\Config::get('DEFAULT_LANGUAGE', 'nl'),
            'version' => \Fritsion\App::VERSION
        ];

        $this->view('admin/settings', [
            'settings' => $settings,
            'env' => $env,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function pages()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        $result = $db->query("SELECT * FROM {$prefix}pages ORDER BY created_at DESC");
        $pages = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $pages[] = $row;
            }
        }

        $this->view('admin/pages_list', [
            'pages' => $pages
        ]);
    }

    public function addPage()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $content = $_POST['content'] ?? '';
            $status = $_POST['status'] ?? 'draft';

            if (empty($title) || empty($slug)) {
                $error = "Titel en slug zijn verplicht.";
            } else {
                $db = \Fritsion\Database::connect();
                $prefix = \Fritsion\Database::getPrefix();

                $stmt = $db->prepare("INSERT INTO {$prefix}pages (title, slug, content, status) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $title, $slug, $content, $status);

                if ($stmt->execute()) {
                    header('Location: /backoffice/pages?success=created');
                    exit;
                } else {
                    $error = "Er is een fout opgetreden: " . $db->error;
                }
                $stmt->close();
            }
        }

        $this->view('admin/pages_edit', [
            'mode' => 'add',
            'error' => $error
        ]);
    }

    public function editPage($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $content = $_POST['content'] ?? '';
            $status = $_POST['status'] ?? 'draft';

            if (empty($title) || empty($slug)) {
                $error = "Titel en slug zijn verplicht.";
            } else {
                $stmt = $db->prepare("UPDATE {$prefix}pages SET title = ?, slug = ?, content = ?, status = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $title, $slug, $content, $status, $id);

                if ($stmt->execute()) {
                    $success = "Pagina succesvol bijgewerkt.";
                } else {
                    $error = "Er is een fout opgetreden: " . $db->error;
                }
                $stmt->close();
            }
        }

        $stmt = $db->prepare("SELECT * FROM {$prefix}pages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $page = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$page) {
            header('Location: /backoffice/pages?error=not_found');
            exit;
        }

        $this->view('admin/pages_edit', [
            'mode' => 'edit',
            'page' => $page,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function deletePage($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        $stmt = $db->prepare("DELETE FROM {$prefix}pages WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: /backoffice/pages?success=deleted');
        } else {
            header('Location: /backoffice/pages?error=delete_failed');
        }
        $stmt->close();
        exit;
    }

    public function togglePageStatus($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        // Get current status
        $stmt = $db->prepare("SELECT status FROM {$prefix}pages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $page = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($page) {
            $newStatus = ($page['status'] === 'published') ? 'draft' : 'published';
            $stmt = $db->prepare("UPDATE {$prefix}pages SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $id);
            $stmt->execute();
            $stmt->close();
        }

        header('Location: /backoffice/pages');
        exit;
    }

    public function toggleSiteStatus()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        // Check current status
        $res = $db->query("SELECT setting_value FROM {$prefix}settings WHERE setting_key = 'site_status'");
        $currentStatus = 'inactive';
        $exists = false;

        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $currentStatus = $row['setting_value'];
            $exists = true;
        }

        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';

        if ($exists) {
            $stmt = $db->prepare("UPDATE {$prefix}settings SET setting_value = ? WHERE setting_key = 'site_status'");
            $stmt->bind_param("s", $newStatus);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $db->prepare("INSERT INTO {$prefix}settings (setting_key, setting_value) VALUES ('site_status', ?)");
            $stmt->bind_param("s", $newStatus);
            $stmt->execute();
            $stmt->close();
        }

        header('Location: /backoffice');
        exit;
    }

    public function layoutConfigurator()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        // Fetch current layout JSON
        $layoutJson = '';
        $res = $db->query("SELECT setting_value FROM {$prefix}settings WHERE setting_key = 'homepage_layout_json'");
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $layoutJson = $row['setting_value'];
        }

        // Default layout if empty
        if (empty($layoutJson)) {
            $defaultLayout = [
                'header' => [
                    'sections' => [
                        ['type' => 'logo'],
                        ['type' => 'menu'],
                        ['type' => 'cta']
                    ]
                ],
                'main' => [
                    'rows' => [
                        [
                            'columns' => [
                                ['type' => 'text'],
                                ['type' => 'image']
                            ]
                        ]
                    ]
                ],
                'footer' => [
                    'sections' => [
                        ['type' => 'text'],
                        ['type' => 'socials']
                    ]
                ]
            ];
            $layoutJson = json_encode($defaultLayout);
        }

        $this->view('admin/layout_configurator', [
            'layoutJson' => $layoutJson
        ]);
    }

    public function saveLayoutConfig()
    {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /backoffice/login');
            exit;
        }

        $layoutJson = $_POST['layout_json'] ?? '';

        // Basic validation
        if (!json_decode($layoutJson)) {
            header('Location: /backoffice/templates/homepage?error=invalid_json');
            exit;
        }

        $db = \Fritsion\Database::connect();
        $prefix = \Fritsion\Database::getPrefix();

        // Check if exists
        $res = $db->query("SELECT id FROM {$prefix}settings WHERE setting_key = 'homepage_layout_json'");

        if ($res && $res->num_rows > 0) {
            $stmt = $db->prepare("UPDATE {$prefix}settings SET setting_value = ? WHERE setting_key = 'homepage_layout_json'");
            $stmt->bind_param("s", $layoutJson);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $db->prepare("INSERT INTO {$prefix}settings (setting_key, setting_value) VALUES ('homepage_layout_json', ?)");
            $stmt->bind_param("s", $layoutJson);
            $stmt->execute();
            $stmt->close();
        }

        header('Location: /backoffice/templates/homepage?saved=1');
        exit;
    }

}
