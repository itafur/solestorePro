<?php
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getProducts();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$datos[] = array("code" => $row['product_id'], "name" => $row['name'], "price" => $row['price_unitary'], "stock" => $row['stock']);
		}
	}

	$arrayResponse['data'] = $datos;

	mysql_close($connection);

	header("Content-Type: application/json", true);

	echo json_encode($arrayResponse);
?>