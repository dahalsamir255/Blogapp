<!-- 
require_once "../../manager.php";

if(!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit(); // Stop further execution to prevent redirect conflicts
}

if(isset($_GET["blogid"])) {
    $blogid = intval($_GET["blogid"]);

    // Delete comments associated with the blog post
    $query_delete_comments = $db->prepare("DELETE FROM blog_comments WHERE blog_id=blogid");
    $query_delete_comments->execute(array($blogid));

    // Delete the blog post
    $query_delete_blog = $db->prepare("DELETE FROM blog WHERE blogid=blogid");
    $query_delete_blog->execute(array($blogid));

    header("Location: index.php");
    exit(); // Stop further execution after redirect
} else {
    // Handle case where blogid is not provided in the URL
    header("Location: index.php");
    exit(); // Stop further execution after redirect
}
 -->
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

if (!isset($_GET['blogid'])) {
    die("Blog ID not provided.");
}

$blog_id = $_GET['blogid'];

// Delete user
try {
    $stmt = $db->prepare('DELETE FROM blog WHERE blogid = :blogid');
    $stmt->bindParam(':blogid', $blog_id);
    $stmt->execute();
    header('Location: index.php');
    exit;
} catch (PDOException $dberror) {
    echo "Deletion failed: " . $dberror->getMessage();
    die();
}
?>
