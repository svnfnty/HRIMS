<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Replace with your MySQL username
define('DB_PASS', ''); // Replace with your MySQL password
define('DB_NAME', 'hrims_db');

// Create a connection to MySQL
class DBConnection {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }

            // Create the database if it doesn't exist
            $this->conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
            $this->conn->select_db(DB_NAME);

            // Initialize tables
            $this->initializeTables();

            // Insert default user
            $this->insertDefaultUser();
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    private function initializeTables() {
        $tables = [
            "CREATE TABLE IF NOT EXISTS `user_list` (
                `user_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `fullname` VARCHAR(255) NOT NULL,
                `username` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `type` INT NOT NULL DEFAULT 1,
                `status` INT NOT NULL DEFAULT 1,
                `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS `department_list` (
                `department_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS `designation_list` (
                `designation_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `department_id` INT NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL,
                FOREIGN KEY (`department_id`) REFERENCES `department_list` (`department_id`) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS `vacancy_list` (
                `vacancy_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `designation_id` INT NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `slots` INT NOT NULL DEFAULT 0,
                `status` INT NOT NULL DEFAULT 1,
                `description` TEXT NOT NULL,
                `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`designation_id`) REFERENCES `designation_list` (`designation_id`) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS `address_list` (
                `AddressID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `applicant_id` INT NOT NULL,
                `purok` VARCHAR(255) NOT NULL,
                `street` VARCHAR(255) NOT NULL,
                `barangay` VARCHAR(255) NOT NULL,
                `village` VARCHAR(255) NOT NULL,
                `municipality` VARCHAR(255) NOT NULL,
                `province` VARCHAR(255) NOT NULL,
                `zipcode` INT NOT NULL
            )",

            "CREATE TABLE IF NOT EXISTS `applicant_list` (
                `applicant_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `vacancy_id` INT NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `gender` VARCHAR(10) NOT NULL,
                `address` TEXT NOT NULL,
                `contact` VARCHAR(50) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `dob` DATE NOT NULL,
                `summary` TEXT NOT NULL,
                `message` TEXT NOT NULL,
                `status` INT NOT NULL DEFAULT 1,
                `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`vacancy_id`) REFERENCES `vacancy_list` (`vacancy_id`) ON DELETE CASCADE
            )"
        ];

        foreach ($tables as $query) {
            if (!$this->conn->query($query)) {
                die("Error creating table: " . $this->conn->error);
            }
        }
    }

    private function insertDefaultUser() {
        $defaultUserQuery = "INSERT INTO `user_list` (`user_id`, `fullname`, `username`, `password`, `type`, `status`, `date_created`)
            VALUES (1, 'Administrator', 'admin', MD5('admin123'), 1, 1, CURRENT_TIMESTAMP)
            ON DUPLICATE KEY UPDATE `fullname` = 'Administrator'";

        if (!$this->conn->query($defaultUserQuery)) {
            die("Error inserting default user: " . $this->conn->error);
        }
    }

    public function escapeString($value) {
        return $this->conn->real_escape_string($value);
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function fetch_assoc($result) {
        return $result->fetch_assoc();
    }

    public function __destruct() {
        $this->conn->close();
    }
}

$conn = new DBConnection();
?>
