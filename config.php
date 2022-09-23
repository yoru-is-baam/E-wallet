<?php
	require_once "db/db.php";
	require_once "lib/vendor/autoload.php";

	const GOOGLE_CLIENT_ID = "732305523437-vu2rnagtfa213mb0fh0n28vee3s93o3c.apps.googleusercontent.com";
	const GOOGLE_CLIENT_SECRET = "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";

	$config = [
		"callback" => "http://localhost:8080/callback.php",
		"keys" => [
			"id" => GOOGLE_CLIENT_ID,
			"secret" => GOOGLE_CLIENT_SECRET
		],
		"scope" => "https://mail.google.com",
		"authorize_url_parameters" => [
			"approval_prompt" => "force",       // to pass only when you need to acquire a new refresh token
			"access_type" => "offline"
		]
	];

	$adapter = new Hybridauth\Provider\Google($config);
?>