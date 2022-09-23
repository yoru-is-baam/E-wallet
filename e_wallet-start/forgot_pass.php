<?php
session_start();

require_once "../db/account_db.php";

$email = "";
$phone = "";

if (isset($_POST["email"]) && isset($_POST["phone"])) {
	$email = $_POST["email"];
	$phone = $_POST["phone"];

	if (empty($email)) {
		$result = "Please enter your email.";
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = "This is not a valid email address.";
	} else if (empty($phone)) {
		$result = "Please enter your phone number.";
	} else if (!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $phone)) {
		$result = "This is not a valid phone number.";
	} else {
		$result = check_email_phone($email, $phone);

		if (gettype($result) == "boolean") {
			$_SESSION["email"] = $email;

			header("Location: change_with_otp.php");
			exit();
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Reset user password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-5">
				<h3 class="text-center text-primary mt-5 mb-3">Reset Password</h3>
				<form novalidate onsubmit="return checkMailAndPhone()" method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
					<div class="form-group">
						<label for="email">Email</label>
						<input name="email" id="email" type="text" class="form-control" placeholder="Email address">
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input name="phone" id="phone" type="text" class="form-control" placeholder="Phone Number">
					</div>
					<div class="text-danger text-center mb-3 d-none" id="error-message">Please enter your email</div>
					<?php
					if (isset($result)) {
						echo '<div class="text-danger text-center mb-3">' . $result . '</div>';
					}
					?>
					<div class="form-group text-center">
						<button class="btn btn-success px-5" type="submit">Reset password</button>
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