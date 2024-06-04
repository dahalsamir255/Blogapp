<?php

include "../../navbar.php";

error_reporting(0);
ob_start();
session_start();
try {
    $db = new PDO("mysql:host=localhost;dbname=blog_db;charset=utf8;", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $dberror) {
    echo "Connection failed: " . $dberror->getMessage();
    die();
}

if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$user_id = $_GET['id'];

// Fetch user details
try {
    $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
} catch (PDOException $dberror) {
    echo "Query failed: " . $dberror->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $authority = $_POST['authority'];

    // Update user details
    try {
        $stmt = $db->prepare('UPDATE users SET username = :username, email = :email, authority = :authority WHERE id = :id');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':authority', $authority);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        header('Location: users.php');
        exit;
    } catch (PDOException $dberror) {
        echo "Update failed: " . $dberror->getMessage();
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="authority">Authority</label>
                <select id="authority" name="authority" class="form-control" required>
                    <option value="User" <?php echo ($user['authority'] == 'User') ? 'selected' : ''; ?>>User</option>
                    <option value="Admin" <?php echo ($user['authority'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
