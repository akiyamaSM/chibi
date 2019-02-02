<?php


namespace Chibi\Model;

use PDO;

class Connexion
{
    static $connexion;

    /**
     *  Connect to the database
     */
    public static function connect()
    {
            $db = app('config')['config']['database'];
            $dsn = "mysql:dbname={$db['db_name']};host={$db['host']}";
            $dbh = new PDO($dsn, $db['username'], $db['password']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            static::$connexion = $dbh;
    }
}