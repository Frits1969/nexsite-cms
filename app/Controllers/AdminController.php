<?php

namespace NexSite\Controllers;

use NexSite\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        // Simple authentication check for now
        if (!isset($_SESSION['user_id'])) {
            $this->login();
            return;
        }

        $this->view('admin/dashboard');
    }

    public function login()
    {
        $this->view('admin/login');
    }
}
