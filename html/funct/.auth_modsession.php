<?php
    session_start();

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

    if (!isset($_SESSION['admin']))
    {
        header('Location: sessionerror.php?error=loginrequired');
    } else {
        if ($_SESSION['admin'] == 'user')
        {
            header('Location: sessionerror.php?error=notprivilegedmod');
        }
    }
?>
