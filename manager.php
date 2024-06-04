<?php
error_reporting(0);
ob_start();
session_start();
try {
    $db = new PDO("mysql:host=localhost;dbname=blog_db;charset=utf8;", "root", "");
} catch (PDOException $dberror) {
    echo $dberror->getMessage();
}

//We pulled the logged in user's data from the database
if (isset($_SESSION["email"])) {
    $query = $db->prepare("SELECT * FROM users WHERE email=?");
    $query->execute(array($_SESSION["email"]));
    $usernumber = $query->rowCount();
    $usersinfo = $query->fetch(PDO::FETCH_ASSOC);
    if ($usernumber > 0) {
        $username = $usersinfo["username"];
        $email = $usersinfo["email"];
        $registerdate = $usersinfo["registerdate"];
        $authority = $usersinfo["authority"];
    }
}

// we pull data of blog posts from database
$query = $db->prepare("SELECT * FROM blog order by blogid desc");
$query->execute();
$blognumber = $query->rowCount();
$bloginfo = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_GET) {
    $blogid = intval($_GET["blogid"]);
    $query = $db->prepare("SELECT * FROM blog WHERE blogid=?");
    $query->execute(array($_GET["blogid"]));
    $info = $query->fetch(PDO::FETCH_ASSOC);
}

// blog comments
    // Query to get the number of comments for each blog
  // Query to get the number of comments for each blog
  $query = $db->prepare("SELECT blog_id, comment_id, COUNT(*) AS comment_count FROM blog_comments GROUP BY blog_id, comment_id");
  $query->execute();
  $comment_counts = $query->fetchAll(PDO::FETCH_ASSOC);
  $comment_count_map = [];
  foreach ($comment_counts as $count) {
      $blog_id = $count['blog_id'];
      $comment_id = $count['comment_id'];
      $comment_count = $count['comment_count'];
      
      if (!isset($comment_count_map[$blog_id])) {
          $comment_count_map[$blog_id] = [];
      }
      
      $comment_count_map[$blog_id][$comment_id] = $comment_count;
  }

  // blog likes
    // Query to get the number of likes for each blog
    $query = $db->prepare("SELECT blog_id, like_id, COUNT(*) AS like_count FROM blog_likes GROUP BY blog_id");
$query->execute();
$like_counts = $query->fetchAll(PDO::FETCH_ASSOC);
$like_count_map = [];
foreach ($like_counts as $count) {
      $blog_id = $count['blog_id'];
      $like_count = $count['like_count'];
    
    $like_count_map[$blog_id] = $like_count;
}

  

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>

