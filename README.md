# Password Manager System

A secure Password Manager web application developed using PHP Object-Oriented Programming (OOP), MySQL, and AES-256-CBC encryption.

## Project Overview

The Password Manager System allows users to securely store and manage passwords for websites and applications. The system implements modern security practices including password hashing, master key management, and AES encryption to protect sensitive information.

## Features

### User Authentication

* User registration
* User login
* User logout
* Session-based authentication
* Secure password hashing using PHP `password_hash()`
* Password verification using `password_verify()`

### Password Management

* Add password entries
* View stored passwords
* Delete password entries
* Store website/application credentials
* Automatic timestamp recording

### Password Generator

* Custom password generation
* Configurable password length
* Uppercase character selection
* Lowercase character selection
* Number selection
* Special character selection

### Security Features

* AES-256-CBC encryption
* Master key architecture
* Password hashing
* Encrypted password storage
* Secure key management
* Master key re-encryption during password changes

## Technologies Used

| Technology  | Purpose                 |
| ----------- | ----------------------- |
| PHP         | Backend Development     |
| MySQL       | Database Management     |
| PDO         | Database Connectivity   |
| Bootstrap 5 | User Interface          |
| OpenSSL     | AES Encryption          |
| Docker      | Development Environment |
| TablePlus   | Database Administration |
| PlantUML    | UML Diagram Creation    |

## Project Structure

```text
PasswordManagerProject/
│
├── app/
│   ├── classes/
│   │   ├── User.php
│   │   ├── PasswordEntry.php
│   │   └── PasswordGenerator.php
│   │
│   ├── config/
│   │   └── Database.php
│   │
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│
├── public/
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── add_password.php
│   ├── view_passwords.php
│   ├── generator.php
│   ├── change_password.php
│   ├── delete_password.php
│   └── logout.php
│
├── database/
│   └── schema.sql
│
├── docker/
│   ├── apache/
│   └── php/
│       └── Dockerfile
│
├── docker-compose.yml
├── README.md
└── Report.pdf
```

## Database Design

### users Table

| Column               | Type         |
| -------------------- | ------------ |
| id                   | INT (PK)     |
| username             | VARCHAR(50)  |
| password_hash        | VARCHAR(255) |
| encrypted_master_key | TEXT         |
| created_at           | TIMESTAMP    |

### password_entries Table

| Column             | Type         |
| ------------------ | ------------ |
| id                 | INT (PK)     |
| user_id            | INT (FK)     |
| website_name       | VARCHAR(100) |
| encrypted_password | TEXT         |
| created_at         | TIMESTAMP    |

## Encryption Architecture

### Registration Process

1. User creates account.
2. User password is hashed using `password_hash()`.
3. A permanent master key is generated.
4. The master key is encrypted using the user's login password.
5. The encrypted master key is stored in the database.

### Password Storage Process

1. User enters a website password.
2. The encrypted master key is retrieved.
3. The master key is decrypted using the user's login password.
4. The website password is encrypted using AES-256-CBC.
5. The encrypted password is stored in the database.

### Password Change Process

1. User enters current password.
2. System verifies password.
3. Master key is decrypted.
4. User enters new password.
5. Master key is re-encrypted using the new password.
6. Existing stored passwords remain accessible.

## Installation

### Option 1: Docker (Recommended)

#### Requirements

* Docker
* Docker Compose

#### Run Project

```bash
docker compose up -d
```

#### Access Application

```text
http://localhost:8000
```

#### Access Database

```text
Host: 127.0.0.1
Port: 3307
Database: password_manager
Username: appuser
Password: password123
```

### Option 2: Manual Installation

#### Requirements

* PHP 8+
* MySQL 8+
* Apache or XAMPP/MAMP

#### Steps

1. Create MySQL database:

```sql
CREATE DATABASE password_manager;
```

2. Import schema:

```bash
database/schema.sql
```

3. Configure database credentials in:

```text
app/config/Database.php
```

4. Place project in web server root.

5. Open:

```text
http://localhost
```

## Testing

The following functionality was tested successfully:

* User Registration
* User Login
* User Logout
* Password Hashing
* Password Encryption
* Password Decryption
* Password Generation
* Password Storage
* Password Deletion
* Password Change
* Session Authentication

## UML Diagrams

The project documentation includes:

1. UML Class Diagram
2. Entity Relationship Diagram (ERD)
3. Password Encryption Workflow Diagram

## Security Considerations

* Passwords are never stored in plain text.
* Login passwords are hashed using PHP password hashing functions.
* Website passwords are encrypted using AES-256-CBC.
* Each user has a unique master key.
* Master keys are encrypted before storage.
* Session authentication protects application access.

## Author

Aleem Shah

## License

This project was developed for academic purposes as part of a PHP Object-Oriented Programming and MySQL Database Systems assignment.
