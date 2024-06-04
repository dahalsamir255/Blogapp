<?php
// add_comment.php

session_start();

if (!isset($_SESSION["email"])) {
    // Redirect to login page if user is not logged in
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["blog_id"], $_POST["comment_text"])) {
    $blog_id = $_POST["blog_id"];
    $comment_text = $_POST["comment_text"];

    // Validate comment text, you can add more validation as needed
    if (empty(trim($comment_text))) {
        // Handle error if comment text is empty
        echo "Comment text cannot be empty.";
    } else {
        try {
            // Establish database connection
            $db = new PDO("mysql:host=localhost;dbname=blog_db;charset=utf8;", "root", "");

            // Get user ID based on email
            $query = $db->prepare("SELECT id FROM users WHERE email = ?");
            $query->execute([$_SESSION["email"]]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $user_id = $user["id"];

            // Insert comment into database
            $query = $db->prepare("INSERT INTO blog_comments (blog_id, comment_text, user_id, comment_time) VALUES (?, ?, ?, NOW())");
            $query->execute([$blog_id, $comment_text, $user_id]); // $_SESSION["email"]]);

            // Redirect back to the blog post after adding comment
            header("Location: ../index.php"); // blog.php?blogid=$blog_id");
            exit();
        } catch (PDOException $e) {
            // Handle database connection or query error
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    // Handle invalid request
    echo "Invalid request.";
}
?>
