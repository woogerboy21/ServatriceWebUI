<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Servatrice Administrator</title>
    <link rel="stylesheet" href="css/style.css">
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "GET")
        {
            switch ($_GET['error'])
            {
                case "loginrequired": $displayed_message = "Login required."; break;
                case "sessiontimeout": $displayed_message = "Session timeout."; break;
                case "notprivileged": $displayed_message = "Elevated permissions required."; break;
                default: $displayed_message = "Unknown session error, re-login." break;
            }
        }
    ?>
</head>
<body>
    <div class="wrap">
        <div class="avatar">
            <a href="index.php"><img src="sessionerror.png"></a>
        </div>
        <input type="texttitle" name="reason" placeholder="Session Error" required disabled>
        <input type="textdescript" name="inputedpword" placeholder="<?=$displayed_message?>" required disabled>
    </div>
</body>
</html>