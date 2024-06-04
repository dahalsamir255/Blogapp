<?php
require_once "../manager.php";

if(!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit(); // Stop further execution to prevent redirect conflicts
}

if(isset($_GET["blogid"])) {
    $blogid = intval($_GET["blogid"]);

    // Delete comments associated with the blog post
    $query_delete_comments = $db->prepare("DELETE FROM blog_comments WHERE blog_id=?");
    $query_delete_comments->execute(array($blogid));

    // Delete the blog post
    $query_delete_blog = $db->prepare("DELETE FROM blog WHERE blogid=?");
    $query_delete_blog->execute(array($blogid));

    header("Location: ../index.php");
    exit(); // Stop further execution after redirect
} else {
    // Handle case where blogid is not provided in the URL
    header("Location: ../index.php");
    exit(); // Stop further execution after redirect
}
?>
