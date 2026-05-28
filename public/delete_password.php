<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();
}

require_once '../app/classes/PasswordEntry.php';

if (isset($_GET['id'])) {

    $entryId = (int) $_GET['id'];

    $passwordEntry = new PasswordEntry();

    $passwordEntry->deletePassword(
        $entryId,
        $_SESSION['user_id']
    );
}

header("Location: view_passwords.php");

exit();