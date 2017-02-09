<?php
	
	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL listUsersConnected();", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {
		echo "<div class='table-responsive'>
						<table class='table table-bordered table-hover table-borde centerText'>
							<tbody>";
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr><td>".$row['fullname']."</td></tr>";
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