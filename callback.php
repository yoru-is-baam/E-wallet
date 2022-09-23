<?php
	require_once "config.php";

	try {
		$conn = create_connection();
		$adapter->authenticate();
		$token = $adapter->getAccessToken();
		update_access_token(json_encode($token));
		echo "Successfully";
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>
