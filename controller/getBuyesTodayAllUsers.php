<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getBuyesToday();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
					echo "<div class='table-responsive'>
                    <table id='tableBuyes' class='table table-condensed table-bordered table-hover centerText'>
                    	<thead>
                    	<tr class='bold'>
                    		<td>No.</td>
                    		<td>Hora</td>
                    		<td>Cliente</td>
                    		<td>Valor Total</th>
                    		<td>Detalle</td>
                    	</tr>
                    	</thead>
                    	<tbody>";
			while ($row = mysql_fetch_assoc($result)) {
				  $i += 1;
				  echo "<tr>
							<td>" . $i . "</td>
							<td>" . $row['date_create'] . "</td>
							<td>" . $row['fullname'] . "</td>
							<td>$" . number_format($row['total'], 0, ',', '.') . "</td>
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
	else
	{
		echo "";
	}

    echo $response;

    mysql_close($connection);

?>