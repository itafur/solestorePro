<?php 

	$data = json_decode(file_get_contents('php://input'),true);

	$name = $data['name'];
	$price = $data['price'];
	$stock = $data['stock'];
	$enabled = $data['enabled'];
	
	require_once('config/dbConnectionStore.php');

	$result = mysqli_query($connection, "CALL createProduct('".$name."',".$price.",".$stock.",".$enabled.", @response);") or die(mysqli_error());

	if ($result) {
		$response = mysqli_query($connection, "SELECT @response");
		$value = mysqli_fetch_array($response);
		$data = $value['@response'];

		if ($data == "EXISTE") {
			echo "Código de producto existente";
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

