<?php

class Database {

    protected $connect;

    public function __construct() {

        $host = "localhost";
        $dbname = "physiotherapy_db";
        $username = "root";
        $password = "";

        $this->connect = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $username,
            $password
        );

        $this->connect->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }
}