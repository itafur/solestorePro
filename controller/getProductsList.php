<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getProductList();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$state = ($row['state'] == "1") ? "SI" : "NO";
			$datos[] = array("code" => $row['product_id'], "product" => $row['name'], "price_unitary" => $row['price_unitary'], "stock" => $row['stock'], "enabled" => $state); 
		}
	}

    header("Content-Type: application/json", true);

    echo json_encode($datos);

    mysql_close($connection);

?>