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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['permission_id'])) {
    $permission_id = $_POST['permission_id'];
    $permission = $_POST['permission'];
    $stmt = $db->prepare('UPDATE permissions SET permission = :permission WHERE id = :id');
    $stmt->execute(['permission' => $permission, 'id' => $permission_id]);
    header('Location: manage_permissions.php');
    exit();
}

$permission_id = $_GET['id'];
$stmt = $db->prepare('SELECT * FROM permissions WHERE id = :id');
$stmt->execute(['id' => $permission_id]);
$permission = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Permission</title>
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
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0, 0, 0, 0.1);
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
        <h1>Edit Permission</h1>
        <div class="form-container mx-auto" style="max-width: 600px;">
            <form action="edit_permission.php" method="post">
                <div class="form-group">
                    <label for="permission">Permission:</label>
                    <input type="text" name="permission" id="permission" class="form-control" value="<?php echo htmlspecialchars($permission['permission']); ?>" required>
                </div>
                <input type="hidden" name="permission_id" value="<?php echo $permission_id; ?>">
                <button type="submit" class="btn btn-primary btn-block">Update Permission</button>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

