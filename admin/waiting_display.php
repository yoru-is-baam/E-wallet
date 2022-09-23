<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

if (isset($_GET["username"]) && isset($_GET["status"])) {
	verified_account($_GET["username"], $_GET["status"]);

	header("Location: admin_system.php");
	exit();
}

require_once "../general/get_profile.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Waiting User</title>
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
			<div class="col-md-6 border p-3 rounded bg-light mb-3">
				<a href="admin_system.php" class="btn btn-light" type="submit"><i class="fa-solid fa-arrow-left"></i> Go back
				</a>
				<div class="text-center mb-5 mt-5">
					<img src="../images/user.jpg" width="300px" alt="user" />
				</div>
				<h5 class="mt-2 ml-4">
					<i class="fa-solid fa-circle-dot mr-3 center"></i>Waiting for
					activation
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
				<div class="decision_verify text-center mt-4">
					<button data-toggle="modal" data-target="#verify" class="btn btn-success mt-2">
						Verify
					</button>
					<button data-toggle="modal" data-target="#cancel" class="btn btn-danger mt-2">
						Cancel
					</button>
					<button class="btn btn-primary mt-2 text-center" onclick="verifiedAccount(<?= $_GET['username'] ?>, 'waiting for updates')">
						Request additional information
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal verification -->
	<div class="modal fade" id="verify" tabindex="-1" role="dialog" aria-labelledby="verifyLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2>Do you want to verify this account?</h2>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						Disagree
					</button>
					<button type="button" class="btn btn-success" onclick="verifiedAccount(<?= $_GET['username'] ?>, 'verified')">Agree</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal cancel -->
	<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="cancelLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2>Do you want to cancel verification?</h2>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						Disagree
					</button>
					<button type="button" class="btn btn-success" onclick="verifiedAccount(<?= $_GET['username'] ?>, 'disabled')">Agree</button>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../main.js"></script>

</html>