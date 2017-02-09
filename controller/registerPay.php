<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$id = $data['id'];
	$abono = str_replace(".","",$data['abono']);
	$complete = $data['complete'];

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL registerPay(".$id.",".$abono.",".$complete.");", $connection) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	$response = $row['response'];
	$resultStatus = "";

	switch ($response) {
		case 'ERROR':
			$resultStatus = "ERROR";
			break;
		case 'WARNING':
			$resultStatus = "WARNING";
			break;
		case 'OK':
			$resultStatus = "OK";
			break;
		default:
			$resultStatus = "ERROR";
			break;
	}

	mysql_close($connection);

	echo $resultStatus;
?>