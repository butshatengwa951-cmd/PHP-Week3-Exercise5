<?php
include 'db.php';
$stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);
$name = "Alice";
$email = "alice@example.com";
$stmt->execute();
echo "Inserted ID: " . $stmt->insert_id;
?>