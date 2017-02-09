<?php

	$data = json_decode(file_get_contents('php://input'),true);

	$idBuy = $data['id'];
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL cancelBuyAndAjustCreditOfClient(".$idBuy.");", $connection) or die(mysql_error());
	
	$row = mysql_fetch_assoc($result);

	$response = $row['response'];
	$result = "";

	switch ($response) {
		case 'ERROR':
			$result = "ERROR";
			break;
		case 'WARNING':
			$result = "WARNING";
			break;
		case 'OK':
			$result = "OK";
			break;
		default:
			$result = "ERROR";
			break;
	}

    mysql_close($connection);

    echo $result;

?>