<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$id = $data['id'];
	$fullname = $data['fullname'];
	$email = $data['email'];
	$state = $data['state'];

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL updateDataClient(".$id.",'".$fullname."','".$email."',".$state.");", $connection) or die(mysql_error());

	if ($result) {
		echo "1";
	} else {
		echo "0";
	}

	mysql_close($connection);
?>