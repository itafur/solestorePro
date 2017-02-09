<?php

	$userId = $_POST['user_id'];

	require_once('config/dbConnectionStore.php');

	$result = mysqli_query($connection, "CALL getBuyesTodayByUser(" . $userId . ");") or die(mysqli_error());
	$countRows = mysqli_num_rows($result);

	$i = 0;

	if ($result) {
		if ($countRows > 0) {
			echo "<div class='table-responsive'>
                    <table id='tableBuyes' class='table table-condensed table-bordered table-hover centerText'>
                    	<thead>
                    	<tr class='bold'>
                    		<td>No.</td>
                    		<td>Hora</td>
                    		<td>Valor Total</th>
                    		<td>Detalle</td>
                    	</tr>
                    	</thead>
                    	<tbody>";
			while ($row = mysqli_fetch_assoc($result)) {
				  $i += 1;
				  echo "<tr>
							<td>" . $i . "</td>
							<td>" . $row['date_create'] . "</td>
							<td>$" . number_format($row['total'], 0, ",", ".") . "</td>
							<td>
								<a class='pointer' data-target='#modalDetail' data-toggle='modal' data-id='". $row['purchase_id'] ."' data-whatever='@fat'>
									<span class='glyphicon glyphicon-eye-open viewDetail'></span>
								</a>
							</td>
						</tr>";
			}
			echo "		</tbody>
					</table>
                  </div>";
		}
		else {
			echo "<div class='centerText'>
                        <span class='glyphicon glyphicon-shopping-cart btn-lg colorCart' aria-hidden='true'></span>
                        <h4><span class='label label-danger'>Ninguna Compra Realizada</span></h4>
                    </div>";
		}
	}
	else {
		echo  "FAIL";
	}

	mysqli_close($connection);

