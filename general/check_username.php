<?php
require_once "check_server.php";

$current_url = $url . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (isset($_SESSION["username"])) {
	if ($_SESSION["username"] == "admin") {
		$header = $url . $_SERVER['HTTP_HOST'] . "/admin/admin_system.php";

		if ($current_url != $header) {
			header("Location: $header");
			exit();
		}
	} else if (check_verification($_SESSION["username"]) == "Login for the first time") {
		$header = $url . $_SERVER['HTTP_HOST'] . "/e_wallet-start/change_with_otp.php";
		if ($current_url != $header) {
			header("Location: $header");
			exit();
		}
	} else if (check_verification($_SESSION["username"]) == "Pending verification") {
		$header = $url . $_SERVER['HTTP_HOST'] . "/e_wallet-core/not_verify_account.php";

		if ($current_url != $header) {
			header("Location: $header");
			exit();
		}
	} else if (check_verification($_SESSION["username"]) == "verified") {
		$header = $url . $_SERVER['HTTP_HOST'] . "/e_wallet-core/default.php";

		if ($current_url != $header) {
			header("Location: $header");
			exit();
		}
	} else if (check_verification($_SESSION["username"]) == "disabled") {
		$header = $url . $_SERVER['HTTP_HOST'] . "/e_wallet-start/sign_in.php";

		unset($_SESSION["username"]);

		$_SESSION["message"] = "This account has been disabled, please contact the hotline 18001008";

		header("Location: $header");
		exit();
	} else if (check_verification($_SESSION["username"]) == "waiting for updates") {
		$header = $url . $_SERVER['HTTP_HOST'] . "/e_wallet-core/update_id.php";

		if ($current_url != $header) {
			$_SESSION["message"] = "Please upload your id again";

			header("Location: $header");
			exit();
		}
	}
} else {
	$header =  $url . $_SERVER['HTTP_HOST'] . "/e_wallet-start/sign_in.php";

	if (str_contains($current_url, "sign_up")) {
		# code...
	} else if ($current_url != $header) {
		header("Location: $header");
		exit();
	}
}
