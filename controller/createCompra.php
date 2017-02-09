<?php

	$user_id = $_POST['user_id'];
	$fullname = $_POST['fullname'];
	$emailAccountAddressee = $_POST['email'];
	$total = $_POST['total'];
	$count = $_POST['productsCount'];
	$listProducts = json_decode($_POST['listProducts']);

	require_once('config/dbConnectionStore.php');

	$result = mysqli_query($connection, "CALL createPurchases(" . $user_id . ", " . $count . ", " . $total . ", @valorId)") or die(mysqli_error());

	$flagOk = true;
	$flagLessItem = true;

	$listProductsResultHTML = "<ul>";
	$messageBySuperarStock = "";
	
	if ($result) {
		$response = mysqli_query($connection, "SELECT @valorId");
		$value = mysqli_fetch_array($response);

		$idBuy = $value['@valorId'];
		
		foreach ($listProducts as $product) {
			$code = $product->codigo;
			$item = $product->item;
			$countByItem = $product->cantidad;
			$subtotal = $product->subtotal;
			if ($code != null && $code != "") {
				$resultByItem = mysqli_query($connection, "CALL createDetail(" . $idBuy . ", '" . $code . "', " . $countByItem . ", " . $subtotal . ", @resultDetail)") or (mysqli_error());
				$responseDetail = mysqli_query($connection, "SELECT @resultDetail");
				$valueDetail = mysqli_fetch_array($responseDetail);
				$dataDetail = $valueDetail['@resultDetail'];
				if (!$resultByItem) {
					$flagOk = false;
					break;
				}
				else {
					if ($dataDetail != -1) {
						$messageBySuperarStock .= "Hay (" . $dataDetail . ") " . $item . " - Remover y Actualizar";
						$flagOk = false;
					}
					$listProductsResultHTML .= "<li type='circle'>(".$countByItem.") ".$item." = $".$subtotal."</li>";
				}
			}
		}

		$listProductsResultHTML .= "</ul>";

		if ($flagOk) {
			foreach ($listProducts as $product) {
				$code = $product->codigo;
				$countByItem = $product->cantidad;
				$resultLessStock = mysqli_query($connection, "CALL LoteStockLessByProduct('" . $code . "', '" . $countByItem . "')") or (mysqli_error());
				if (!$resultLessStock) {
					$flagLessItem = false;
					break;
				}
			}
			echo mysqli_error();
			if ($flagLessItem) {
				mysqli_query($connection, "CALL addSaldoToClient(" . $user_id . ", " . $total . ")") or (mysqli_error());
				echo "OK";

				date_default_timezone_set("America/Bogota");

				$bodyContent = "<div style='width: 590px; font-family: arial; font-size: 12px; color: #555555; line-height: 14pt'>
								    <div style='padding-top: 20px; padding-left: 50px; padding-right: 50px;'>
								        <img src='https://cdn3.iconfinder.com/data/icons/meanicons-4/512/meanicons_58-48.png' alt='Sivere' style='border:none;'></img>
								        <h3><font color='#0AB03E'>GRACIAS POR TU COMPRA ".$fullname."</font></h3>
								     </div>
								     <div>
								      <div style='padding-left: 50px; padding-right: 50px; padding-bottom: 1px;'>
								        <hr/>
								        <div style='margin-bottom: 30px;'>
								          <br>
								          <div style='margin-bottom: 20px;'>
								            <b>Fecha de compra:</b> ".date('d/m/Y H:i:s')."<br>
								            <b>Total a pagar:</b> $".$total."<br>
								          </div>
								          <div style='margin-bottom: 20px; margin-top: 20px'>
								            ".$listProductsResultHTML." 
								          </div>
								        </div>
								        <div style='font-size: 9px; color: #707070;'>
								          <br>Este correo es informativo.<br>
								          By SoleStore Software.<br>
								        </div>
								      </div>
								    </div>
								</div>";

				$subject = 'Solestore - Notificacion de Compra';
				$addresses =  $emailAccountAddressee;
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "X-Priority: 3\n";
				$headers .= "X-MSMail-Priority: Normal\n";
				$headers .= "X-Mailer: php\n";
				
				mail($addresses,$subject,$bodyContent,$headers);
			}
			else
			{
				$resultDelete = mysqli_query($connection, "CALL deleteBuyWithItsDetails(" . $idBuy . ")") or (mysqli_error());
				if ($resultDelete) {
					echo "Error: Intente Nuevamente - Recarge la pagina";
				}	
			}
		}
		else {
			$resultDelete = mysqli_query($connection, "CALL deleteBuyWithItsDetails(" . $idBuy . ")") or (mysqli_error());
			if ($resultDelete) {
				if ($messageBySuperarStock != "") {
					echo $messageBySuperarStock;
				}
				else {
					echo "Error: Intente Nuevamente - Recargue la pagina" . mysqli_error();
				}
			}
		}
	}
	else {
		echo "Error: " . mysqli_error();
	}

	$mail = null;
	mysqli_close($connection);
