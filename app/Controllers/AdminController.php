<?php

namespace NexSite\Controllers;

use NexSite\Controllers\BaseController;

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

        $db = \NexSite\Database::connect();
        $prefix = \NexSite\Database::getPrefix();
        
        // Fetch stats
        $pageCount = 0;
        $res = $db->query("SELECT COUNT(*) as count FROM {$prefix}pages");
        if ($res) {
            $row = $res->fetch_assoc();
            $pageCount = $row['count'];
        }

        // Fetch latest pages for dashboard overview
        $latestPages = [];
        $res = $db->query("SELECT * FROM {$prefix}pages ORDER BY created_at DESC LIMIT 5");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $latestPages[] = $row;
            }
        }

        $this->view('admin/dashboard', [
            'pageCount' => $pageCount,
            'latestPages' => $latestPages
        ]);
    }

    public function profile()
    {
        // Simple authentication check
        if (!isset($_SESSION['user_id'])) {
            header('Location: /backoffice/login');
            exit;
        }

        $db = \NexSite\Database::connect();
        $prefix = \NexSite\Database::getPrefix();
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

            $db = \NexSite\Database::connect();
            $prefix = \NexSite\Database::getPrefix();
            
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

        $db = \NexSite\Database::connect();
        $prefix = \NexSite\Database::getPrefix();
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
                    \NexSite\Config::load($envPath);
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
            'app_name' => \NexSite\Config::get('APP_NAME'),
            'app_url' => \NexSite\Config::get('APP_URL'),
            'db_host' => \NexSite\Config::get('DB_HOST'),
            'db_name' => \NexSite\Config::get('DB_DATABASE'),
            'db_user' => \NexSite\Config::get('DB_USERNAME'),
            'db_prefix' => \NexSite\Config::get('DB_PREFIX'),
            'language' => \NexSite\Config::get('DEFAULT_LANGUAGE', 'nl'),
            'version' => \NexSite\App::VERSION
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

        $db = \NexSite\Database::connect();
        $prefix = \NexSite\Database::getPrefix();

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
                $db = \NexSite\Database::connect();
                $prefix = \NexSite\Database::getPrefix();
                
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

        $db = \NexSite\Database::connect();
        $prefix = \NexSite\Database::getPrefix();
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

        $db = \NexSite\Database::connect();
        $prefix = \NexSite\Database::getPrefix();
        
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

}
