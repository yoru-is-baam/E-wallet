<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

if (!isset($_SESSION["phone"])) {
	header("Location: transfer.php");
	exit();
}

$username = get_name($_SESSION["phone"])["Username"];


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
				<a class="dropdown-item" href="../e_wallet-start/reset_password.php"><i class="fa-solid fa-key mr-2"></i> Change password</a>
				<a class="dropdown-item" href="../e_wallet-start/logout.php"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout</a>
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
						<a href="default.php" class="navi__item-2 btn" type="submit"><i class="fa-solid fa-house"></i> Home</a>
					</li>
					<li class="navi__item-1">
						<a href="withdrawal.php" class="navi__item-2 btn" type="submit"> <i class="fa-solid fa-money-bill"></i>
							Withdraw
						</a>
					</li>
					<li class="navi__item-1">
						<a href="transfer.php" class="navi__item-2 btn" type="submit"> <i class="fa-solid fa-money-bill-transfer"></i> Transfer money</a>
					</li>
					<li class="navi__item-1">
						<a href="buy_phone_card.php" class="navi__item-2 btn" type="submit"><i class="fa-solid fa-pager"></i> Buy
							phone
							card</a>
					</li>
					<li class="navi__item-1">
						<a href="transaction_history.php" class="navi__item-2 btn" type="submit"><i class="fa-solid fa-clock-rotate-left"></i> Transaction history</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-9">
				<div class="container">
					<div class="row justify-content-center mt-5">
						<div class="col-md-6">
							<form novalidate onsubmit="return checkOtp()" method="post" class="border p-3 rounded bg-light" action="">
								<h5 class="mt-2 text-success">Please check email and enter your OTP code!</h5>
								<div class="form-group mt-4">
									<input type="text" class="form-control" id="otp" placeholder="Enter your OTP code" name="otp">
								</div>
								<div class="text-center">
									<button class="btn btn-success mt-2 mb-3" type="submit">Enter</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<ul class="responsive__list">
			<li class="responsive__item-1">
				<a href="default.php" class="btn responsive__item-2" id="home">
					<i class="fa-solid fa-house"></i> Home
				</a>
			</li>
			<li class="responsive__item-1">
				<a href="withdrawal.php" class="btn responsive__item-2" id="withdraw">
					<i class="fa-solid fa-money-bill"></i> Withdrawal
				</a>
			</li>
			<li class="responsive__item-1">
				<a href="transfer.php" class="btn responsive__item-2">
					<i class="fa-solid fa-money-bill-transfer"></i> Transfer money
				</a>
			</li>
			<li class="responsive__item-1">
				<a href="buy_phone_card.php" class="btn responsive__item-2">
					<i class="fa-solid fa-pager"></i> Buy phone card
				</a>
			</li>
			<li class="responsive__item-1">
				<a href="transaction_history.php" class="btn responsive__item-2">
					<i class="fa-solid fa-clock-rotate-left"></i> Transaction
					history
				</a>
			</li>
		</ul>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>