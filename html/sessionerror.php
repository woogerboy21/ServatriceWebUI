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
                case "loginrequired":
                    $displayed_message = "Login required.";
                    break;
                case "sessiontimeout":
                    $displayed_message = "Session timeout.";
                    break;
                case "notprivilegedmod":
                    $displayed_message = "Moderator permissions required.";
                    break;
                case "notprivilegedadmin":
                    $displayed_message = "Admin permissions required.";
                    break;
                default:
                    break;
            }
        }
        if ($displayed_message == "")
            $displayed_message = 'Unknown session error, re-login.';
    ?>
</head>
<body>
    <div class="wrap">
        <div class="avatar">
            <a href="index.php""><img src="sessionerror.png"></a>
        </div>
        <input type="texttitle" name="reason" placeholder="Session Error" required disabled>
        <?php echo '<input type="textdescript" name="inputedpword" placeholder="' . $displayed_message . '" required disabled>'; ?>
    </div>
</body>
</html>