<?php


namespace Kolores\Model;

use PDO;

class Connexion
{
    static $connexion;

    public static function connect()
    {
            $db = app('config')['config']['database'];
            $dsn = "mysql:dbname={$db['db_name']};host={$db['host']}";
            $dbh = new PDO($dsn, $db['username'], $db['password']);
            static::$connexion = $dbh;
    }
}