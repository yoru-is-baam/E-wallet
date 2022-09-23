<?php
if (!isset($_SESSION["username"])) {
	header("Location: ../e_wallet-start/sign_in.php");
	exit();
}
