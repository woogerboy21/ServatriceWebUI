<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        if (!isset($_SESSION['username']))
        {
            header('Location: sessionerror.php?error=loginrequired');
        }

        if (isset($_SESSION['start']))
        {
            $sessionlife = time() - $_SESSION['start'];
            if ($sessionlife > $_SESSION['timeout'])
            {
                header('Location: sessionerror.php?error=sessiontimeout');
            } else {
                $_SESSION['start'] = time();
            }
        } else {
            header('Location: sessionerror.php?error=lognrequired');
        }

        if (!isset($_SESSION['userlevelrank']))
        {
            header('Location: sessionerror.php?error=loginrequired');
        } else {
            switch ($_SESSION['userlevelrank']){
                case 'moderator':
                    if (strtolower($access_privlevel) == 'admin')
                        header('Location: sessionerror.php?error=notprivileged');
                    break;
                case 'user':
                    if (strtolower($access_privlevel) == 'moderator' || strtolower($access_privlevel) == 'admin')
                        header('Location: sessionerror.php?error=notprivileged');
                    break;
                default:
                    break;
            }
        }
    } else {
        header('Location: sessionerror.php');
    }

?>
