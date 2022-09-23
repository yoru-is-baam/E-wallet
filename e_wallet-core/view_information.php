<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

if (!isset($_SESSION["phone"])) {
	header("Location: transfer.php");
	exit();
}

$username = get_name($_SESSION["phone"])["FullName"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>My E-wallet</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
	<div class="container">
		<h3 class="mt-5 mb-3 text-center text-primary">Do you want to transfer this user?</h3>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" id="username" name="username" value="<?= $username ?>" readonly>
				</div>
				<div class="submit text-center">
					<a href="otp_transfer.php" class="btn btn-primary btn-block mb-3" class="btn btn-default">
						Ok
					</a>
					<a href="transfer.php" class="btn btn-warning btn-block mb-3" class="btn btn-default">
						Back
					</a>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>