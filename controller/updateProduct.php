<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$code = $data['code'];
	$name = $data['name'];
	$price = $data['price'];
	$stock = $data['stock'];
	$enabled = $data['enabled'];

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL updateDataProduct('".$code."','".$name."',".$price.",".$stock.",".$enabled.");", $connection) or die(mysql_error());

	if ($result) {
		echo "1";
	} else {
		echo "0";
	}

	mysql_close($connection);
?>