<?php

$data = json_decode(file_get_contents('php://input'),true);

$id = $data['id'];
$password = $data['password'];

$encrypted = md5(sha1($password));

require_once('config/dbConnectionStore.php');

$result = mysqli_query($connection, "CALL changePassword('".$id."','".$encrypted."');") or die(mysqli_error());

if ($result) {
	echo "1";
} else {
	echo "0";
}

mysqli_close($connection);