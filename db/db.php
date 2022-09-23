<?php
const HOST = "mysql-server";
const USER = "root";
const PASS = "root";
const DB_NAME = "e_wallet";

function create_connection()
{
	$conn = new mysqli(HOST, USER, PASS, DB_NAME);

	if ($conn->connect_error) {
		die("Cannot connect: " . $conn->connect_error);
	}

	return $conn;
}

function is_token_empty()
{
	$conn = create_connection();

	$sql = $conn->query("select id from google_oauth where provider = 'google'");

	if ($sql->num_rows) {
		return false;
	}

	return true;
}

function get_access_token()
{
	$conn = create_connection();

	$sql = $conn->query("select provider_value from google_oauth where provider = 'google'");

	$result = $sql->fetch_assoc();

	return json_decode($result["provider_value"]);
}


function get_refresh_token()
{
	$result = get_access_token();

	return $result->refresh_token;
}

function update_access_token($token)
{
	$conn = create_connection();

	if (is_token_empty()) {
		$conn->query("insert into google_oauth (provider, provider_value) values ('google', '$token')");
	} else {
		$conn->query("update google_oauth set provider_value = '$token' where provider = 'google'");
	}
}
