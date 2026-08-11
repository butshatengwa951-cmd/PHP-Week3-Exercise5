<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Using $_REQUEST
    $name = htmlspecialchars($_REQUEST['name']);
    $email = htmlspecialchars($_REQUEST['email']);
    $message = htmlspecialchars($_REQUEST['message']);

    echo "Name: $name, Email: $email, Message: $message";
}
?>