<?php
$host = "localhost:3307";
$user = "root";
$pass = "Butsha06#"; // default for XAMPP is empty
$dbname = "my_app";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    message TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully<br>";
}

// Insert sample record
$stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->bind_param("ss", $sampleName, $sampleEmail);
$sampleName = "John Doe";
$sampleEmail = "john@example.com";
$stmt->execute();

echo "Sample record inserted";
$stmt->close();
$conn->close();
?>
