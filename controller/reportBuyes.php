<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$dateStart = date_format(date_create($data['dateStart']), "Y-m-d");
	$dateFinish = date_format(date_create($data['dateFinish']), "Y-m-d");
	
	require_once('config/dbConnectionStore.php');
	
	$result = mysql_query("CALL reportBuyes('".$dateStart."','".$dateFinish."');", $connection) or die(mysql_error());

	$countRows = mysql_num_rows($result);
	
	if ($countRows > 0) {
		$i = 1;
		while ($row = mysql_fetch_assoc($result)) {
			$datos[] = array("no" => $i, "user_id" => $row['user_id'], "fullname" => $row['fullname'], "countBuyes" => $row['countBuyes'], "totalCredit" => $row['totalCredit'], "totalBuyes" => $row['totalBuyes']); 
			$i++;
		}
	}

	header("Content-Type: application/json", true);

    echo json_encode($datos);

	mysql_close($connection);

?>