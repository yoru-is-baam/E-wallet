<?php
session_start();

require_once "../db/admin_db.php";
require_once "../general/check_username.php";

$pending_accounts = get_pending_account();
$verified_accounts = get_activated_account();
$locked_accounts = get_locked_account();
$disabled_accounts = get_disabled_account();
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
	<div class="admin">
		<h2 class="text-center mt-3 mb-3">Admin System</h2>
		<a href="../e_wallet-start/logout.php" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left"></i> Log out</a>
		<div class="row">
			<div class="col-lg-2">
				<table class="table admin-system text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Waiting account</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($pending_accounts as $pending_account) {
							$username = $pending_account["Username"];
						?>
							<tr>
								<td><?= '<a href="waiting_display.php?username=' . $username . '"class="btn">' . $username . '</a>' ?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-lg-2">
				<table class="table admin-system text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Activated account</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($verified_accounts as $verified_account) {
							$username = $verified_account["Username"];
						?>
							<tr>
								<td><?= '<a href="activated_display.php?username=' . $username . '"class="btn">' . $username . '</a>' ?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-lg-2">
				<table class="table admin-system text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Locked indefinitely account</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($locked_accounts as $locked_account) {
							$username = $locked_account["Username"];
						?>
							<tr>
								<td><?= '<a href="locked_display.php?username=' . $username . '"class="btn">' . $username . '</a>' ?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-lg-2">
				<table class="table admin-system text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Withdraws over 5M</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<a href="withdraw_over_5m.html" class="btn">Jack</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-lg-2">
				<table class="table admin-system text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Transfer over 5M</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<a href="transfer_over_5m.html" class="btn">Jack</a>
							</td>

						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-lg-2">
				<table class="table admin-system text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Disabled account</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($disabled_accounts as $disabled_account) {
							$username = $disabled_account["Username"];
						?>
							<tr>
								<td><?= '<a class="btn">' . $username . '</a>' ?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>