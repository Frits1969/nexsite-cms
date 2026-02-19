<?php

namespace Fritsion\Controllers;

class BaseController
{
    protected function view($view, $data = [])
    {
        $lang = $GLOBALS['lang'] ?? [];
        extract($lang); // Extract lang keys directly
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View file not found: $viewFile");
        }
    }
}
