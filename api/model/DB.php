<?php

namespace api\model;

use PDO;

/**
 * Class DB
 * для простоты - обертка над PDO, синглтон 
 */
class DB
{
    /** @var PDO */
    private static $pdo;

    private function __construct() {}

    /**
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        // create new PDO, if not exist
        if(!isset(self::$pdo)){
            $dbParams = require (__DIR__ . '/../config/db.php');
            $dsn = $dbParams['sqlType'].':host='.$dbParams['host'].';dbname='.$dbParams['dbname'].';charset='.$dbParams['charset'];
            $pdo_params = array (
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => TRUE
            );
            self::$pdo = new PDO("$dsn", $dbParams['username'], $dbParams['password'], $pdo_params);
            self::$pdo->query('SET NAMES '.$dbParams['charset']);
        }

        return self::$pdo;
    }
}