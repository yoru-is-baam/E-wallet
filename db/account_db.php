<?php
require_once "db.php";
require_once "../lib/vendor/autoload.php";

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

function login($username, $password)
{
	$conn = create_connection();
	$sql = "select * from account where Username = ?";

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);

	if (!$stm->execute()) {
		return "Wrong username";
	}

	$result = $stm->get_result();

	if ($result->num_rows != 1) {
		return "Can't login, invalid username";
	}

	$data = $result->fetch_assoc();
	$hashed_pass = $data["Password"];
	$verified = $data["VerifiedStatus"];

	if (password_verify($password, $hashed_pass)) {
		return $verified;
	} else {
		return "Wrong password";
	}
}

function update_login_status($username)
{
	$sql = "update account set LoginStatus = 'abnormal login' where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();
}

function update_locked_time($username, $time)
{
	$sql = "update account set LockedTime = ? where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);

	$stm->bind_param("ss", $time, $username);
	$stm->execute();
}

function update_error_time($username)
{
	$sql = "update account set ErrorTime = ErrorTime + 1 where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();
}

function reset_login_status($username)
{
	$sql = "update account set LoginStatus = '0' where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();
}

function reset_error_time($username)
{
	$sql = "update account set ErrorTime = 0 where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();
}

function reset_locked_time($username)
{
	$sql = "update account set LockedTime = '0' where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();
}

function register($name, $email, $phone, $address, $birthDay, $idFront, $idBack)
{
	$sql = "select count(*) from customer where PhoneNumber = ? or Email = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("ss", $phone, $email);
	$stm->execute();

	$result = $stm->get_result();
	$exists = $result->fetch_array()[0] === 1;

	if ($exists) {
		return "Can't register because this phone number or email is already exists";
	}

	$username = check_username();
	$password = generate_pass();
	$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
	$otp = generate_otp();

	$sql = "insert into account (Username, Password, OTP) values (?, ?, ?)";

	$stm = $conn->prepare($sql);
	$stm->bind_param("sss", $username, $hashed_pass, $otp);

	if ($stm->execute()) {
		$stm->close();

		$sql = "insert into customer (PhoneNumber, Email, DateOfBirth, FullName, Address, IdPhotoFront, IdPhotoBack, Username) values (?, ?, ?, ?, ?, ?, ?, ?)";

		$stm = $conn->prepare($sql);
		$stm->bind_param(
			"ssssssss",
			$phone,
			$email,
			$birthDay,
			$name,
			$address,
			$idFront,
			$idBack,
			$username
		);

		if ($stm->execute()) {
			$stm->close();

			// "Username: $username<br>Password: $password"

			return sendAccount($username, $password, $email);
		}

		return $stm->error;
	}

	return $stm->error;
}

function sendAccount($username, $password, $email)
{
	global $adapter;
	require_once "../config.php";

	$arr_token = (array)get_access_token();

	try {
		$transport = Transport::fromDsn("gmail+smtp://" . urlencode('dtsamsung51@gmail.com')
			. ":" . urlencode($arr_token['access_token']) . "@default");

		$mailer = new Mailer($transport);

		$message = (new Email())
			->from("dtsamsung51@gmail.com")
			->to($email)
			->subject("E-wallet user's account")
			->html("<p>Username: $username</p><p>Password: $password</p>");

		$mailer->send($message);

		return "Account was sent for you. Please check your email.";
	} catch (Exception $e) {
		if (!$e->getCode()) {
			$refresh_token = get_refresh_token();

			$response = $adapter->refreshAccessToken([
				"grant_type" => "refresh_token",
				"refresh_token" => $refresh_token,
				"client_id" => GOOGLE_CLIENT_ID,
				"client_secret" => GOOGLE_CLIENT_SECRET,
			]);

			$data = (array) json_decode($response);
			$data["refresh_token"] = $refresh_token;

			update_access_token(json_encode($data));

			return sendAccount($username, $password, $email);
		} else {
			return $e->getMessage();
		}
	}
}

function sendOtp($email, $body)
{
	$username = get_username($email);
	$otp = get_account_inform($username)["OTP"];

	if (gettype($username) != "boolean") {
		global $adapter;
		require_once "../config.php";

		$arr_token = (array)get_access_token();

		try {
			$transport = Transport::fromDsn("gmail+smtp://" . urlencode('dtsamsung51@gmail.com')
				. ":" . urlencode($arr_token['access_token']) . "@default");

			$mailer = new Mailer($transport);

			$message = (new Email())
				->from("dtsamsung51@gmail.com")
				->to($email)
				->subject($body)
				->html($otp);

			$mailer->send($message);

			return "OTP was sent. Please check your email";
		} catch (Exception $e) {
			if (!$e->getCode()) {
				$refresh_token = get_refresh_token();

				$response = $adapter->refreshAccessToken([
					"grant_type" => "refresh_token",
					"refresh_token" => $refresh_token,
					"client_id" => GOOGLE_CLIENT_ID,
					"client_secret" => GOOGLE_CLIENT_SECRET,
				]);

				$data = (array) json_decode($response);
				$data["refresh_token"] = $refresh_token;

				update_access_token(json_encode($data));

				return sendOtp($email, $body);
			} else {
				return $e->getMessage();
			}
		}
	}
}

function check_otp($username, $password, $otp)
{
	$user_otp = get_account_inform($username)["OTP"];

	if ($user_otp == $otp) {
		update_otp($username);

		return change_password($username, $password);
	} else {
		return "Wrong OTP";
	}
}

function update_otp($username)
{
	$otp = generate_otp();
	$sql = "update account set OTP = ? where username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("ss", $otp, $username);
	$stm->execute();
}

function change_password($username, $password)
{
	$conn = create_connection();

	$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

	$sql = "update account set Password = ? where Username = ?";

	$stm = $conn->prepare($sql);
	$stm->bind_param("ss", $hashed_pass, $username);

	if ($stm->execute()) {
		reset_error_time($username);
		reset_locked_time($username);
		reset_login_status($username);

		if (get_account_inform($username)["VerifiedStatus"] == "Login for the first time") {
			$sql = "update account set VerifiedStatus = ? where Username = ?";

			$verified_status = "Pending verification";

			$stm = $conn->prepare($sql);
			$stm->bind_param("ss", $verified_status, $username);
			$stm->execute();

			return "successfully";
		}

		return "Reset password successfully";
	}

	return false;
}

function change_old_password($username, $old_pass, $new_pass)
{
	$sql = "select Password from account where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);

	if ($stm->execute()) {
		$result = $stm->get_result();
		$hashed_pass = $result->fetch_assoc()["Password"];

		if (password_verify($old_pass, $hashed_pass)) {
			$sql = "update account set password = ? where username = ?";

			$hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

			$stm = $conn->prepare($sql);
			$stm->bind_param("ss", $hashed_pass, $username);

			return $stm->execute();
		} else {
			return "Your old password is wrong";
		}
	} else {
		return "Please try again";
	}
}

function check_email_phone($email, $phone)
{
	$sql = "select * from customer where email = ? and PhoneNumber = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("ss", $email, $phone);

	if ($stm->execute()) {
		return true;
	} else {
		return "This email or phone number doesn't register";
	}
}

function change_name_id_front($id_front)
{
	$sql = "select * from customer where IdPhotoFront = ?";
	$conn = create_connection();

	$ext = pathinfo($id_front, PATHINFO_EXTENSION);

	$front = "../uploads/" . $id_front;

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $front);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows == 1) {
		return generate_pass() . "." . $ext;
	}

	return $id_front;
}

function change_name_id_back($id_back)
{
	$sql = "select * from customer where IdPhotoBack = ?";
	$conn = create_connection();

	$ext = pathinfo($id_back, PATHINFO_EXTENSION);

	$back = "../uploads/" . $id_back;

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $back);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows == 1) {
		return generate_pass() . "." . $ext;
	}

	return $id_back;
}

function update_id($username, $id_front, $id_back)
{
	$sql = "update customer set IdPhotoFront = ?, IdPhotoBack = ? where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("sss", $id_front, $id_back, $username);

	if ($stm->execute()) {
		return true;
	}

	return false;
}

function check_verification($username)
{
	$conn = create_connection();
	$sql = "select VerifiedStatus from account where Username = ?";

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 0) {
		$data = $result->fetch_assoc();

		return $data["VerifiedStatus"];
	}

	return "Error";
}

function check_username()
{
	$sql = "select count(*) from account where Username = ?";
	$conn = create_connection();

	do {
		$username = generate_username();

		$stm = $conn->prepare($sql);
		$stm->bind_param("s", $username);
		$stm->execute();

		$result = $stm->get_result();
		$exists = $result->fetch_array()[0] === 1;
	} while ($exists);

	return $username;
}

function get_account_inform($username)
{
	$sql = "select * from account where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 1) {
		return "Error";
	}

	return $result->fetch_assoc();
}

function get_username($email)
{
	$sql = "select * from customer where Email = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $email);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 1) {
		return false;
	}

	return $result->fetch_assoc()["Username"];
}

function get_profile($username)
{
	$sql = "select * from customer where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 1) {
		return "Error";
	}

	return $result->fetch_assoc();
}

function verified_account($username, $status)
{
	$sql = "update Account set VerifiedStatus = ? where Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("ss", $status, $username);
	$stm->execute();
}

function generate_username($length = 10)
{
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;
}

function generate_otp($length = 6)
{
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;
}

function generate_pass($length = 6)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;
}

function deposit($username, $card_num, $deposit_money)
{
	$deposit_money = (float) $deposit_money;

	$sql = "update account set Balance = Balance + ? where username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("ds", $deposit_money, $username);

	if ($stm->execute()) {
		record_deposit($username, $deposit_money, $card_num);

		return "Deposit successfully!";
	}
}

function record_deposit($username, $deposit_money, $card_num)
{
	$credit_id = get_id_cc($card_num)["CreditId"];

	$sql = "insert into transaction (TransactionStatus, TransactionMoney, ExecutionTime, TransactionType, Username, CreditId) values ('Approval', ?, now(), 'Deposit', ?, $credit_id)";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("ds", $deposit_money, $username);
	$stm->execute();
}

function get_id_cc($card_num)
{
	$sql = "select * from CreditCard where CardNumber = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("i", $card_num);
	$stm->execute();

	$result = $stm->get_result();

	return $result->fetch_assoc();
}

function check_cc($card_num, $date_expire, $cvv, $deposit_money)
{
	$sql = "select * from CreditCard where CardNumber = ?";
	$conn = create_connection();

	$card_num = (int) $card_num;

	$stm = $conn->prepare($sql);
	$stm->bind_param("i", $card_num);
	$stm->execute();
	$result = $stm->get_result();

	if ($result->num_rows == 1) {
		$data = $result->fetch_assoc();

		if ($date_expire != $data["Expiration"] || (int) $cvv != $data["CVV"]) {
			return 'This expiration or cvv is wrong';
		} else if ($card_num == 222222 && (float) $deposit_money > 1000000) {
			return 'This card can only be loaded up to 1 million vnd/time';
		} else if ($card_num == 333333) {
			return 'Card is out of money';
		} else {
			return true;
		}
	} else {
		return 'This card is not supported';
	}
}

function count_deposit($username)
{
	$sql = "select distinct count(*) as 'Deposit' from transaction where Username = ? and TransactionType = 'Deposit'";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 0) {
		return $result->fetch_assoc()["Deposit"];
	}

	return 0;
}

function count_withdrawal($username)
{
	$sql = "select distinct count(*) as 'Withdrawal' from transaction where Username = ? and TransactionType = 'Withdrawal'";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 0) {
		return $result->fetch_assoc()["Withdrawal"];
	}

	return 0;
}

function count_transfer($username)
{
	$sql = "select distinct count(*) as 'Transfer' from transaction where Username = ? and TransactionType = 'Transfer'";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 0) {
		return $result->fetch_assoc()["Transfer"];
	}

	return 0;
}

function count_buy($username)
{
	$sql = "select distinct count(*) as 'Buy' from transaction where Username = ? and TransactionType = 'Buy'";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 0) {
		return $result->fetch_assoc()["Buy"];
	}

	return 0;
}

function get_history_deposit($username)
{
	$sql = "select * from transaction where Username = ? and TransactionType = 'Deposit'";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 0) {
		$data = array();

		for ($i = 1; $i <= $result->num_rows; $i++) {
			$row = $result->fetch_assoc();
			$data[] = $row;
		}

		return $data;
	}

	return 0;
}

function get_name($phone)
{
	$sql = "select * from customer where PhoneNumber = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $phone);
	$stm->execute();

	$result = $stm->get_result();

	if ($result->num_rows != 1) {
		return false;
	}

	return $result->fetch_assoc();
}

function transfer($money, $username, $recipient, $note, $fee, $otp)
{
	record_transfer($money, $username, $recipient, $note, $fee);

	$email = get_profile($username)["Email"];

	if (check_otp_transfer($username, $otp)) {
		# code...
	} else {
		return "Wrong OTP";
	}
}

function record_transfer($money, $username, $recipient, $note, $fee)
{
	$otp = generate_otp();
	$sql = "insert into transaction (TransactionStatus, TransactionMoney, ExecutionTime, TransactionType, Username, RecipientPhone, Note, TransferFee, OTP) values ('Pending', ?, now(), 'Transfer', ?, ?, ?, ?, ?, $otp)";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("dsssd", $money, $username, $recipient, $note, $fee);
	$stm->execute();
}

function check_otp_transfer($username, $otp)
{
	$transaction_otp = get_otp_transfer($username);

	if ($transaction_otp == $otp) {
		return true;
	} else {
		return false;
	}
}

function get_otp_transfer($username)
{
	$sql = "select OTP from Transaction where TransactionStatus = 'Pending' and TransactionType ='Transfer' and Username = ?";
	$conn = create_connection();

	$stm = $conn->prepare($sql);
	$stm->bind_param("s", $username);
	$stm->execute();

	$result = $stm->get_result();

	return $result->fetch_assoc();
}
