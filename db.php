<?php
$conn = new mysqli("localhost", "root", "", "my_app");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>