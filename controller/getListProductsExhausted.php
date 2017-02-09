<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL listProductsExhausted();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		echo "<div class='table-responsive'>
						<table class='table table-hover centerText'>
							<tbody>";
		while ($row = mysql_fetch_assoc($result)) {

			$stock = $row['stock'];

			echo "<tr>
					<td>".strtoupper($row['name'])."</td>";
					if ($stock == "0") {
						echo "<td><span class='label label-danger'>AGOTADO</span></td>";
					} else {
						echo "<td><span class='badge'>".$row['stock']."</span></td>";
					}
				  echo "</tr>";
		}
		echo "</tbody>
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