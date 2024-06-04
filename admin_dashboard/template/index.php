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

// Fetch all blog posts
try {
    $stmt = $db->query('SELECT * FROM blog');
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $dberror) {
    echo "Query failed: " . $dberror->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        nav {
            text-align: center;
            margin-bottom: 40px;
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
            width: 100%;
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
        .read-more {
            color: #007bff;
            cursor: pointer;
        }
        .read-more:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="manage_permissions.php">Manage Permissions</a>
            <a href="index.php">View Blog Posts</a>
            <a href="users.php">Users</a>
        </nav>
        <h2>Blog Posts</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['blogtitle']); ?></td>
                        <td>
                            <?php 
                            $content = htmlspecialchars($post['blogtext']);
                            if (strlen($content) > 100) {
                                echo substr($content, 0, 100) . '... ';
                                echo '<span class="read-more" data-fulltext="' . $content . '">Read More</span>';
                            } else {
                                echo $content;
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($post['time']); ?></td>
                        <td>
                            <a href="edit_post.php?blogid=<?php echo $post['blogid']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_post.php?blogid=<?php echo $post["blogid"];?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.read-more').on('click', function() {
                var fullText = $(this).data('fulltext');
                $(this).parent().html(fullText);
            });
        });
    </script>
</body>
</html>
