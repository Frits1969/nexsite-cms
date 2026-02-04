<?php

namespace NexSite;

class App
{
    protected static $instance;

    public function __construct()
    {
        // Constructor logic
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function run()
    {
        // taal bepalen
        $selected = $_GET['lang'] ?? 'nl';
    
        // taalbestand laden
        $lang = \NexSite\Language::load($selected);
    
        // view tonen
        include __DIR__ . '/Views/splash.php';
    }


}
