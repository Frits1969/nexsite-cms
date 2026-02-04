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
		session_start();

		// taal bepalen
		if (isset($_GET['lang'])) {
			$_SESSION['lang'] = $_GET['lang'];
		}

		$selected = $_SESSION['lang'] ?? 'nl';

		// taalbestand laden
		$lang = \NexSite\Language::load($selected);

		// view tonen
		include __DIR__ . '/Views/splash.php';
	}

}
