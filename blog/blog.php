<?php
//error_reporting(0);
require_once "../manager.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $info["blogtitle"];?></title>
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
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .card-text {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.6;
        }
        .edit-links a {
            color: #007bff;
            text-decoration: none;
            margin-right: 20px;
        }
        .edit-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include "../navbar.php";?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $info["blogtitle"];?></h5>
                        <p class="card-text"><?php echo $info["blogtext"];?></p>
                        <?php if (isset($_SESSION["email"])) { ?>
                            <div class="edit-links">
                                <a href="editblog.php?blogid=<?php echo $info["blogid"];?>">Edit</a>
                                <a href="deleteblog.php?blogid=<?php echo $info["blogid"];?>">Delete</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
