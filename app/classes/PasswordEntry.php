<?php

require_once __DIR__ . '/../config/Database.php';

class PasswordEntry
{
    private $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->connect();
    }

    /*
    |--------------------------------------------------------------------------
    | Decrypt User Master Key
    |--------------------------------------------------------------------------
    */

    private function decryptMasterKey(
        $encryptedMasterKey,
        $password
    ) {

        $method = "AES-256-CBC";

        $key = hash('sha256', $password, true);

        $data = base64_decode($encryptedMasterKey);

        $iv = substr($data, 0, 16);

        $encrypted = substr($data, 16);

        return openssl_decrypt(
            $encrypted,
            $method,
            $key,
            0,
            $iv
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Encrypt Password Entry
    |--------------------------------------------------------------------------
    */

    private function encryptPassword(
        $password,
        $masterKey
    ) {

        $method = "AES-256-CBC";

        $key = hash('sha256', $masterKey, true);

        $iv = random_bytes(16);

        $encrypted = openssl_encrypt(
            $password,
            $method,
            $key,
            0,
            $iv
        );

        return base64_encode($iv . $encrypted);
    }

    /*
    |--------------------------------------------------------------------------
    | Decrypt Password Entry
    |--------------------------------------------------------------------------
    */

    private function decryptPassword(
        $encryptedPassword,
        $masterKey
    ) {

        $method = "AES-256-CBC";

        $key = hash('sha256', $masterKey, true);

        $data = base64_decode($encryptedPassword);

        $iv = substr($data, 0, 16);

        $encrypted = substr($data, 16);

        return openssl_decrypt(
            $encrypted,
            $method,
            $key,
            0,
            $iv
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Save Password Entry
    |--------------------------------------------------------------------------
    */

    public function savePassword(
        $userId,
        $websiteName,
        $plainPassword,
        $loginPassword
    ) {

        // Get encrypted master key
        $query = "
            SELECT encrypted_master_key
            FROM users
            WHERE id = :id
        ";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(':id', $userId);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // Decrypt master key
        $masterKey = $this->decryptMasterKey(
            $user['encrypted_master_key'],
            $loginPassword
        );

        // Encrypt password entry
        $encryptedPassword = $this->encryptPassword(
            $plainPassword,
            $masterKey
        );

        // Save encrypted password
        $insertQuery = "
            INSERT INTO password_entries
            (
                user_id,
                website_name,
                encrypted_password
            )
            VALUES
            (
                :user_id,
                :website_name,
                :encrypted_password
            )
        ";

        $insertStatement = $this->connection->prepare(
            $insertQuery
        );

        $insertStatement->bindParam(
            ':user_id',
            $userId
        );

        $insertStatement->bindParam(
            ':website_name',
            $websiteName
        );

        $insertStatement->bindParam(
            ':encrypted_password',
            $encryptedPassword
        );

        return $insertStatement->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | Get User Password Entries
    |--------------------------------------------------------------------------
    */

    public function getPasswords(
        $userId,
        $loginPassword
    ) {

        // Get encrypted master key
        $query = "
            SELECT encrypted_master_key
            FROM users
            WHERE id = :id
        ";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(':id', $userId);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // Decrypt master key
        $masterKey = $this->decryptMasterKey(
            $user['encrypted_master_key'],
            $loginPassword
        );

        // Get saved passwords
        $passwordQuery = "
            SELECT *
            FROM password_entries
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ";

        $passwordStatement = $this->connection->prepare(
            $passwordQuery
        );

        $passwordStatement->bindParam(
            ':user_id',
            $userId
        );

        $passwordStatement->execute();

        $entries = $passwordStatement->fetchAll(
            PDO::FETCH_ASSOC
        );

        // Decrypt all passwords
        foreach ($entries as &$entry) {

            $entry['decrypted_password']
                = $this->decryptPassword(
                    $entry['encrypted_password'],
                    $masterKey
                );
        }

        return $entries;
    }
        /*
    |--------------------------------------------------------------------------
    | Delete Password Entry
    |--------------------------------------------------------------------------
    */

    public function deletePassword(
        $entryId,
        $userId
    ) {

        $query = "
            DELETE FROM password_entries
            WHERE id = :id
            AND user_id = :user_id
        ";

        $statement = $this->connection->prepare(
            $query
        );

        $statement->bindParam(
            ':id',
            $entryId
        );

        $statement->bindParam(
            ':user_id',
            $userId
        );

        return $statement->execute();
    }
}