<?php
$conn = new mysqli("localhost", "root", "", "my_app");
if ($conn->connect_error) die("Connection failed");

// CREATE TABLE if not exists
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT
)");

// HANDLE INSERT
if (isset($_POST['save'])) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['message']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// HANDLE UPDATE
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, message=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['name'], $_POST['email'], $_POST['message'], $_POST['id']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// HANDLE DELETE
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// FETCH FOR EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}

$allUsers = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP + SQL CRUD</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        .btn { padding: 6px 12px; text-decoration: none; border: none; cursor: pointer; }
        .edit { background: #2196F3; color: white; }
        .delete { background: #f44336; color: white; }
    </style>
</head>
<body>

<h2><?= $editData ? "Edit User" : "Add New User" ?></h2>
<form method="POST">
    <?php if($editData): ?>
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <?php endif; ?>
    
    <input type="text" name="name" placeholder="Name" required 
           value="<?= $editData['name'] ?? '' ?>">
    <input type="email" name="email" placeholder="Email" required 
           value="<?= $editData['email'] ?? '' ?>">
    <textarea name="message" placeholder="Message"><?= $editData['message'] ?? '' ?></textarea>
    
    <button type="submit" name="<?= $editData ? 'update' : 'save' ?>">
        <?= $editData ? 'Update' : 'Save' ?>
    </button>
    <?php if($editData): ?>
        <a href="index.php">Cancel</a>
    <?php endif; ?>
</form>

<hr>
<h3>Server Info</h3>
<p>Host: <?= $_SERVER['HTTP_HOST'] ?> | PHP: <?= phpversion() ?> | Method: <?= $_SERVER['REQUEST_METHOD'] ?></p>

<h2>All Records</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Actions</th></tr>
    <?php while($row = $allUsers->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['message']) ?></td>
        <td>
            <a class="btn edit" href="?edit=<?= $row['id'] ?>">Edit</a>
            <a class="btn delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>