CREATE DATABASE IF NOT EXISTS password_manager;

USE password_manager;

DROP TABLE IF EXISTS password_entries;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    encrypted_master_key TEXT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE password_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    website_name VARCHAR(100) NOT NULL,

    encrypted_password TEXT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX (user_id),

    CONSTRAINT fk_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;