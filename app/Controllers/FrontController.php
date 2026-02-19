<?php

namespace Fritsion\Controllers;

use Fritsion\Database;

class FrontController extends BaseController
{
    public function index()
    {
        // Fetch site settings
        $settings = [];
        $prefix = Database::getPrefix();
        $result = Database::query("SELECT setting_key, setting_value FROM {$prefix}settings");

        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $this->view('front/home', ['settings' => $settings]);
    }

    public function demo()
    {
        // Static demo page with premium design
        $this->view('front/demo');
    }
}
