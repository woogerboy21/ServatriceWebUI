<?php

	//TODO: ADD PRETTY AUTHENTICATION IN PROGRESS / FAILED SCREEN
	require 'useraccount_functions.php';

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$inputedusername = trim($_POST["inputeduname"]);
		$inputedpassword = trim($_POST["inputedpword"]);
		if (empty($inputedusername) || empty($inputedpassword)) { echo "<center>username or password can not be blank, please try again</center>"; exit;}
		$accountactive = get_user_data($inputedusername, "active");
		if ($accountactive) {
			$userdbpassword = get_user_data($inputedusername, "password_sha512");
			if (!empty($userdbpassword)) {
				$userssalt = trim(substr($userdbpassword, 0, 16));
				$inputedpasswordhash = crypt_password($inputedpassword, $userssalt);
				if (empty($inputedpasswordhash)) {
					echo "<center>failed, unable to encrypt user password</center>";
					exit;
				}

				if (trim($userdbpassword) != trim($inputedpasswordhash)) {
					echo "<center>incorrect password, please try again</center>";
					exit;
				}
			}

			$userlevel = get_user_data($inputedusername, "admin");
			session_start();
			$_SESSION['username'] = $inputedusername;
			$_SESSION['timeout'] = 300;
			$_SESSION['start'] = time();
			switch ($userlevel){
				case 0: $_SESSION['userlevel'] = 'user'; break;
				case 1: $_SESSION['userlevel'] = 'admin'; break;
				case 2: $_SESSION['userlevel'] = 'moderator'; break;
				default:
			}

			if (strtolower(['userlevel']) != strtolower('user')) {
				$redirect_location = $_POST['redirect'];
				if (strlen($redirect_location) > 0) { header("Location: $redirect_location"); } else { header('Location: ../adminportal.html'); }
			} else {
				echo "<center> You must be a moderator or admin to log in</center>"; exit;
			}
		} else {
			$doesuserexist = check_if_user_exists($inputedusername);
			if ($doesuserexist){
				echo '<center>User account has not been activated yet.<br>Please follow the instructions sent to you after registration to enable your account.<br>Please <a href="http://www.woogerworks.com/index.php/let-us-know">contact us</a> for assistance</center>';
			} else {
				echo '<center>Account does not exist for username (' . $inputedusername . ')<br>Please try again<center>';
			}
		}
	}
?>
