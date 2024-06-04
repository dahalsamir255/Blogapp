<?php
require_once "manager.php";

if($_POST)
{
    //post
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    
    if($email!="" && $password!="")
    {
        $query = $db->prepare("SELECT * FROM users WHERE email=? and password=?");
        $query->execute(array($email, $password));
        $login = $query->rowCount();
        if($email==="admin@gmail.com")
        {
            $errormsg = "Login successful :)";
            $_SESSION["email"] = $email;
            header("Refresh: 2; url=../../php-blog/admin_dashboard/template/index.php");
        }
        else if($login > 0)
        {
            $errormsg = "Login successful :)";
            $_SESSION["email"] = $email;
            header("Refresh: 2; url=index.php");
        }
        else
        {
            $errormsg = "Login failed :(";
        }
    }
    else
    {
        $errormsg = "Do not leave empty space!";
    }
}
?>



<?php
//session control
if(isset($_SESSION["email"]))
{
    ?>
     <?php include "navbar.php"?>
    <?php
    echo "You are already logged in";
}
else
{
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 20px;
        }
        .login-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .login-card .alert {
            border-radius: 0;
            background-color: #ffc107;
            color: #333;
            font-weight: bold;
            text-align: center;
            margin-bottom: 0;
        }
        .login-card .form-control {
            border-radius: 0.25rem;
        }
        .login-card a {
            color: #007bff;
        }
        .login-card a:hover {
            text-decoration: underline;
        }
        .login-card .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333;
            border-radius: 0.25rem;
        }
        .login-card .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include "navbar.php"?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card login-card">
                    <div class="alert" role="alert">
                        Login Form
                    </div>
                    <form method="post">
                        <input type="text" class="form-control mt-1" name="email" placeholder="Email">
                        <input type="password" class="form-control mt-1" name="password" placeholder="Password">
                        <?php if (!empty($errormsg)) { ?>
                            <div class="alert alert-success mt-1" role="alert">
                                <?php echo $errormsg; ?>
                            </div>
                        <?php } ?>
                        <a href="register.php">Don't have an account yet? </a><br>
                        <button type="submit" class="btn btn-warning mt-1">Login</button>   
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

    <?php
}

?>
