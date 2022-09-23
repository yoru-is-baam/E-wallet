<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

$old_pass = "";
$new_pass = "";
$pass_confirm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["old-pass"]) && isset($_POST["new-pass"]) && isset($_POST["pass-confirm"])) {
		$old_pass = $_POST["old-pass"];
		$new_pass = $_POST["new-pass"];
		$pass_confirm = $_POST["pass-confirm"];

		if (empty($old_pass)) {
			$result = "Please enter your old password";
		} else if (empty($new_pass)) {
			$result = "Please enter your new password";
		} else if (empty($pass_confirm)) {
			$result = "Please enter your confirm password";
		} else if (strlen($old_pass) < 6) {
			$result = "Your old password must be at least 6 characters";
		} else if (strlen($new_pass) < 6) {
			$result = "Your new password must be at least 6 characters";
		} else if (!preg_match("/[a-z]/i", $new_pass)) {
			$result = "Your password must contain at least one letter";
		} else if (!preg_match("/\d/", $new_pass)) {
			$result = "Your password must contain at least one digit";
		} else if ($new_pass != $pass_confirm) {
			$result = "Password doesn't match";
		} else {
			$result = change_old_password($_SESSION["username"], $old_pass, $new_pass);

			if (gettype($result) == "boolean") {
				header("Location: ../e_wallet-core/default.php");
				exit();
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Change user password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-5">
				<h3 class="text-center text-primary mt-5 mb-3">Change Password</h3>
				<form novalidate method="post" action="" onsubmit="return checkOldAndNew()" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
					<div class="form-group">
						<label for="old-pass">Old password</label>
						<input name="old-pass" id="old-pass" type="password" class="form-control">
					</div>
					<div class="form-group">
						<label for="new-pass">New Password</label>
						<input value="" name="new-pass" required class="form-control" type="password" id="new-pass">
					</div>
					<div class="form-group">
						<label for="pass-confirm">Confirm Password</label>
						<input value="" name="pass-confirm" required class="form-control" type="password" id="pass-confirm">
					</div>
					<div class="text-danger text-center mt-1 mb-3 d-none" id="error-message">Please enter your password</div>
					<?php
					if (isset($result)) {
						echo '<div class="text-danger text-center mt-1 mb-3">' . $result . '</div>';
					}
					?>
					<div class="form-group text-center">
						<button class="btn btn-success px-5" type="submit">Change password</button>
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