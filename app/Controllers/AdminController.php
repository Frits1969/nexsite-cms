<?php

namespace NexSite\Controllers;

use NexSite\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/backoffice';
        
        // Handle logout sub-route
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

    public function login()
    {
        // For now, allow simple bypass if it's a GET request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Very basic hardcoded login for demonstration
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = $_POST['username'] ?? 'Admin';
            header('Location: /backoffice');
            exit;
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
