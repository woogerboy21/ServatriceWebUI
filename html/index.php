<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Servarice Admin Tools</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
    session_start();
    session_unset();
    session_destroy();
  ?>
    <form action="funct/authentication.php" method="post">
        <div class="wrap">
        <div class="avatar">
            <img src="avatar.png">
        </div>
        <input type="text" name="inputeduname" placeholder="username" required>
        <div class="bar">
            <i></i>
        </div>
        <input type="password" name="inputedpword" placeholder="password" required>
        <!-- <a href="" class="forgot_link">forgot ?</a> -->
        <button type="submit">Sign in</button>
    </div>
  </form>
        <!-- <script src="js/index.js"></script> -->
  </body>
</html>