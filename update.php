<?php
include 'db.php';
$stmt = $conn->prepare("UPDATE users SET email=? WHERE id=?");
$stmt->bind_param("si", $newEmail, $id);
$newEmail = "newemail@example.com";
$id = 1;
$stmt->execute();
echo "Updated: " . $stmt->affected_rows . " row(s)";
?>
