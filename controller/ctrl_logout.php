<?php

	if (!isset($_POST['user_id'])) {
		exit;
	}

	$user_id = $_POST['user_id'];

	require_once('config/dbConnectionStore.php');

	$result = mysqli_query($connection, "CALL markStatusDisconnected(".$user_id.");") or die(mysqli_error());

	mysqli_close($connection);

	session_start();

	session_unset();
	session_destroy();

	echo "OK";

