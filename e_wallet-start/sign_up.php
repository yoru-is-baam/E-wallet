<?php
session_start();

require_once "../db/account_db.php";
require_once "../general/check_username.php";

$_SESSION["message"] = "";

$name = "";
$email = "";
$phone = "";
$address = "";
$birth_day = "";
$id_front = "";
$id_back = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (
		isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["address"])
		&& isset($_POST["date"]) && isset($_FILES["id-front"]) && isset($_FILES["id-back"])
	) {
		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$address = $_POST["address"];
		$birth_day = $_POST["date"];

		$target = "../uploads/";

		$id_front = $target . change_name_id_front($_FILES["id-front"]["name"]);
		$id_back = $target . change_name_id_front($_FILES["id-back"]["name"]);

		if (empty($name)) {
			$result = "Please enter your name.";
		} else if (empty($email)) {
			$result = "Please enter your email.";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = "This is not a valid email address.";
		} else if (empty($phone)) {
			$result = "Please enter your phone number.";
		} else if (empty($address)) {
			$result = "Please enter your address.";
		} else if (
			!str_contains($_FILES["id-front"]["type"], "image")
			&& !str_contains($_FILES["id-back"]["type"], "image")
		) {
			$result = "Please uploads only JPG, PNG or GIF image!";
		} else {
			// register a new account
			if (
				copy($_FILES["id-front"]["tmp_name"], $id_front)
				&& copy($_FILES["id-back"]["tmp_name"], $id_back)
			) {
				$result = register($name, $email, $phone, $address, $birth_day, $id_front, $id_back);

				if (str_contains($result, "sent")) {
					$_SESSION["message"] = $result;

					header("Location: sign_in.php");
					exit();
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<h3 class="mt-4 mb-3 text-center text-primary">Sign Up</h3>
		<div class="row justify-content-center mt-3">
			<div class="col-md-6">
				<form novalidate onsubmit="return checkSignUp()" action="" class="border p-3 rounded bg-light mb-4" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Full Name</label>
						<input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= $name ?>">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?= $email ?>">
					</div>
					<div class="form-group">
						<label for="phone">Phone number</label>
						<input type="number" class="form-control" id="phone" placeholder="Enter number" name="phone" value="<?= $phone ?>">
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="<?= $address ?>">
					</div>
					<div class="form-group">
						<label for="birthday">Date Of Birth</label>
						<input type="date" name="date" id="birthday" class="form-control" value="<?= $birth_day ?>">
					</div>
					<hr>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="id-front" name="id-front" onchange="showIdFrontName(this)">
						<label class="id custom-file-label" for="id-front">Front of ID card</label>
					</div>
					<div class="custom-file mt-3 mb-4">
						<input type="file" class="custom-file-input" id="id-back" name="id-back" onchange="showIdBackName(this)" accept="image/gif, image/jpeg, image/png, image/jpg">
						<label class="id custom-file-label" for="id-back">Back of ID card</label>
					</div>
					<div class="text-danger text-center mb-4 d-none" id="error-message">Please enter your name</div>
					<?php
					if (isset($result)) {
						echo '<div class="text-danger text-center mb-4">' . $result . '</div>';
					}
					?>
					<div class="text-center">
						<button class="btn btn-primary btn-block" type="submit" class="btn btn-default">Sign Up</button>
						<a href="sign_in.php" class="btn btn-link mt-2" role="button">Already have an account?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script>
</body>

</html>