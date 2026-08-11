<?php
$conn = new mysqli("localhost:3307", "root", "Butsha06#", "my_app");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
