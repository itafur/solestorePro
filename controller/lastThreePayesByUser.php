<?php

	$data = json_decode(file_get_contents('php://input'),true);

	$id = $data['user_id'];

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL lastThreePayesByUser(" . $id . ");", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	$i = 0;

	if ($result) {
		if ($countRows > 0) {
			while ($row = mysql_fetch_assoc($result)) {
				  $datos[] = array("datePay" => $row['date_pay'], "valuePayed" => $row['valuePayed'], "saldoPendiente" => $row['saldoPendiente'], "complete" => $row['complete']); 
			}
		}
	}

	header("Content-Type: application/json", true);

	echo json_encode($datos);

	mysql_close($connection);

?>