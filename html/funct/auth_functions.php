<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == "GET")
    {
        if (!isset($_SESSION['username']))
            die(header('Location: errorpage.php?source=session&error=loginrequired'));

        if (isset($_SESSION['start']))
        {
            $sessionlife = time() - $_SESSION['start'];
            if ($sessionlife > $_SESSION['timeout'])
                die(header('Location: errorpage.php?source=session&error=sessiontimeout'));
            else
                $_SESSION['start'] = time();
        }
        else
        {
            die(header('Location: errorpage.php?source=session&error=lognrequired'));
        }

        if (!isset($_SESSION['userlevelrank']))
        {
            die(header('Location: errorpage.php?source=session&error=loginrequired'));
        }
        else
        {
            switch ($_SESSION['userlevelrank'])
            {
                case 'moderator':
                    if (strtolower($access_privlevel) == 'admin')
                        die(header('Location: errorpage.php?source=session&error=notprivileged'));
                    break;
                case 'user':
                    if (strtolower($access_privlevel) == 'moderator' || strtolower($access_privlevel) == 'admin')
                        die(header('Location: errorpage.php?source=session&error=notprivileged'));
                    break;
                default:
                    break;
            }
        }
    }
    else
    {
        die(header('Location: errorpage.php?souce=session'));
    }
?>