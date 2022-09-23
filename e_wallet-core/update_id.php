<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_username.php";

$id_front = get_profile($_SESSION["username"])["IdPhotoFront"];
$id_back = get_profile($_SESSION["username"])["IdPhotoBack"];

$flag = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (file_exists($id_front)) {
		unlink($id_front);
		$flag = 1;
	}

	if (file_exists($id_back)) {
		unlink($id_back);
		$flag = 1;
	}

	$id_front = "";
	$id_back = "";

	if (isset($_FILES["id-front"]) && isset($_FILES["id-back"])) {
		$target = "../uploads/";

		$id_front = $target . change_name_id_front($_FILES["id-front"]["name"]);
		$id_back = $target . change_name_id_back($_FILES["id-back"]["name"]);

		if (
			!str_contains($_FILES["id-front"]["type"], "image")
			&& !str_contains($_FILES["id-back"]["type"], "image")
		) {
			$result = "Please uploads only JPG, PNG or GIF image!";
		} else {
			if (
				copy($_FILES["id-front"]["tmp_name"], $id_front)
				&& copy($_FILES["id-back"]["tmp_name"], $id_back)
			) {
				$result = update_id($_SESSION["username"], $id_front, $id_back);

				if ($result) {
					$result = "<script>alert('Please wait 5 minutes to verify and remember to reload')</script>";
				}
			}
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
	<title>Update ID card</title>
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
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropleft" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
						<a class="btn navi__item-2" id="home">
							<i class="fa-solid fa-house"></i> Home
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" id="withdraw" onclick="alertNotification()">
							<i class="fa-solid fa-money-bill"></i> Withdrawal
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" onclick="alertNotification()">
							<i class="fa-solid fa-money-bill-transfer"></i> Transfer money
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" onclick="alertNotification()">
							<i class="fa-solid fa-pager"></i> Buy phone card
						</a>
					</li>
					<li class="navi__item-1">
						<a class="btn navi__item-2" onclick="alertNotification()">
							<i class="fa-solid fa-clock-rotate-left"></i> Transaction
							history
						</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-9">
				<div class="content">
					<!-- Money interface and deposit -->
					<div class="content__ID bg-dark">
						<form novalidate onsubmit="return validateId()" action="" class="p-3" method="post" enctype="multipart/form-data">
							<h3>Please update your ID to use other services</h3>
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="id-front" name="id-front" onchange="showIdFrontName(this)" />
								<label class="id custom-file-label" for="id-front" data-browse="Front side">
									Select your front of ID card
								</label>
							</div>
							<div class="custom-file mt-2">
								<input type="file" class="custom-file-input" id="id-back" name="id-back" onchange="showIdBackName(this)" />
								<label class="id custom-file-label" for="id-back" data-browse="Back side">Select your back of ID card</label>
							</div>
							<div class="text-danger text-center mt-4 d-none" id="error-message">Please enter your name</div>
							<?php
							if (isset($result)) {
								echo '<div class="text-danger text-center mt-4">' . $result . '</div>';
							}
							?>
							<button class="btn btn-secondary btn-block mt-4" type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<ul class="responsive__list">
			<li class="responsive__item-1">
				<a class="btn responsive__item-2" id="home" onclick="alertNotification()">
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
					<i class="fa-solid fa-clock-rotate-left"></i> Transaction history
				</a>
			</li>
		</ul>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script>
	<?php
	if (isset($result) && $flag == 0) {
		echo $result;
	}

	if (isset($_SESSION["message"])) {
		echo "<script>alert('" . $_SESSION["message"] . "')</script>";
		unset($_SESSION["message"]);
	}
	?>
</body>

</html>