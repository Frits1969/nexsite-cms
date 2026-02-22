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

        // Fetch dynamic layout JSON from templates table
        $layoutJson = '';
        $tplRes = Database::query("SELECT layout_json FROM {$prefix}templates WHERE type = 'homepage' AND is_active = 1 LIMIT 1");
        if ($tplRes && $tplRes->num_rows > 0) {
            $row = $tplRes->fetch_assoc();
            $layoutJson = $row['layout_json'];
        }

        if (empty($layoutJson)) {
            $layoutJson = $settings['homepage_layout_json'] ?? '';
        }

        $homepageLayout = !empty($layoutJson) ? json_decode($layoutJson, true) : null;

        $this->view('front/home', [
            'settings' => $settings,
            'homepageLayout' => $homepageLayout
        ]);
    }

    public function demo()
    {
        // Static demo page with premium design
        $this->view('front/demo');
    }
}
