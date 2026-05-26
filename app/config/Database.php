<?php

class Database
{
    private $host = "mysql";
    private $db_name = "password_manager";
    private $username = "appuser";
    private $password = "secret";

    private $connection;

    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $exception) {

            die("Database connection failed: " . $exception->getMessage());
        }

        return $this->connection;
    }
}