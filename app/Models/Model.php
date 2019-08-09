<?php


namespace App\Models;

use \RedBeanPHP\R as R;

class Model
{
    public static $db;

    public static function bean()
    {
        require ROOT . '/config/config_db.php';
        return self::$db = R::setup("$driver:host=$host;dbname=$database_name", $username, $password);
    }

    public function getAll($table)
    {
        return R::getAll("SELECT * FROM $table");
    }

    public function load($table, $key_search)
    {
        return R::load($table, $key_search);
    }

}