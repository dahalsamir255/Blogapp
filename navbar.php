<?php
require_once "manager.php";
?>
<nav style="background-color: #c0c0c0" class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <a class="navbar-brand" href="./index.php">PHP Blog System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
      </div>
    </div>
    <form class="form-inline my-2 my-lg-0">
      <?php
      if (isset($_SESSION["email"])) {
        if ($authority == "Admin") {
          ?>
          <div class="nav-item dropdown">
            <!-- <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
              Admin Panel
            </a> -->
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/php-blog/blog/addblog.php">Add Text</a>
            </div>
          </div>
          <?php
        }
        ?>
        <a class="nav-link" href="/php-blog/blog/addblog.php">Add Blog</a>
        <a class="nav-link" href="/php-blog/profile.php">Profile</a>
        <a class="nav-link" href="/php-blog/logout.php">Logout</a>
        <?php
      } else {
        ?>
        <a class="nav-link" href="/php-blog/login.php">Login</a>
        <a class="nav-link" href="/php-blog/register.php">Register</a>
        <?php
      }
      ?>
    </form>
  </div>
</nav>
