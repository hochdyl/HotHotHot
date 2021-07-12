<?php

namespace App\Core\Database;

use PDO;
use PDOException;

final class Database extends PDO {

    private static ?self $pdo = null;

    private function __construct() {
        try {
            parent::__construct('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, [
                self::ATTR_ERRMODE => self::ERRMODE_EXCEPTION,
                self::ATTR_DEFAULT_FETCH_MODE => self::FETCH_ASSOC,
                self::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getPDO(): self {
        return self::$pdo ?? new self();
    }

}
