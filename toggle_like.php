<?php
session_start();
require_once "manager.php";  // or your DB connection script

header('Content-Type: application/json');

if (!isset($_SESSION["email"])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

$blog_id = $_POST['blog_id'];
$email = $_SESSION['email'];

// Fetch the user_id using the email
$query = $db->prepare("SELECT id FROM users WHERE email = :email");
$query->execute([':email' => $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit;
}

$user_id = $user['id'];

// Check if the user has already liked the post for this specific blog_id
$query = $db->prepare("SELECT COUNT(*) AS like_count FROM blog_likes WHERE blog_id = :blog_id AND user_id = :user_id");
$query->execute([':blog_id' => $blog_id, ':user_id' => $user_id]);
$result = $query->fetch(PDO::FETCH_ASSOC);

$like_count = $result['like_count'];

// Check if the user has already liked the post for this specific blog_id
if ($like_count > 0) {
    // User already liked the post, so remove the like
    $query = $db->prepare("DELETE FROM blog_likes WHERE blog_id = :blog_id AND user_id = :user_id");
    $query->execute([':blog_id' => $blog_id, ':user_id' => $user_id]);
    $like_count = 0; // Reset like count
    // header("Location: ./index.php");
} else {
    // User has not liked the post, so add a like
    $query = $db->prepare("INSERT INTO blog_likes (blog_id, user_id) VALUES (:blog_id, :user_id)");
    $query->execute([':blog_id' => $blog_id, ':user_id' => $user_id]);
    $like_count = 1; // Set like count to 1
    // header("Location: ./index.php");
}

// Retrieve updated like count from the database
// $query = $db->prepare("SELECT COUNT(*) AS like_count FROM blog_likes WHERE blog_id = :blog_id");
// $query->execute([':blog_id' => $blog_id]);
// $result = $query->fetch(PDO::FETCH_ASSOC);

echo json_encode(["status" => "success", "like_count" => $like_count]);
?>
