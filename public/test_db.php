<?php

require_once '../app/config/Database.php';

$database = new Database();

$connection = $database->connect();

if ($connection) {
    echo "Database Connected Successfully";
}