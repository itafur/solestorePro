<?php
    session_start();

	if (!$_SESSION['ID']) {
		header("Location: ../");
	}

  if ($_SESSION['ROLE'] != "2") {
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
  <style type="text/css">
    tbody tr:hover { background: #E6DFDF; }
  </style>
</head>
<body class="bodyColor" ng-app ng-controller="buyesMonthController">

     <?php include('header.php'); ?>

        <div class="container">
            <div class="panel panel-error panel-home">
                <br/>
                <div class="panel-body property-body">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <li class="list-group-item active">CANTIDAD DE COMPRAS <span class="badge">{{buyData.count}}</span></li>
                            <li class="list-group-item list-group-item-success"><h4>Saldo a Pagar <strong>$ {{buyData.saldo | number:0}}</strong></h4></li>
                        </div>
                     </div>
                     <h4><span class="label label-success">Compras del Mes</span></h4>
                     <div class="panel panel-default listBuyes">
                          <div class="table-responsive">
                              <table class="table centerText">
                                  <thead>
                                      <tr class="bold">
                                          <td>No.</td>
                                          <td>Fecha</td>
                                          <td>Valor Total</td>
                                          <td>Detalle</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                        <tr ng-repeat="buy in buyes">
                                            <td>{{buy.number}}</td>
                                            <td>{{buy.dateCreate}}</td>
                                            <td>${{buy.total | number:0}}</td>
                                            <td>
                                                <a class="pointer" data-target="#modalDetail" data-toggle="modal" data-id="{{buy.id}}" data-whatever='@fat'>
                                                    <span class='glyphicon glyphicon-eye-open viewDetail'></span>
                                                </a>
                                            </td>
                                        </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="btn-show-pay">
                          <form action="#" method="POST" ng-submit="showPayesDones()">
                              <button type="submit" class="btn btn-primary">Click Aquí para Ver Pagos</button>
                          </form>
                      </div>
                      <div class="tablePay">
                          <h4><span class="label label-warning">Ultimos 3 Pagos</span></h4>
                          <div class="panel panel-default listPay">
                              <div class="table-responsive">
                                  <table class="table table-bordered table-hover table-borde centerText">
                                      <thead>
                                          <tr class="bold">
                                              <td>Fecha y Hora</td>
                                              <td>Valor Pagado</td>
                                              <td>¿Pago Completo?</td>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr ng-repeat="pay in payes">
                                              <td>{{pay.datePay}}</td>
                                              <td>$ {{pay.valuePayed | number:0}}</td>
                                              <td><span ng-show="payedComplete(pay.complete)" class="glyphicon glyphicon-ok-sign colorPay"></span></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header modal-top">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Detalle de Compra</h4>
              </div>
              <div class="modal-body modal-mediun">
              
              </div>
            </div>
          </div>
        </div>
     	
     
	
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/getBuyesMonthUser.js"></script>
     <!--<script src="../js/manageClient.js"></script>-->
	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>