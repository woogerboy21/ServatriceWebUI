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
                case "blankinfo": $displayed_message = "Information can not be blank.."; break;
                case "invalidcred": $displayed_message = "User account info incorrect."; break;
                case "notprivileged": $displayed_message = "You must be a moderator or higher."; break;
                case "inactive": $displayed_message = "Account is inactive."; break;
                case "notexist": $displayed_message = "User account does not exist."; break;
                case "loginrequired": $displayed_message = "Login required."; break;
                case "sessiontimeout": $displayed_message = "Session timeout."; break;
                default: $displayed_message = "Internal error, please try again."; break;
            }
        }

        switch ($_GET['source'])
        {
            case "authentication": $source_img = '"loginerror.png"'; break;
            case "session": $source_img = '"sessionerror.png"'; break;
            default: $source_img = '"avatar.png"'; break;
        }
        
    ?>
</head>
<body>
    <div class="wrap">
        <div class="avatar">
            <a href="index.php"><img src="<?=$source_img?>"></a>
        </div>
        <input type="texttitle" name="reason" placeholder="Failed Login" required disabled>
        <input type="textdescript" name="inputedpword" placeholder="<?=$displayed_message?>" required disabled>
    </div>
</body>
</html>