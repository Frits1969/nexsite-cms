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

        $this->view('admin/dashboard');
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


    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

}
