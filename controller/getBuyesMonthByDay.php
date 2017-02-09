<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getBuyesMonthByDay();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$i++;
			$numberFormat = number_format($row['total'],0,",",".");
			$datos[] = array("number" => $i, "dateRegister" => $row['dateRegister'], "count" => $row['count'], "total" => $numberFormat);
		}
	}

    header("Content-Type: application/json", true);

    echo json_encode($datos);

    mysql_close($connection);

?>