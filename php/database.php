<?php
require_once 'config.php';

class Database {
    public static function conectar() {
        try {
            $conn = new PDO(
                "mysql:host=" . HOST . ";dbname=" . DB,
                USER,
                PASS,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
            );
            return $conn;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
