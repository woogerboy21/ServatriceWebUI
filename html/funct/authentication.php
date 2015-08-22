<?php

    GLOBAL $config_file;
    require 'useraccount_functions.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $inputed_username = trim($_POST["inputeduname"]);
        $inputed_password = trim($_POST["inputedpword"]);

        if (empty($inputed_username) || empty($inputed_password))
            die(header('Location: ../errorpage.php?source=authentication&error=blankinfo'));

        $account_active = get_user_data($inputed_username, "active");

        if ($account_active)
        {
            $user_db_password = get_user_data($inputed_username, "password_sha512");
            if (!empty($user_db_password))
            {
                $user_salt = trim(substr($user_db_password, 0, 16));
                $inputed_password_hash = crypt_password($inputed_password, $user_salt);

                if (empty($inputed_password_hash))
                    die(header('Location: ../errorpage.php?source=authentication&error=internal'));

                if (trim($user_db_password) != trim($inputed_password_hash))
                    die(header('Location: ../errorpage.php?source=authentication&error=invalidcred'));
            }

            session_start();
            $_SESSION['username'] = $inputed_username;
            $_SESSION['timeout'] = get_config_value($config_file, 'sessiontimeout');
            $_SESSION['start'] = time();

            $user_level_rank = get_user_data($inputed_username, "admin");
            switch ($user_level_rank)
            {
                case 0: $_SESSION['userlevelrank'] = 'user'; break;
                case 1: $_SESSION['userlevelrank'] = 'admin'; break;
                case 2: $_SESSION['userlevelrank'] = 'moderator'; break;
                default: break;
            }

            if ($_SESSION['userlevelrank'] != 'user')
            {
                $redirect_location = $_POST['redirect'];
                (strlen($redirect_location) > 0) ? header("Location: $redirect_location") : header('Location: ../adminportal.php');

            }
            else
            {
                die(header('Location: ../errorpage.php?source=authentication&error=notprivileged'));
            }
        }
        else
        {
            $does_user_exist = check_if_user_exists($inputed_username);
            if ($does_user_exist)
                die(header('Location: ../errorpage.php?source=authentication&error=inactive'));
            else
                die(header('Location: ../errorpage.php?source=authentication&error=notexist'));
        }
    }
?>