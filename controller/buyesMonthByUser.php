<?php

	$data = json_decode(file_get_contents('php://input'),true);

	$id = $data['user_id'];

	require_once('config/dbConnectionStore.php');

	$resultTwo = mysqli_query($connection, "SELECT saldo AS saldoClient FROM users WHERE user_id = " . $id . ";") or die(mysqli_error());
	if ($resultTwo) {
		while ($rowBalance = mysqli_fetch_array($resultTwo)) {
			$dataBalance = $rowBalance["saldoClient"];
		}
	}

	$result = mysqli_query($connection, "CALL getBuyesMonthByUser(" . $id . ");") or die(mysqli_error());
	$countRows = mysqli_num_rows($result);

	$i = 0;

	if ($result) {
		if ($countRows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				  $i += 1;
				  $dataPurchases[] = array("id" => $row['purchase_id'], "number" => $i, "dateCreate" => $row['date_create'], "total" => $row['total']);
			}
		}

	}

	mysqli_close($connection);
	
	$dataOutput['saldo'] = $dataBalance;
	$dataOutput['buyes'] = $dataPurchases;

	header("Content-Type: application/json", true);

	echo json_encode($dataOutput);

