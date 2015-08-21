<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Servatrice Administrator</title>
    <link rel="stylesheet" href="css/style.css">
    <?php
        $displayed_message = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET")
        {
            switch ($_GET['error']){
                case "blankinfo":
                    $displayed_message = "Information can not be blank..";
                    break;
                case "invalidcred":
                    $displayed_message = "User account info incorrect.";
                    break;
                case "notprivileged":
                    $displayed_message = "You must be a moderator or higher.";
                    break;
                case "inactive":
                    $displayed_message = "Account is inactive.";
                    break;
                case "notexist":
                    $displayed_message = "User account does not exist.";
                    break;
                default:
                    $displayed_message = "Internal error, please try again.";
                    break;
            }
        }
        if ($displayed_message == "")
            $displayed_message = 'Unknown login error, please try again.';
    ?>
</head>
<body>
    <div class="wrap">
        <div class="avatar">
            <a href="index.php""><img src="loginerror.png"></a>
        </div>
        <input type="texttitle" name="reason" placeholder="Failed Login" required disabled>
        <?php echo '<input type="textdescript" name="inputedpword" placeholder="' . $displayed_message . '" required disabled>'; ?>
    </div>
</body>
</html>