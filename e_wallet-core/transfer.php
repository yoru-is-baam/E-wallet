<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_set_username.php";

$phone = "";
$money_transfer = "";
$note = "";
$fee = "";

if (isset($_POST["phone"]) && isset($_POST["money-transfer"]) && isset($_POST["pay-fee"])) {
	$phone = $_POST["phone"];
	$money_transfer = $_POST["money-transfer"];
	$note = isset($_POST["note"]) ? $_POST["note"] : " ";
	$fee = $_POST["pay-fee"];

	if (!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $phone)) {
		$result = "You have entered an invalid phone number!";
	} else if (empty($money_transfer)) {
		$result = "Money can not be empty";
	} else if (!preg_match("/^[0-9]*$/", $money_transfer)) {
		$result = "Invalid money";
	} else if (gettype(get_name($phone)) == "boolean") {
		$result = "This user doesn't register e-wallet";
	} else {
		$_SESSION["phone"] = $phone;
		$_SESSION["fee"] = $fee;
		$_SESSION["money"] = $money_transfer;
		$_SESSION["note"] = $note;

		header("Location: view_information.php");
		exit();
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
				<div class="content">
					<!-- Transfer money -->
					<div class="content__transfer">
						<h2>Transfer money</h2>
						<form novalidate method="post" onsubmit="return checkTransfer()">
							<input type="text" name="phone" id="phone" placeholder="Phone number" />
							<input class="mt-3" type="text" name="money-transfer" id="money-transfer" placeholder="Amount of money" />
							<div class="form-group mt-4 mb-0 text-left">
								<textarea class="form-control" placeholder="Note..." id="note" rows="3"></textarea>
							</div>
							<div class="form-inline mt-3 justify-content-center">
								<div class="pay__fee">Who pay the fee?</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="pay-fee" id="sender" value="sender" checked />
									<label class="form-check-label" for="sender">
										Sender
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="pay-fee" id="receiver" value="receiver" />
									<label class="form-check-label" for="receiver">
										Receiver
									</label>
								</div>
							</div>
							<div class="text-danger text-center mt-4 d-none" id="error-message">Please enter your number</div>
							<?php
							if (isset($result)) {
								echo '<div class="text-danger text-center mt-4">' . $result . '</div>';
							}
							?>
							<button type="submit" class="btn text-light">Submit</button>
						</form>
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
	<script src="../main.js"></script>
</body>

</html>