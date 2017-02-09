<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getCashListUser();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$statusCrediticio = "";
			$nameClass = "";
			$saldoNumberFormat = number_format($row['saldo'], 0, ',', '.');
			if ($row['saldo'] > 0) {
				$statusCrediticio = "MOROSO";
				$nameClass = "bg-error";
			} else {
				$statusCrediticio = "PAZ Y SALVO";
				$nameClass = "bg-success";
			}
			$datos[] = array("id" => $row['user_id'], "nombre" => $row['fullname'], "saldo" => $saldoNumberFormat, "nameClass" => $nameClass, "statusCrediticio" => $statusCrediticio); 
		}
	}

    header("Content-Type: application/json", true);

    echo json_encode($datos);

    mysql_close($connection);

?>