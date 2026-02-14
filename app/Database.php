<?php

namespace NexSite;

class Database
{
    private static $connection;

    public static function connect()
    {
        if (self::$connection) {
            return self::$connection;
        }

        $host = Config::get('DB_HOST', 'localhost');
        $user = Config::get('DB_USERNAME', 'root');
        $pass = Config::get('DB_PASSWORD', '');
        $name = Config::get('DB_DATABASE', 'nexsite');
        $port = Config::get('DB_PORT', 3306);

        self::$connection = new \mysqli($host, $user, $pass, $name, $port);

        if (self::$connection->connect_error) {
            die("Database connection failed: " . self::$connection->connect_error);
        }

        self::$connection->set_charset("utf8mb4");

        return self::$connection;
    }

    public static function query($sql)
    {
        return self::connect()->query($sql);
    }

    public static function escape($string)
    {
        return self::connect()->real_escape_string($string);
    }

    public static function getPrefix()
    {
        return Config::get('DB_PREFIX', 'nscms_');
    }
}
