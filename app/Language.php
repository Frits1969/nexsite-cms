<?php

namespace Fritsion;

class Language
{
    public static function load($lang = 'nl')
    {
        $file = __DIR__ . '/../lang/' . $lang . '.php';

        if (file_exists($file)) {
            return include $file;
        }

        // fallback
        return include __DIR__ . '/../lang/nl.php';
    }
}
