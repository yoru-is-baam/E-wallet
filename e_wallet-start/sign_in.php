<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_username.php";

$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["username"]) && isset($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];

		if (empty($username)) {
			$result = "Please enter your username";
		} else if (empty($password)) {
			$result = "Please enter your password";
		} else if (strlen($username) < 10) {
			$result = "Username must have at least 10 characters";
		} else if (strlen($password) < 6) {
			$result = "Password must have at least 6 characters";
		} else if ($username == "administrator" && $password == "admin2022") {
			$_SESSION["username"] = "admin";

			header("Location: ../admin/admin_system.php");
			exit();
		} else if (login($username, $password) == "verified") {
			$_SESSION["username"] = $username;

			// check error time
			if (get_account_inform($username)["ErrorTime"] >= 6 && get_account_inform($username)["LoginStatus"] == "abnormal login") {
				unset($_SESSION["username"]);
				$result = 'Account has been locked due to entering the wrong password many times, please contact the administrator for support';
			} else if (get_account_inform($username)["ErrorTime"] >= 3 && get_account_inform($username)["LockedTime"] != "0") {
				if (time() - ((int) get_account_inform($username)["LockedTime"]) > 60) {
					reset_login_status($username);
					reset_error_time($username);
					reset_locked_time($username);

					header("Location: ../e_wallet-core/default.php");
					exit();
				} else {
					unset($_SESSION["username"]);
					$result = "Account is currently locked, please try again in 1 minute";
				}
			} else {
				reset_error_time($username);

				header("Location: ../e_wallet-core/default.php");
				exit();
			}
		} else if (login($username, $password) == "Login for the first time") {
			$_SESSION["username"] = $username;

			// check error time
			if (get_account_inform($username)["ErrorTime"] >= 6 && get_account_inform($username)["LoginStatus"] == "abnormal login") {
				unset($_SESSION["username"]);
				$result = 'Account has been locked due to entering the wrong password many times, please contact the administrator for support';
			} else if (get_account_inform($username)["ErrorTime"] >= 3 && get_account_inform($username)["LockedTime"] != "0") {
				if (time() - ((int) get_account_inform($username)["LockedTime"]) > 60) {
					reset_login_status($username);
					reset_error_time($username);
					reset_locked_time($username);

					header("Location: ../e_wallet-start/change_with_otp.php");
					exit();
				} else {
					unset($_SESSION["username"]);
					$result = "Account is currently locked, please try again in 1 minute";
				}
			} else {
				reset_error_time($username);

				header("Location: ../e_wallet-start/change_with_otp.php");
				exit();
			}
		} else if (login($username, $password) == "Pending verification") {
			$_SESSION["username"] = $username;

			// check error time
			if (get_account_inform($username)["ErrorTime"] >= 6 && get_account_inform($username)["LoginStatus"] == "abnormal login") {
				unset($_SESSION["username"]);
				$result = 'Account has been locked due to entering the wrong password many times, please contact the administrator for support';
			} else if (get_account_inform($username)["ErrorTime"] >= 3 && get_account_inform($username)["LockedTime"] != "0") {
				if (time() - ((int) get_account_inform($username)["LockedTime"]) > 60) {
					reset_login_status($username);
					reset_error_time($username);
					reset_locked_time($username);

					header("Location: ../e_wallet-core/not_verify_account.php");
					exit();
				} else {
					unset($_SESSION["username"]);
					$result = "Account is currently locked, please try again in 1 minute";
				}
			} else {
				reset_error_time($username);

				header("Location: ../e_wallet-core/not_verify_account.php");
				exit();
			}
		} else if (login($username, $password) == "waiting for updates") {
			$_SESSION["username"] = $username;
			$_SESSION["message"] = "Please upload your id again";

			// check error time
			if (get_account_inform($username)["ErrorTime"] >= 6 && get_account_inform($username)["LoginStatus"] == "abnormal login") {
				unset($_SESSION["username"]);
				$result = 'Account has been locked due to entering the wrong password many times, please contact the administrator for support';
			} else if (get_account_inform($username)["ErrorTime"] >= 3 && get_account_inform($username)["LockedTime"] != "0") {
				if (time() - ((int) get_account_inform($username)["LockedTime"]) > 60) {
					reset_login_status($username);
					reset_error_time($username);
					reset_locked_time($username);

					header("Location: ../e_wallet-core/update_id.php");
					exit();
				} else {
					unset($_SESSION["username"]);
					$result = "Account is currently locked, please try again in 1 minute";
				}
			} else {
				reset_error_time($username);

				header("Location: ../e_wallet-core/update_id.php");
				exit();
			}
		} else if (login($username, $password) == "disabled") {
			$result = "This account has been disabled, please contact the hotline 18001008";
		} else {
			$result = login($username, $password);

			if ($result == "Wrong password") {
				if (get_account_inform($username)["ErrorTime"] >= 6 && get_account_inform($username)["LoginStatus"] == "abnormal login") {
					$result = 'Account has been locked due to entering the wrong password many times, please contact the administrator for support';
				} else if (get_account_inform($username)["ErrorTime"] >= 3 && get_account_inform($username)["LockedTime"] != "0") {
					if (time() - (int) get_account_inform($username)["LockedTime"] > 60) {
						update_error_time($username);
					} else {
						$result = "Account is currently locked, please try again in 1 minute";
					}
				} else if (get_account_inform($username)["ErrorTime"] == 3) {
					$result = "Account is currently locked, please try again in 1 minute";

					update_login_status($username);
					update_locked_time($username, (string) time());
				} else {
					update_error_time($username);
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sign In</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<h3 class="mt-5 mb-3 text-center text-primary">User Login</h3>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<form novalidate onsubmit="return checkSignIn()" id="form" class="border p-3 rounded bg-light" action="" method="post">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?= $username ?>">
					</div>
					<div class="form-group">
						<label for="pwd">Password</label>
						<input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" value="<?= $password ?>">
					</div>
					<div class="text-danger text-center mt-1 mb-3 d-none" id="error-message">Please enter your username</div>
					<?php
					if (isset($result)) {
						echo '<div class="text-danger text-center mt-1 mb-3">' . $result . '</div>';
					}
					?>
					<?php
					if (isset($_SESSION["message"])) {
						if (str_contains($_SESSION["message"], "disabled")) {
							echo '<div class="text-danger text-center mt-1 mb-3">' . $_SESSION["message"] . '</div>';
						} else {
							echo '<div class="text-success text-center mt-1 mb-3">' . $_SESSION["message"] . '</div>';
						}

						unset($_SESSION["message"]);
					}
					?>
					<div class="submit text-center">
						<button class="btn btn-primary btn-block mb-3" id="sign-in" type="submit" class="btn btn-default">
							Sign in
						</button>
						<a href="forgot_pass.php">Forgot your password?</a>
						<hr>
						<a href="sign_up.php" class="btn btn-success mt-2 mb-2" type="submit">Create an account</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script>
</body>

</html>