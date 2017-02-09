<?php
    session_start();

	if (!$_SESSION['ID']) {
		header("Location: ../");
	}

  if ($_SESSION['ROLE'] != "1") {
    header("Location: principal.php");
  }

  date_default_timezone_set("America/Bogota");

  $months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $currentMonth = $months[date("m")-1];

  $dataTotalBuyes = "0";
  $dataTotalPayes = "0";
  $dataCountBuyes = "0";

  require_once('../controller/config/dbConnectionStore.php');

  $command = mysql_query("CALL getDataBillState(@totalBuyes, @totalPayes, @countBuyes)", $connection);

  if ($command) {
    $responseTotalBuyes = mysql_query("SELECT @totalBuyes", $connection);
    $objectTotalBuyes = mysql_fetch_array($responseTotalBuyes);
    $dataTotalBuyes = $objectTotalBuyes["@totalBuyes"];

    $responseTotalPayes = mysql_query("SELECT @totalPayes", $connection);
    $objectTotalPayes = mysql_fetch_array($responseTotalPayes);
    $dataTotalPayes = $objectTotalPayes["@totalPayes"];

    $responseCountBuyes = mysql_query("SELECT @countBuyes", $connection);
    $objectCountBuyes = mysql_fetch_array($responseCountBuyes);
    $dataCountBuyes = $objectCountBuyes["@countBuyes"];

    $chart_array[] = array((string)"Resultado", intval($dataTotalBuyes),intval($dataTotalPayes));

    $data=json_encode($chart_array);
  }

  mysql_close($connection);

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sole Store</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style_owner.css">
  <link rel="stylesheet" type="text/css" href="../css/loading.css">
  <style type="text/css">
    tbody tr:hover { background: #E6DFDF; }
  </style>
</head>
<body class="bodyColor" ng-app ng-controller="CashController">

     <?php include('header.php'); ?>

        <div class="container">
            <div class="panel panel-primary panel-home">
                <div class="panel-heading centerText">
                    <h3 class="panel-title"><strong>ESTADO DE CUENTAS</strong></h3>
                </div>
                <div class="panel-body property-body">
                    <h4><span class="label label-success">Mes de <?php echo $currentMonth; ?></span></h4>
                    <ul class="list-group col-md-8">
                      <li class="list-group-item"><span class="badge"><?php echo $dataCountBuyes; ?></span>Cantidad Compras:</li>
                      <li class="list-group-item"><span class="badge">$ <?php echo number_format($dataTotalBuyes,0,",","."); ?></span>Total en Compras:</li>
                      <li class="list-group-item"><span class="badge">$ <?php echo number_format($dataTotalPayes,0,",","."); ?></span>Total Recaudado:</li>
                    </ul>
                    <div class="loading blue slow solid thin"></div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="table-responsive listBillState">
                            <table class="table table-bordered centerText">
                                <thead>
                                    <tr class="bold">
                                      <td>No.</td>
                                      <td>Fecha</td>
                                      <td>Cantidad</td>
                                      <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="buy in buyes">
                                    <td>{{buy.number}}</td>
                                    <td>{{buy.dateRegister}}</td>
                                    <td>{{buy.count}}</td>
                                    <td>$ {{buy.total}}</td>
                                  </tr>
                              </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
	
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/billState.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>