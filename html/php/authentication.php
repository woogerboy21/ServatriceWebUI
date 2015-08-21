<?php

    //TODO: ADD PRETTY AUTHENTICATION IN PROGRESS / FAILED SCREEN
    require 'useraccount_functions.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $inputed_username = trim($_POST["inputeduname"]);
        $inputed_password = trim($_POST["inputedpword"]);

        if (empty($inputed_username) || empty($inputed_password))
            die("<center>username or password can not be blank, please try again</center>");

        $account_active = get_user_data($inputed_username, "active");
        if ($account_active)
        {
            $user_db_password = get_user_data($inputed_username, "password_sha512");
            if (!empty($user_db_password))
            {
                $userSalt = trim(substr($user_db_password, 0, 16));
                $inputed_PasswordHash = crypt_password($inputed_password, $userSalt);
                if (empty($inputed_PasswordHash))
                    die("<center>failed, unable to encrypt user password</center>");

                if (trim($user_db_password) != trim($inputed_PasswordHash))
                    die("<center>incorrect password, please try again</center>");
            }

            session_start();
            $_SESSION['username'] = $inputed_username;
            $_SESSION['timeout'] = 300;
            $_SESSION['start'] = time();

            $user_level_rank = get_user_data($inputed_username, "admin");
            switch ($user_level_rank)
            {
                case 0: $_SESSION['user_level_rank'] = 'user'; break;
                case 1: $_SESSION['user_level_rank'] = 'admin'; break;
                case 2: $_SESSION['user_level_rank'] = 'moderator'; break;
                default: break;
            }

            if (strcasecmp($_SESSION['user_level_rank'], "user") == 0)
            {
                $redirect_location = $_POST['redirect'];
                (strlen($redirect_location) > 0) ? header("Location: $redirect_location") : header('Location: ../adminportal.html');

            }
            else
            {
                die("<center> You must be a moderator or admin to log in</center>");
            }
        }
        else
        {
            $does_user_exist = check_if_user_exists($inputed_username);
            if ($does_user_exist)
                echo '<center>User account has not been activated yet.<br>Please follow the instructions sent to you after registration to enable your account.<br>Please <a href="http://www.woogerworks.com/index.php/let-us-know">contact us</a> for assistance</center>';
            else
                echo '<center>Account does not exist for username (' . $inputed_username . ')<br>Please try again<center>';
        }
    }
?>
