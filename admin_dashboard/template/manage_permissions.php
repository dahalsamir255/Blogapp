<?php

include "../../navbar.php";

error_reporting(E_ALL);
ob_start();
// session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=blog_db;charset=utf8;", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $dberror) {
    echo "Connection failed: " . $dberror->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $user_id = $_POST['user_id'];
    $permission = $_POST['permission'];
    $stmt = $db->prepare('INSERT INTO permissions (user_id, permission) VALUES (:user_id, :permission)');
    $stmt->execute(['user_id' => $user_id, 'permission' => $permission]);
}

try {
    $usersStmt = $db->query('SELECT * FROM users');
    $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $dberror) {
    echo "Query failed: " . $dberror->getMessage();
    die();
}

try {
    $permissionsStmt = $db->query('SELECT p.id, u.username, p.permission FROM permissions p JOIN users u ON p.user_id = u.id');
    $permissions = $permissionsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $dberror) {
    echo "Query failed: " . $dberror->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Permissions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
            padding: 15px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Permissions</h1>
        <nav class="text-center">
            <a href="manage_permissions.php">Manage Permissions</a>
            <a href="index.php">View Blog Posts</a>
        </nav>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Permission</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permissions as $perm): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($perm['username']); ?></td>
                        <td><?php echo htmlspecialchars($perm['permission']); ?></td>
                        <td>
                            <a href="edit_permission.php?id=<?php echo $perm['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_permission.php?id=<?php echo $perm['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2>Add Permission</h2>
        <div class="form-container mx-auto" style="max-width: 600px;">
            <form action="manage_permissions.php" method="post">
                <div class="form-group">
                    <label for="user_id">User:</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="permission">Permission:</label>
                    <input type="text" name="permission" id="permission" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Permission</button>
                <input type="hidden" name="action" value="add">
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
