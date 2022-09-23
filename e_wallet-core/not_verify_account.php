<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_username.php";

$profile = get_profile($_SESSION["username"]);
require_once "../general/get_profile.php";

$account_inform = get_account_inform($_SESSION["username"]);
$balance = $account_inform["Balance"];
$status = $account_inform["VerifiedStatus"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Not Verify Account</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
	<link rel="stylesheet" href="../style.css" />
</head>

<body>
	<div class="header">
		<h1>E-WALLET</h1>
		<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa-solid fa-user text-light"></i>
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="../e_wallet-start/reset_password.php">
					<i class="fa-solid fa-key mr-2"></i> Change password</a>
				<a class="dropdown-item" href="../e_wallet-start/logout.php">
					<i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
				</a>
			</div>
		</div>
		<div class="dropleft">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropleftMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa-solid fa-user text-light"></i>
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="../e_wallet-start/reset_password.php"><i class="fa-solid fa-key mr-2"></i> Change password</a>
				<a class="dropdown-item" href="../e_wallet-start/logout.php"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout</a>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row navi">
			<div class="col-lg-3">
				<ul class="navi__list">
					<li class="navi__item-1">
						<a href="not_verify_account.php" class="btn navi__item-2" id="home">
							<i class="fa-solid fa-house"></i> Home
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" id="withdrawal" onclick="alertNotification()">
							<i class="fa-solid fa-money-bill"></i> Withdrawal
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" id="transfer" onclick="alertNotification()">
							<i class="fa-solid fa-money-bill-transfer"></i> Transfer money
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" id="phone-card" onclick="alertNotification()">
							<i class="fa-solid fa-pager"></i> Buy phone card
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" id="history" onclick="alertNotification()">
							<i class="fa-solid fa-clock-rotate-left"></i> Transaction
							history
						</a>
					</li>
				</ul>

				<!-- Modal information of user -->
				<div class="modal fade" id="infor" tabindex="-1" role="dialog" aria-labelledby="inforLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-infor text-dark" id="inforLabel">
									Your information
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body bg-dark text-light">
								<div class="name" id="infor-name">
									<i class="fa-solid fa-user mr-3"></i> <?= $name ?>
								</div>
								<div class="phone-number" id="infor-phone">
									<i class="fa-solid fa-phone mr-3 mt-4"></i> <?= $phone ?>
								</div>
								<div class="phone-mail" id="infor-mail">
									<i class="fa-solid fa-envelope mr-3 mt-4"></i>
									<?= $email ?>
								</div>
								<div class="phone-address" id="infor-address">
									<i class="fa-solid fa-location-dot mr-3 mt-4"></i> <?= $address ?>
								</div>
								<div class="phone-birthday" id="infor-birthday">
									<i class="fa-solid fa-cake-candles mr-3 mt-4"></i>
									<?= $birth_day ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-9">
				<div class="content">
					<!-- Money interface and deposit -->
					<div class="content__recharge bg-dark">
						<h2>Total Balance</h2>
						<h3>
							<?= $balance ?>
							<button type="button" class="top-money" data-toggle="modal" data-target="#addRecharge" id="deposit" onclick="alertNotification()">
								<i class="fa-solid fa-circle-plus"></i>
							</button>
						</h3>
						<div class="content__recharge-infor mt-5">
							<h2>Account status</h2>
							<h4 class="text-danger"><?= $status ?></h4>
							<button data-toggle="modal" data-target="#infor" class="text-center btn btn-info mb-2 mt-2">
								See basic information
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<ul class="responsive__list">
			<li class="responsive__item-1">
				<a href="not_verify_account.php" class="btn responsive__item-2" id="home">
					<i class="fa-solid fa-house"></i> Home
				</a>
			</li>
			<li class="responsive__item-1">
				<a class="btn responsive__item-2" id="withdraw" onclick="alertNotification()">
					<i class="fa-solid fa-money-bill"></i> Withdrawal
				</a>
			</li>
			<li class="responsive__item-1">
				<a class="btn responsive__item-2" onclick="alertNotification()">
					<i class="fa-solid fa-money-bill-transfer"></i> Transfer money
				</a>
			</li>
			<li class="responsive__item-1">
				<a class="btn responsive__item-2" onclick="alertNotification()">
					<i class="fa-solid fa-pager"></i> Buy phone card
				</a>
			</li>
			<li class="responsive__item-1">
				<a class="btn responsive__item-2" onclick="alertNotification()">
					<i class="fa-solid fa-clock-rotate-left"></i> Transaction
					history
				</a>
			</li>
		</ul>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script>
	<script>
		window.onload = function() {
			alert("Please wait 5 minutes. Administrator will verify you. Remember to reload page after 5 minutes");
		}
	</script>
</body>

</html>