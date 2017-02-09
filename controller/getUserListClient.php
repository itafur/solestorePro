<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getClientOnlyActives();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
	    $datos[] = array("id" => "0", "nombre" => "-- SELECCIONE UNA OPCIÓN --");
		while ($row = mysql_fetch_assoc($result)) {
		    $fullname = strtoupper($row['fullname']);
			$datos[] = array("id" => $row['user_id'], "nombre" => $fullname, "email" => $row['email']);
		}
	}

    header("Content-Type: application/json", true);

    echo json_encode($datos);

    mysql_close($connection);

?>