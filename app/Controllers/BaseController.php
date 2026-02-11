<?php

namespace NexSite\Controllers;

class BaseController
{
    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View file not found: $viewFile");
        }
    }
}
