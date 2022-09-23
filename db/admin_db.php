<?php
require_once "db.php";

function get_pending_account()
{
	$sql = "select * from account where VerifiedStatus = 'Pending verification' or VerifiedStatus = 'waiting for updates'";
	$conn = create_connection();

	$result = $conn->query($sql);
	$data = array();

	for ($i = 1; $i <= $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		$data[] = $row;
	}

	return $data;
}

function get_activated_account()
{
	$sql = "select * from account where VerifiedStatus = 'verified'";
	$conn = create_connection();

	$result = $conn->query($sql);
	$data = array();

	for ($i = 1; $i <= $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		$data[] = $row;
	}

	return $data;
}

function get_disabled_account()
{
	$sql = "select * from account where VerifiedStatus = 'disabled'";
	$conn = create_connection();

	$result = $conn->query($sql);
	$data = array();

	for ($i = 1; $i <= $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		$data[] = $row;
	}

	return $data;
}

function get_locked_account()
{
	$sql = "select * from account where LoginStatus = 'abnormal login' and ErrorTime >= 6";
	$conn = create_connection();

	$result = $conn->query($sql);
	$data = array();

	for ($i = 1; $i <= $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		$data[] = $row;
	}

	return $data;
}
