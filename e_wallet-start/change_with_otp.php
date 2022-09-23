<?php
session_start();

require_once "../db/account_db.php";

if (!isset($_SESSION["email"])) {
	require_once "../general/check_username.php";
	$username = "";
}


if (isset($_SESSION["username"])) {
	if (check_verification($_SESSION["username"]) == "Pending verification") {
		header("Location: ../e_wallet-core/not_verify_account.php");
		exit();
	}

	$username = $_SESSION["username"];
}

$pass = "";
$new_pass = "";

if (isset($_POST["pwd"]) && isset($_POST["pwd-confirm"])) {
	$pass = $_POST["pwd"];
	$new_pass = $_POST["pwd-confirm"];

	if (strlen($pass) < 6) {
		$result = "Your password must be at least 6 characters";
	} else if (!preg_match("/[a-z]/i", $pass)) {
		$result = "Your password must contain at least one letter";
	} else if (!preg_match("/\d/", $pass)) {
		$result = "Your password must contain at least one digit";
	} else if ($pass != $new_pass) {
		$result = "Password wasn't match";
	} else {
		if (isset($_SESSION["email"])) {
			$result = sendOtp($_SESSION["email"], "OTP Reset Password");

			if (str_contains($result, "sent")) {
				$_SESSION["pass"] = $new_pass;
				$_SESSION["message"] = $result;

				header("Location: ../e_wallet-start/type_otp.php");
				exit();
			}
		} else if (change_password($username, $pass) == "successfully") {
			header("Location: ../e_wallet-core/not_verify_account.php");
			exit();
		} else {
			$result = "Please try again";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Reset Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<h3 class="mt-5 mb-3 text-center text-primary">New Password</h3>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<form novalidate onsubmit="return checkChangeOtp()" class="border p-3 rounded bg-light" action="" method="post">
					<div class="form-group">
						<label for="pwd">New Password</label>
						<input type="password" class="form-control" id="pwd" placeholder="Enter new password" name="pwd" value="<?= $pass ?>">
					</div>
					<div class="form-group">
						<label for="pwd-confirm">Confirm Password</label>
						<input type="password" class="form-control" id="pwd-confirm" placeholder="Confirm password" name="pwd-confirm">
					</div>
					<div class="text-danger text-center mb-4 d-none" id="error-message">Please enter your password</div>
					<?php
					if (isset($result)) {
						echo '<div class="text-danger text-center mb-2">' . $result . '</div>';
					}
					?>
					<div class="text-center">
						<button class="btn btn-success mt-2 mb-2" type="submit">Create new password</button>
						<a href="logout.php" class="btn btn-danger mt-2 mb-2">Log out</a>
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