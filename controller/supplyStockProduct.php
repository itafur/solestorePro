<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$code = $data['code'];
	$stock = $data['stock'];

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL supplyStockProduct('".$code."',".$stock.");", $connection) or die(mysql_error());

	if ($result) {
		echo "1";
	} else {
		echo "0";
	}

	mysql_close($connection);
?>