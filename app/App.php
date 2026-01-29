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
        // Basis logica om de app te starten
        echo "NexSite Core is initialized.";
    }
}
