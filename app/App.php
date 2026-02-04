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
        echo '
        <!DOCTYPE html>
        <html lang="nl">
        <head>
            <meta charset="UTF-8">
            <title>NexSite CMS</title>
            <style>
                body {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background: #ffffff;
                }
                img {
                    max-width: 280px;
                    margin-bottom: 20px;
                }
                .text {
                    font-size: 20px;
                    color: #333;
                }
            </style>
        </head>
        <body>
    
            <img src="/assets/logo/nexsite-logo.png" alt="NexSite Logo">
            <div class="text">NexSite Core is initialized.</div>
    
        </body>
        </html>
        ';
    }

}
