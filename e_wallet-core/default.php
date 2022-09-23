<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_username.php";

$profile = get_profile($_SESSION["username"]);
require_once "../general/get_profile.php";

$account_inform = get_account_inform($_SESSION["username"]);
$balance = $account_inform["Balance"];
$status = $account_inform["VerifiedStatus"];

$card_num = "";
$date_expire = "";
$cvv = "";
$deposit_money = "";

if (isset($_POST["card-num"]) && isset($_POST["date-expire"]) && isset($_POST["cvv"]) && isset($_POST["deposit-money"])) {
	$card_num = $_POST["card-num"];
	$date_expire = $_POST["date-expire"];
	$cvv = $_POST["cvv"];
	$deposit_money = $_POST["deposit-money"];

	if (!preg_match("/^[0-9]{1,6}$/", $card_num)) {
		$result = 'Card number must be digits';
	} else if (!preg_match("/^[0-9]{1,3}$/", $cvv)) {
		$result = 'CVV must be digits';
	} else if (!preg_match("/^[0-9]*$/", $deposit_money)) {
		$result = 'Invalid money';
	} else if (gettype(check_cc($card_num, $date_expire, $cvv, $deposit_money)) != "boolean") {
		$result = check_cc($card_num, $date_expire, $cvv, $deposit_money);
	} else {
		$result = deposit($_SESSION["username"], $card_num, $deposit_money);

		if (str_contains($result, "successfully")) {
			$_SESSION["message"] = $result;

			header("Location: default.php");
			exit();
		}
	}
}
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
						<a href="default.php" class="btn navi__item-2" id="home">
							<i class="fa-solid fa-house"></i> Home
						</a>
					</li>
					<li class="navi__item-1">
						<a href="withdrawal.php" class="btn navi__item-2" id="withdraw">
							<i class="fa-solid fa-money-bill"></i> Withdrawal
						</a>
					</li>
					<li class="navi__item-1">
						<a href="transfer.php" class="btn navi__item-2">
							<i class="fa-solid fa-money-bill-transfer"></i> Transfer money
						</a>
					</li>
					<li class="navi__item-1">
						<a href="buy_phone_card.php" class="btn navi__item-2">
							<i class="fa-solid fa-pager"></i> Buy phone card
						</a>
					</li>
					<li class="navi__item-1">
						<a href="transaction_history.php" class="btn navi__item-2">
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
									<i class="fa-solid fa-user mr-3"></i><?= $name ?>
								</div>
								<div class="phone-number" id="infor-phone">
									<i class="fa-solid fa-phone mr-3 mt-4"></i><?= $phone ?>
								</div>
								<div class="phone-mail" id="infor-mail">
									<i class="fa-solid fa-envelope mr-3 mt-4"></i><?= $email ?>
								</div>
								<div class="phone-address" id="infor-address">
									<i class="fa-solid fa-location-dot mr-3 mt-4"></i><?= $address ?>
								</div>
								<div class="phone-birthday" id="infor-birthday">
									<i class="fa-solid fa-cake-candles mr-3 mt-4"></i><?= $birth_day ?>
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
							<?= number_format($balance) . " VND" ?>
							<button type="button" class="top-money" data-toggle="modal" data-target="#addRecharge">
								<i class="fa-solid fa-circle-plus"></i>
							</button>
						</h3>
						<div class="content__recharge-infor mt-5">
							<h2>Account status</h2>
							<h4 class="text-success"><?= $status ?></h4>
							<button data-toggle="modal" data-target="#infor" class="text-center btn btn-info mb-2 mt-2">
								See basic information
							</button>
						</div>
					</div>
					<!-- Modal -->
					<div class="modal fade" id="addRecharge" tabindex="-1" role="dialog" aria-labelledby="addRechargeLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<form novalidate action="" method="post" onsubmit="return checkCC()">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-infor text-dark" id="addRechargeLabel">
											Deposit money from credit card
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<img class="mb-3" src="../images/cc.jpg" width="465px" height="250px" alt="" />
										<div class="form-group text-dark">
											<label for="card-num">Card number</label>
											<input name="card-num" id="card-num" type="text" class="form-control" placeholder="6 digit" />
										</div>
										<div class="form-group text-dark">
											<label for="date-expire">Date Expiration</label>
											<input name="date-expire" id="date-expire" type="date" class="form-control" />
										</div>
										<div class="form-group text-dark">
											<label for="cvv">CVV Code</label>
											<input name="cvv" id="cvv" type="text" class="form-control" placeholder="3 digit" />
										</div>
										<div class="form-group text-dark">
											<label for="deposit-money">Deposit money</label>
											<input name="deposit-money" id="deposit-money" type="text" class="form-control" placeholder="Enter your money" />
										</div>
										<div class="text-danger text-center mt-1 mb-1 d-none" id="error-message">Please enter your card number</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">
											Close
										</button>
										<button type="submit" class="btn btn-success">Agree</button>
									</div>
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
	<script src="../main.js"></script>
	<?php
	if (isset($result)) {
		echo "<script>alert('" . $result . "')</script>";
	}

	if (isset($_SESSION["message"])) {
		echo "<script>alert('" . $_SESSION["message"] . "')</script>";
		unset($_SESSION["message"]);
	}
	?>
</body>

</html>