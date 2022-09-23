<?php
session_start();

if (!isset($_SESSION["email"]) && !isset($_SESSION["pass"])) {
	session_destroy();

	header("Location: sign_in.php");
	exit();
}

require_once "../db/account_db.php";

$username = get_username($_SESSION["email"]);
$password = $_SESSION["pass"];
$otp = "";

if (isset($_POST["otp"])) {
	$otp = $_POST["otp"];

	if (empty($otp)) {
		$result = "OTP must be at least 6 characters";
	} else if (strlen($otp) > 6 || strlen($otp) < 6) {
		$result = "OTP must be 6 characters";
	} else {
		$result = check_otp($username, $password, $otp);

		if (str_contains($result, "successfully")) {
			$_SESSION["message"] = $result;

			unset($_SESSION["email"]);
			unset($_SESSION["pass"]);

			header("Location: sign_in.php");
			exit();
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>OTP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<h3 class="mt-5 mb-3 text-center text-primary">OTP Code</h3>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<form class="border p-3 rounded bg-light" onsubmit="return checkOtp()" action="" method="POST">
					<div class="form-group mt-3">
						<input type="text" class="form-control" id="otp" placeholder="Enter your OTP code" name="otp">
					</div>
					<div class="text-danger text-center mb-2 d-none" id="error-message">Please enter your otp</div>
					<?php
					if (isset($result)) {
						echo '<div class="text-danger text-center mb-2">' . $result . '</div>';
					}

					if (isset($_SESSION["message"])) {
						echo '<div class="text-success text-center mb-2">' . $_SESSION["message"] . '</div>';

						unset($_SESSION["message"]);
					}
					?>
					<div class="text-center">
						<button class="btn btn-success mt-2 mb-2" type="submit">Reset</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>