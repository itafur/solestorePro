<?php
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getProducts();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	echo $countRows;

	mysql_close($connection);
?>