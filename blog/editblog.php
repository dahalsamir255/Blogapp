<?php
// cannot access the page if there is no session
require_once "../manager.php";

// if($authority == "User")
// {
//     header("Location: ../index.php");
// }

if(!isset($_SESSION["email"]))
{
    header("Location: ../index.php");
}

if($_POST)
{
    $edittitle = $_POST["edittitle"];
    $edittext = $_POST["edittext"];
    $titlenumber = strlen($edittitle);
    $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    if($titlenumber > 80)
    {
        $errormsg = "Title is too long.";
    }
    else
    {
        $query = $db->prepare("UPDATE blog SET blogtitle=?, blogtext=? WHERE blogid=?");
        $update = $query->execute(array($edittitle, $edittext, $info["blogid"]));
        if($update)
        {
            $errormsg = "Updated.";
            header("Refresh: 1; url=$url");
            header("Location: ../index.php");
        }
        else
        {
            $errormsg = "Could not update.";
        }
    } 
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container-fluid {
            padding-top: 20px;
        }
        .form-control {
            border-radius: 0;
        }
        .btn-warning {
            border-radius: 0;
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333;
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #333;
        }
        .alert {
            border-radius: 0;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include "../navbar.php"?>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-8">
                <form method="POST">
                    <input type="text" class="form-control" name="edittitle" value="<?php echo $info["blogtitle"]?>" placeholder="Enter Blog Title">
                    <textarea class="form-control mt-1" name="edittext" cols="30" rows="10" placeholder="Enter Blog Text"><?php echo $info["blogtext"]?></textarea>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-warning btn-block">Update</button>
                <?php
                if(!empty($errormsg))
                {
                    ?>
                    <div class="alert alert-success" role="alert">
                    <?php echo $errormsg;?>
                    </div>
                    <?php
                }
                ?>
            </div>
            </form>
        </div>
    </div>
</body>
</html>

