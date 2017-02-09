<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getBuyesTodayForCancel();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		$i = $countRows + 1;
		while ($row = mysql_fetch_assoc($result)) {
		  $i -= 1;

		  $data[] = array("number" => $i, "id" => $row['purchase_id'], "client" => $row['fullname'], "time" => $row['date_create'], "total" => number_format($row['total'], 0, ',', '.'));
		}
	}

    mysql_close($connection);

    header("Content-Type: application/json", true);

	echo json_encode($data);

?>