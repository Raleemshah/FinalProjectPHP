<?php

require_once __DIR__ . '/../config/Database.php';

class User
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Random Master Key
    |--------------------------------------------------------------------------
    */

    private function generateMasterKey()
    {
        return bin2hex(random_bytes(32));
    }

    /*
    |--------------------------------------------------------------------------
    | Encrypt Master Key Using User Password
    |--------------------------------------------------------------------------
    */

    private function encryptMasterKey($masterKey, $password)
    {
        $method = "AES-256-CBC";

        $key = hash('sha256', $password, true);

        $iv = random_bytes(16);

        $encrypted = openssl_encrypt(
            $masterKey,
            $method,
            $key,
            0,
            $iv
        );

        return base64_encode($iv . $encrypted);
    }

    /*
    |--------------------------------------------------------------------------
    | Register User
    |--------------------------------------------------------------------------
    */

    public function register($username, $password)
    {
        // Check if username already exists
        $checkQuery = "SELECT id FROM users WHERE username = :username";

        $checkStatement = $this->connection->prepare($checkQuery);

        $checkStatement->bindParam(':username', $username);

        $checkStatement->execute();

        if ($checkStatement->rowCount() > 0) {
            return "Username already exists";
        }

        // Hash login password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Generate permanent master key
        $masterKey = $this->generateMasterKey();

        // Encrypt master key using user password
        $encryptedMasterKey = $this->encryptMasterKey(
            $masterKey,
            $password
        );

        // Insert user
        $query = "
            INSERT INTO users
            (
                username,
                password_hash,
                encrypted_master_key
            )
            VALUES
            (
                :username,
                :password_hash,
                :encrypted_master_key
            )
        ";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(':username', $username);

        $statement->bindParam(':password_hash', $passwordHash);

        $statement->bindParam(
            ':encrypted_master_key',
            $encryptedMasterKey
        );

        if ($statement->execute()) {
            return "Registration successful";
        }

        return "Registration failed";
    }
        /*
    |--------------------------------------------------------------------------
    | Login User
    |--------------------------------------------------------------------------
    */

    public function login($username, $password)
    {
        $query = "
            SELECT *
            FROM users
            WHERE username = :username
        ";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(':username', $username);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "User not found";
        }

        if (
            password_verify(
                $password,
                $user['password_hash']
            )
        ) {

         

         $_SESSION['user_id'] = $user['id'];

         $_SESSION['username'] = $user['username'];

         $_SESSION['plain_password'] = $password;

            return "Login successful";
        }

        return "Invalid password";
    }
        /*
    |--------------------------------------------------------------------------
    | Change User Password
    |--------------------------------------------------------------------------
    */

    public function changePassword(
        $userId,
        $currentPassword,
        $newPassword
    ) {

        // Get current user
        $query = "
            SELECT *
            FROM users
            WHERE id = :id
        ";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(':id', $userId);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "User not found";
        }

        // Verify current password
        if (
            !password_verify(
                $currentPassword,
                $user['password_hash']
            )
        ) {

            return "Current password is incorrect";
        }

        // Decrypt existing master key
        $method = "AES-256-CBC";

        $oldKey = hash(
            'sha256',
            $currentPassword,
            true
        );

        $data = base64_decode(
            $user['encrypted_master_key']
        );

        $iv = substr($data, 0, 16);

        $encrypted = substr($data, 16);

        $masterKey = openssl_decrypt(
            $encrypted,
            $method,
            $oldKey,
            0,
            $iv
        );

        // Re-encrypt SAME master key
        // using NEW password
        $newKey = hash(
            'sha256',
            $newPassword,
            true
        );

        $newIv = random_bytes(16);

        $newEncryptedMasterKey = openssl_encrypt(
            $masterKey,
            $method,
            $newKey,
            0,
            $newIv
        );

        $finalEncryptedKey = base64_encode(
            $newIv . $newEncryptedMasterKey
        );

        // Hash new login password
        $newPasswordHash = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        // Update database
        $updateQuery = "
            UPDATE users
            SET
                password_hash = :password_hash,
                encrypted_master_key = :encrypted_master_key
            WHERE id = :id
        ";

        $updateStatement = $this->connection->prepare(
            $updateQuery
        );

        $updateStatement->bindParam(
            ':password_hash',
            $newPasswordHash
        );

        $updateStatement->bindParam(
            ':encrypted_master_key',
            $finalEncryptedKey
        );

        $updateStatement->bindParam(
            ':id',
            $userId
        );

        if ($updateStatement->execute()) {

            $_SESSION['plain_password']
                = $newPassword;

            return "Password changed successfully";
        }

        return "Failed to change password";
    }
}