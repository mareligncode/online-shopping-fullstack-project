<?php
// Database configuration
$host = "localhost";
$user = "root"; // replace with your database username
$pass = ""; // replace with your database password
$dbname = "shopping";

// Create connection
$conn = mysqli_connect($host, $user, $pass,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

// Select database
mysqli_select_db($conn, $dbname);

// Create tables
$tables = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        fname VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        gender ENUM('male', 'female') NOT NULL,
        password VARCHAR(255) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS contacts (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        message TEXT NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS services (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        service_name VARCHAR(100) NOT NULL,
        description TEXT NOT NULL
    )"
];

foreach ($tables as $table) {
    if (mysqli_query($conn, $table)) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
}



$alter_queries = [
    "ALTER TABLE users ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
    "ALTER TABLE contacts ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
    "ALTER TABLE services ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
];

foreach ($alter_queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Column added successfully<br>";
    } else {
        echo "Error adding column: " . mysqli_error($conn) . "<br>";
    }
}

// Delete columns
$alter_queries_drop = [
    // "ALTER TABLE users DROP COLUMN created_att",
    "ALTER TABLE contacts DROP COLUMN created_att",
    "ALTER TABLE services DROP COLUMN created_attt"
];

foreach ($alter_queries_drop as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Column deleted successfully<br>";
    } else {
        echo "Error deleting column: " . mysqli_error($conn) . "<br>";
    }
}

// Close connection
mysqli_close($conn);
?>