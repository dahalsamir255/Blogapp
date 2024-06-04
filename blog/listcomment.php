<?php
// listcomment.php

session_start();

// Establish database connection
try {
    $db = new PDO("mysql:host=localhost;dbname=blog_db;charset=utf8;", "root", "");
} catch (PDOException $dberror) {
    echo $dberror->getMessage();
}

// Delete comment if delete button is clicked
if ($_GET && isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["comment_id"])) {
    $comment_id = intval($_GET["comment_id"]);

    $query = $db->prepare("DELETE FROM blog_comments WHERE comment_id = ?");
    $query->execute([$comment_id]);

    // Redirect back to the same page after deletion
    header("Location: {$_SERVER['PHP_SELF']}?blogid={$_GET['blogid']}");
    exit;
}

$comments = []; // Initialize an empty array to store comments

if ($_GET && isset($_GET["blogid"])) {
    $blogid = intval($_GET["blogid"]);

    // Retrieve comments for the specified blog post
    $query = $db->prepare("SELECT * FROM blog_comments WHERE blog_id = ? ORDER BY comment_time DESC");
    $query->execute([$blogid]);
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>List Comments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .comment {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            position: relative; /* Position for delete button */
        }
        .comment p {
            margin: 0;
            padding: 5px 0;
        }
        .comment p.comment-text {
            font-size: 18px;
            color: #333;
        }
        .comment p.comment-date {
            font-size: 14px;
            color: #777;
        }
        .comment p.user-id {
            font-size: 12px;
            color: #777;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff5555;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style> 
</head>

<body>
<?php include "../navbar.php"?>
    <div class="container">
        <h1 style="text-align:center">Comments</h1>
        <?php if (!empty($comments)) : ?>
            <?php foreach ($comments as $comment) : ?>

              
                    <!-- // Fetch username based on user_id
                    // $query_username = $db->prepare("SELECT username FROM users WHERE user_id = ?");
                    // $query_username->execute([$comment['user_id']]);
                    // $username = $query_username->fetchColumn(); -->
                 

                <div class="comment">
                    <button class="delete-btn" onclick="deleteComment(<?php echo $comment['comment_id']; ?>, <?php echo $blogid; ?>)">Delete</button>
                    <p class="comment-text"><?php echo $comment['comment_text']; ?></p>
                    <p class="comment-date">Date: <?php echo $comment['comment_time']; ?></p>
                    
                   
                    <!-- <p class="user-id"> User: <?php echo $username; ?></p> -->
                    
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No comments found.</p>
        <?php endif; ?>
    </div>

    <script>
        function deleteComment(commentId, blogId) {
            if (confirm("Are you sure you want to delete this comment?")) {
                window.location.href = `<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&comment_id=${commentId}&blogid=${blogId}`;
            }
        }
    </script>
    
</body>

</html>
