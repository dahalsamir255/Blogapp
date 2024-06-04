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

// Delete user
try {
    $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    header('Location: users.php');
    exit;
} catch (PDOException $dberror) {
    echo "Deletion failed: " . $dberror->getMessage();
    die();
}
?>
