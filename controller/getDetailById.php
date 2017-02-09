<?php

	$idBuy = $_POST['idBuy'];

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getDetailBuyId(" . $idBuy . ");", $connection) or die(mysql_error());

	if ($result) {
		echo "<div class='table-responsive'>
				<table class='table table-condensed centerText'>
						  <tr class='bold'>
						  	 <td>Producto</td>
						  	 <td>Unidades</td>
						  	 <td>Subtotal</td>
						  </tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							 <td>" . $row['name'] ."</td>
							 <td>" . $row['countt'] ."</td>
							 <td>$" . number_format($row['subtotal'], 0, ',', '.') ."</td>
						  </tr>";
				}
		echo "	</table>
			  </div>";
	}
	else {
		echo "FAIL";
	}

	mysql_close($connection);

?>