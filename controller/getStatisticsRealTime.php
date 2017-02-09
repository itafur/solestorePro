<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysqli_query($connection, "CALL getStatisticsRealTime(@usersConnected, @productsAgotados, @buyesToday, @cashSalesToday);") or die(mysqli_error());
	
	if ($result) {
		$responseUC = mysqli_query($connection, "SELECT @usersConnected");
		$valueUC = mysqli_fetch_array($responseUC);
		$dataUC = $valueUC['@usersConnected'];

		$responsePA = mysqli_query($connection, "SELECT @productsAgotados");
		$valuePA = mysqli_fetch_array($responsePA);
		$dataPA = $valuePA['@productsAgotados'];

		$responseBT = mysqli_query($connection, "SELECT @buyesToday");
		$valueBT = mysqli_fetch_array($responseBT);
		$dataBT = $valueBT['@buyesToday'];

		$responseCST = mysqli_query($connection, "SELECT @cashSalesToday");
		$valueCST = mysqli_fetch_array($responseCST);
		$dataCST = number_format($valueCST['@cashSalesToday'], 0, ',', '.');

		$dataCollection[] = array("buyesToday" => $dataBT, "cashSalesToday" => $dataCST, "usersConnected" => $dataUC, "productsAgotados" => $dataPA);

		header("Content-Type: application/json", true);

    	echo json_encode($dataCollection);
	}

    mysqli_close($connection);

?>