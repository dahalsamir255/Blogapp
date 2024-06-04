<?php
// cannot access the page if there is no session
require_once "../manager.php";

if(!isset($_SESSION["email"]))
{
    header("Location: ../index.php");
}

if($_POST)
{
    $title = $_POST["title"];
    $text = $_POST["text"]; 
    $titlenumber = strlen($title);
    if($titlenumber > 80)
    {
        $errormsg = "Title is too long.";
    }
    else
    {
        if($title!="" && $text!="")
        {
            $query = $db->prepare("INSERT INTO blog SET blogtitle=?, blogtext=?, user=?, time=? ");
            $addblog = $query->execute(array($title, $text, $username, date("Y-m-d h:i:s")));
            if($addblog)
            {
                $errormsg = "Text Added.";
                header("Location: ../index.php");
            }
            else
            {
                $errormsg = "Could not add text.";
            }
        }
        else
        {
            $errormsg = "Do not leave empty space!";
        }
    }
}



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Blog</title>
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
        .card {
            margin-top: 20px;
            padding: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert-custom {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include "../navbar.php" ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <h2 class="card-title text-center">Add New Blog Post</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter the title">
                        </div>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <textarea name="text" id="text" class="form-control" rows="10" placeholder="Enter the blog text"></textarea>
                        </div>
                        <?php if (!empty($errormsg)) { ?>
                            <div class="alert alert-success alert-custom" role="alert">
                                <?php echo $errormsg; ?>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-custom btn-block mt-3">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
