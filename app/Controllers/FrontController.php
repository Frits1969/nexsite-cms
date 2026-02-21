<?php

namespace Fritsion\Controllers;

use Fritsion\Database;

class FrontController extends BaseController
{
    public function index()
    {
        // 1. Fetch site settings
        $settings = [];
        $prefix = Database::getPrefix();
        $result = Database::query("SELECT setting_key, setting_value FROM {$prefix}settings");

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }

        $siteStatus = $settings['site_status'] ?? 'inactive';

        // 2. Check if there are any published pages
        $pageResult = Database::query("SELECT COUNT(*) as count FROM {$prefix}pages WHERE status = 'published'");
        $pageCount = 0;
        if ($pageResult) {
            $row = $pageResult->fetch_assoc();
            $pageCount = $row['count'];
        }

        // 3. Logic for what to show
        if ($siteStatus === 'inactive') {
            // Site explicitly set to inactive
            $this->view('front/maintenance');
            return;
        }

        if ($pageCount === 0) {
            // Site is active but has no content yet
            $this->view('front/maintenance', ['no_content' => true]);
            return;
        }

        // Default home view (we'll expand this later to dynamic content)
        $this->view('front/home', ['settings' => $settings]);
    }

    public function demo()
    {
        // Static demo page with premium design
        $this->view('front/demo');
    }
}
