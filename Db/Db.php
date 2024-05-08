<?php

namespace Db;

use PDO;

class Db
{
    private static $dbInstance = null;

    // приватный конструктор, запрещаем создавать объект
    private function __construct(){

    }

    // приватный маг метод клон, запрещаем копировать объект
    private function __clone(){

    }

    public static function conn() {

        if ( self::$dbInstance == null  ) {

            // подключение
            try {
                self::$dbInstance = new PDO("mysql:host=mysql;dbname=td_complect", "root", "root");
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return self::$dbInstance;
    }
}