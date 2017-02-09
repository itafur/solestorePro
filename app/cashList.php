<?php
    session_start();

	if (!$_SESSION['ID']) {
		header("Location: ../");
	}

  if ($_SESSION['ROLE'] != "1") {
    header("Location: principal.php");
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sole Store</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style_owner.css">
</head>
<body class="bodyColor" ng-app ng-controller="CashController">

     <?php include('header.php'); ?>

        <div class="container">
            <div class="panel panel-primary panel-home">
                <div class="panel-heading centerText">
                    <h3 class="panel-title"><strong>LISTADO DE SALDOS POR CLIENTES</strong></h3>
                </div>
                <div class="panel-body property-body">
                    <div class="centerText">
                        <br>
                        <input type="text" class="form-control" placeholder="Buscar cliente por nombre" ng-model="buscar.nombre">
                        <br/>
                    </div>
                    <div class="panel panel-default list">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borde centerText">
                                <thead>
                                    <tr class="bold">
                                      <td>Nombre</td>
                                      <td>Deuda</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="cliente in clientes | filter:buscar">
                                    <td>{{cliente.nombre}}</td>
                                    <td>$ {{cliente.saldo}}</td>
                                  </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     	
     
	
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/cashList.js"></script>
     <!--<script src="../js/manageClient.js"></script>-->
	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>