<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

require_once "../general/get_profile.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Activated User</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
	<style>
		.center {
			width: 20px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container">
		<h2 class="text-center mt-2">User Information</h2>
		<div class="row justify-content-center">
			<div class="col-lg-6 border p-3 rounded bg-light mb-3">
				<a href="admin_system.php" class="btn btn-light" type="submit"><i class="fa-solid fa-arrow-left"></i> Go back
				</a>
				<div class="text-center mb-5 mt-5">
					<img src="../images/user.jpg" width="300px" alt="user" />
				</div>

				<h5 class="mt-2 ml-4">
					<i class="fa-solid fa-circle-dot mr-3 center"></i>Activated account
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-user mr-3 center"></i><?= $name ?>
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-cake-candles mr-3 center"></i><?= $birth_day ?>
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-envelope mr-3 center"></i><?= $email ?>
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-location-pin mr-3 center"></i><?= $address ?>
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-phone mr-3 center"></i><?= $phone ?>
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-image mr-3 center"></i>
					<img src="<?= $id_front ?>" alt="id-front" width="350px">
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-image mr-3 center"></i>
					<img src="<?= $id_back ?>" alt="id-back" width="350px">
				</h5>
				<h5 class="mt-5 ml-4">
					<i class="fa-solid fa-money-bill-transfer mr-3 center"></i><a href="recent_transaction.php">Recent transactions</a>
				</h5>
			</div>
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>