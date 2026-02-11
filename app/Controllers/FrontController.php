<?php

namespace NexSite\Controllers;

use NexSite\Database;

class FrontController extends BaseController
{
    public function index()
    {
        // Fetch site settings
        $settings = [];
        $result = Database::query("SELECT setting_key, setting_value FROM NSCMS_settings");

        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $this->view('front/home', ['settings' => $settings]);
    }
}
