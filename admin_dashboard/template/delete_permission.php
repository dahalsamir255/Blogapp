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

if (isset($_GET['id'])) {
    $permission_id = $_GET['id'];
    $stmt = $db->prepare('DELETE FROM permissions WHERE id = :id');
    $stmt->execute(['id' => $permission_id]);
    header('Location: manage_permissions.php');
    exit();
} else {
    echo "Invalid request.";
}

?>
