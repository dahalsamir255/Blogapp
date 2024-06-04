<?php
require_once "manager.php";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }
    .container {
      padding-top: 20px;
    }
    .custom-width {
      max-width: 800px; /* Adjust the max-width as needed */
    }
    .card {
      margin-bottom: 20px;
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease-in-out;
    }
    .card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-title {
      font-size: 2rem; /* Increased font size */
      font-weight: bold;
      color: #007bff; /* Blue color */
    }
    .card-text {
      font-size: 1rem;
    }
    .card-footer {
      font-size: 0.9rem;
      color: #868e96;
    }
    .comment-link {
      color: #6c757d;
      text-decoration: none;
    }
    .comment-link:hover {
      text-decoration: underline;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    #post-content {
      display: none;
    }
  </style>
</head>
<body>
    <?php include "navbar.php"?>
    <div class="container mt-3 custom-width">
      <div class="row">
        <div class="col-md-12 mx-auto">
          <?php
            foreach($bloginfo as $blog) {
              $numberofcharacters = strlen($blog["blogtext"]);
              ?>
                <div class="card mt-1">
                  <div class="card-body">
                    <a href="blog/blog.php?blogid=<?php echo $blog["blogid"];?>">
                      <h5 class="card-title"><?php echo $blog["blogtitle"]?></h5>
                    </a>
                    <?php
                    if($numberofcharacters > 200) {
                        echo substr($blog["blogtext"],0,350) ."...";
                      ?>
                      <form method="get">
                        <a href="blog/blog.php?blogid=<?php echo $blog["blogid"];?>">Read more</a>
                      </form>
                      <?php
                    } else {
                    ?>
                      <p class="card-text"><?php echo $blog["blogtext"]?></p>
                    <?php
                    }
                    ?>
                  </div>
                  <div class="card-footer">
                    <a href="index.php">
                      <button class="like-button" data-blog-id="<?php echo $blog_id; ?>">
                        <i class="fa-regular fa-thumbs-up"></i> 
                        Likes:
                        <span class="like-count"><?php echo $like_count ? $like_count : 0; ?></span>
                      </button>
                    </a>
                    &nbsp;
                    <?php
                      $blog_id = $blog["blogid"];
                      $dislike_count = 0;
                    ?>
                    <i class="fa-regular fa-thumbs-down"></i>
                    Dislikes: <?php echo $dislike_count; ?>
                    &nbsp;
                    Comments: <a class="comment-link" href="blog/listcomment.php?blogid=<?php echo $blog['blogid']; ?>&comment_id=<?php echo $comment['comment_id']; ?>">
                      <i class="fa-regular fa-comment"></i>
                      <?php
                      $blog_id = $blog["blogid"];
                      $comment_count = isset($comment_count_map[$blog_id]) ? array_sum($comment_count_map[$blog_id]) : 0;
                      echo $comment_count;
                      ?>
                    </a>
                    &nbsp;
                    Submitted by: <a class="text-secondary"><?php echo $blog["user"]?></a>
                    Add Date: <a class="text-secondary"><?php echo $blog["time"]?></a>
                  </div>
                </div>
                <?php if (isset($_SESSION["email"])) { ?>
                  <!-- Form to add comment -->
                  <div class="mt-3">
                      <form action="blog/addcomment.php" method="POST">
                          <input type="hidden" name="blog_id" value="<?php echo $blog['blogid']; ?>">
                          <textarea name="comment_text" class="form-control" placeholder="Add your comment" required></textarea>
                          <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
                      </form>
                  </div>
                <?php } ?>
              <?php
            }
          ?>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $('.like-button').on('click', function() {
          var blogId = $(this).data('blog-id');
          var likeCountElement = $(this).find('.like-count');
          $.ajax({
            type: 'POST',
            url: 'toggle_like.php',
            data: { blog_id: blogId },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                var likeCount = parseInt(likeCountElement.text());
                if (response.message === 'liked') {
                  likeCount++;
                } else {
                  likeCount = 0; // Liked again, reset to 0
                }
                likeCountElement.text(likeCount);
              } else {
                console.error('Error:', response.message);
              }
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);
            }
          });
        });
      });
    </script>
</body>
</html>

