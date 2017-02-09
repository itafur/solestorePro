<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$fullname = $data['fullname'];
	$email = $data['email'];
	$username = $data['username'];
	$password = md5(sha1($data['password']));
	
    require_once('config/dbConnectionStore.php');
	
	$result = mysqli_query($connection, "CALL createClient('".$fullname."','".$username."','".$password."','".$email."', @response);") or die(mysqli_error());

	if ($result) {
		$response = mysqli_query("SELECT @response", $connection);
		$value = mysqli_fetch_array($response);
		$data = $value['@response'];

		if ($data == "EXISTE") {
			echo "El Usuario Ya Existe ";
		}
		else if ($data == "NO EXISTE") {
			echo "Creado exitosamente";
		}
	}
	else
	{
		echo "Ha ocurrido un problema, intente nuevamente";
	}

	mysqli_close($connection);

