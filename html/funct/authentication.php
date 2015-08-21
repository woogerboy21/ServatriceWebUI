<?php

    //TODO: ADD PRETTY AUTHENTICATION IN PROGRESS / FAILED SCREEN
    require 'useraccount_functions.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $inputed_username = trim($_POST["inputeduname"]);
        $inputed_password = trim($_POST["inputedpword"]);

        if (empty($inputed_username) || empty($inputed_password))
            header('Location: ../failedlogin.php?error=blankinfo');

        $account_active = get_user_data($inputed_username, "active");
        if ($account_active)
        {
            $user_db_password = get_user_data($inputed_username, "password_sha512");
            if (!empty($user_db_password))
            {
                $userSalt = trim(substr($user_db_password, 0, 16));
                $inputed_PasswordHash = crypt_password($inputed_password, $userSalt);
                if (empty($inputed_PasswordHash))
                    header('Location: ../failedlogin.php?error=internal');

                if (trim($user_db_password) != trim($inputed_PasswordHash))
                    header('Location: ../failedlogin.php?error=invalidcred');
            }

            session_start();
            $_SESSION['username'] = $inputed_username;
            $_SESSION['timeout'] = 300;
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
                header('Location: ../failedlogin.php?error=notprivileged');
            }
        }
        else
        {
            $does_user_exist = check_if_user_exists($inputed_username);
            if ($does_user_exist)
                header('Location: ../failedlogin.php?error=inactive');
            else
                header('Location: ../failedlogin.php?error=notexist');
        }
    }
?>
