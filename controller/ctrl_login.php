<?php

	$username = $_POST['username'];
	$password = md5(sha1($_POST['password']));

	require_once('config/dbConnectionStore.php');

	$result = mysqli_query($connection, "CALL existCredencials('" . $username . "', '" . $password . "', @response);") or die(mysqli_error());

	$status = "";
	$dataSetQuestion = array();

	if ($result) {
		
		$response = mysqli_query($connection, "SELECT @response");
        $value = mysqli_fetch_array($response);
		$dataValue = $value['@response'];

		switch ($dataValue) {
			case 'UP':

				$request = mysqli_query($connection, "CALL getDataUser('".$username."');") or die(mysqli_error());
                $data = mysqli_fetch_array($request);

				$dataUser[] = array("user_id" => $data['user_id'], 
									"user_fullname" => $data['fullname'], 
									"user_email" => $data['email']);

				session_start();
				$_SESSION['ID'] = $data['user_id'];
				$_SESSION['FULLNAME'] = $data['fullname'];
				$_SESSION['ROLE'] = $data['role'];
				
				if ($data['role'] === "1") {
					$status = "UP";
				} else if ($data['role'] === "2") {
					$status = "UPR";	
				}
				else if ($data['role'] === "3") {
					$status = "UPS";
				}
				break;
			case 'DOWN':
				$status = "DOWN";
				break;
			case 'BLOCKED':
				$status = "BLOCKED";
				break;
		}
	}
	else {
		$status = "FAIL";
	}

	$responseForRequest['statusResponse'] = $status;
	$responseForRequest['dataUser'] = $dataUser;

	mysqli_close($connection);

	header("Content-Type: application/json", true);

    echo json_encode($responseForRequest);

