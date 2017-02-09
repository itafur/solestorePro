<?php

$data = json_decode(file_get_contents('php://input'),true);

$id = $data['id'];

require_once('config/dbConnectionStore.php');

$result = mysql_query("CALL deleteProduct(".$id.");", $connection) or die(mysql_error());
$responseStatus = "";

if ($result) {
	
	$row = mysql_fetch_assoc($result);
	$response = $row['response'];

	switch ($response) {
		case 'ERROR':
			$responseStatus = "ERROR";
			break;
		case 'WARNING':
			$responseStatus = "WARNING";
			break;
		case 'OK':
			$responseStatus = "OK";
			break;
		default:
			$responseStatus = "ERROR";
			break;
	}

}

mysql_close($connection);
echo $responseStatus;