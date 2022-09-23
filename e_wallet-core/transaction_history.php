<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

$deposit = count_deposit($_SESSION["username"]);
$transfer = count_transfer($_SESSION["username"]);
$withdrawal = count_withdrawal($_SESSION["username"]);
$buy = count_buy($_SESSION["username"]);
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
						<a href="withdrawal.php" class="navi__item-2 btn" type="submit">
							<i class="fa-solid fa-money-bill"></i>
							Withdraw
						</a>
					</li>
					<li class="navi__item-1">
						<a href="transfer.php" class="navi__item-2 btn" type="submit">
							<i class="fa-solid fa-money-bill-transfer"></i> Transfer
							money</a>
					</li>
					<li class="navi__item-1">
						<a href="buy_phone_card.php" class="navi__item-2 btn" type="submit"><i class="fa-solid fa-pager"></i> Buy phone card
						</a>
					</li>
					<li class="navi__item-1">
						<a href="transaction_history.php" class="navi__item-2 btn" type="submit"><i class="fa-solid fa-clock-rotate-left"></i> Transaction
							history
						</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-9">
				<div class="content">
					<!-- Transaction History -->
					<div class="content__history text-center align-items-center">
						<h2 class="text-center text-light">
							Your transaction history
						</h2>
						<table class="table text-light">
							<thead class="thead-light">
								<tr>
									<th scope="col">Transaction type</th>
									<th scope="col">Total transaction</th>
									<th scope="col">See detail</th>
								</tr>
							</thead>
							<tbody>
								<tr class="withdrawal">
									<td>Withdraw</td>
									<td><?= $withdrawal ?></td>
									<td>
										<a href="withdrawal_history_detail.php" class="btn text-light" type="submit">Detail information</a>
									</td>
								</tr>
								<tr class="transfer">
									<td>Transfer</td>
									<td><?= $transfer ?></td>
									<td>
										<a href="transfer_history_detail.php" class="btn text-light" type="submit">Detail information</a>
									</td>
								</tr>
								<tr class="buy-phone-card">
									<td>Buy phone card</td>
									<td><?= $buy ?></td>
									<td>
										<a href="card_infor.php" class="btn text-light" type="submit">Detail information</a>
									</td>
								</tr>
								<tr class="deposit">
									<td>Deposit</td>
									<td><?= $deposit ?></td>
									<td>
										<a href="deposit_history.php" class="btn text-light" type="submit">Detail information</a>
									</td>
								</tr>
							</tbody>
						</table>
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
				<a class="btn responsive__item-2">
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