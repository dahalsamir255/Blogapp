<?php
require_once "manager.php";

// cannot access the page if there is no session
if(!isset($_SESSION["email"]))
{
    header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .profile-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .profile-card .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            text-align: center;
            padding: 20px;
        }
        .list-group-item {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <?php include "navbar.php" ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card profile-card">
                    <div class="card-header">
                        Profile Information
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Username: <?php echo $usersinfo["username"] ?></li>
                        <li class="list-group-item">Email: <?php echo $usersinfo["email"] ?></li>
                        <li class="list-group-item">Date of Registration: <?php echo $usersinfo["registerdate"] ?></li>
                        <li class="list-group-item">Authority: <?php echo $usersinfo["authority"] ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
