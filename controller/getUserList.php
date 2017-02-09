<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getUserListTypeClient();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$state = ($row['state'] == "1") ? "SI" : "NO";
			$datos[] = array("nombre" => $row['fullname'], "username" => $row['username'], "correo" => $row['email'], "id" => $row['user_id'], "estado" => $state); 
		}
	}

    header("Content-Type: application/json", true);

    echo json_encode($datos);

    mysql_close($connection);

?>