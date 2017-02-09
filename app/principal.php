<?php
    session_start();

	if (!$_SESSION['ID']) {
		header("Location: ../");
	}
?>
<!DOCTYPE html>
<html lang="es" ng-app>
<head>
	<meta charset="UTF-8">
	<title>Sole Store</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style_owner.css">
</head>
<body class="bodyColor" onload="">

     <?php include('header.php'); ?>

        <div class="container" ng-controller="StatisticsRealTimeController">
            <?php if ($_SESSION['ROLE'] == "2") {?>
              <div class="panel panel-primary panel-home">
                <div class="panel-heading centerText">
                    <h3 class="panel-title"><strong>COMPRAS EN EL DIA DE HOY</strong></h3>
                </div>
                <div class="panel-body">
                    <div id="resultBuyesToday">
                        
                    </div>
                </div>
              </div>
            <?php } else { ?>
              <!-- /.row -->
              <div class="row panel-home">
                  <div class="col-lg-3 col-md-6">
                      <div class="panel panel-primary">
                          <div class="panel-heading">
                              <div class="row">
                                  <div class="col-xs-3 mrg-image">
                                      <span class="glyphicon glyphicon-shopping-cart xs-35"></span>
                                  </div>
                                  <div class="col-xs-9 text-right">
                                      <div class="huge xs-35" ng-bind="information.buyesToday"></div>
                                      <div>Compras hoy</div>
                                  </div>
                              </div>
                          </div>
                          <a href="#" data-target="#modalShowTodayBuyes" data-toggle="modal">
                              <div class="panel-footer">
                                  <span class="pull-left">Ver Detalle</span>
                                  <span class="pull-right">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                  </span>
                                  <div class="clearfix"></div>
                              </div>
                          </a>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="panel panel-cash">
                          <div class="panel-heading">
                              <div class="row">
                                  <div class="col-xs-3 mrg-image">
                                      <span class="glyphicon glyphicon-usd xs-35"></span>
                                  </div>
                                  <div class="col-xs-9 text-right">
                                      <div class="huge xs-35" ng-bind="information.cashSalesToday"></div>
                                      <div>Vendidos hoy</div>
                                  </div>
                              </div>
                          </div>
                          
                              <div class="panel-footer">
                                  <span class="pull-left">Vacio</span>
                                  <span class="pull-right">
                                  </span>
                                  <div class="clearfix"></div>
                              </div>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="panel panel-user">
                          <div class="panel-heading">
                              <div class="row">
                                  <div class="col-xs-3 mrg-image">
                                      <span class="glyphicon glyphicon-user xs-35"></span>
                                  </div>
                                  <div class="col-xs-9 text-right">
                                      <div class="huge xs-35" ng-bind="information.usersConnected"></div>
                                      <div>Usuarios Conectados</div>
                                  </div>
                              </div>
                          </div>
                          <a href="#" data-target="#modalShowUsersConnected" data-toggle="modal" class="a3">
                              <div class="panel-footer">
                                  <span class="pull-left">Ver Detalle</span>
                                  <span class="pull-right">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                  </span>
                                  <div class="clearfix"></div>
                              </div>
                          </a>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="panel panel-agotado">
                          <div class="panel-heading">
                              <div class="row">
                                  <div class="col-xs-3 mrg-image">
                                      <span class="glyphicon glyphicon-exclamation-sign xs-35"></span>
                                  </div>
                                  <div class="col-xs-9 text-right">
                                      <div class="huge xs-35" ng-bind="information.productsAgotados"></div>
                                      <div>Alerta Vencimiento</div>
                                  </div>
                              </div>
                          </div>
                          <a href="#" data-target="#modalShowBuyesToday" data-toggle="modal" class="a4">
                              <div class="panel-footer">
                                  <span class="pull-left">Ver Detalle</span>
                                  <span class="pull-right">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                  </span>
                                  <div class="clearfix"></div>
                              </div>
                          </a>
                      </div>
                  </div>
              </div>
              <!-- /.row -->
            <?php } ?> 
        </div>

        <div class="modal fade" id="modalShowUsersConnected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText usersConnected">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Usuarios Conectados</h4>
              </div>
              <div class="modal-body">
                  
              </div>
              <div class="oculto"></div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalShowBuyesToday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText listProductsExhausted">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Productos Agotados</h4>
              </div>
              <div class="modal-body">
                  
              </div>
              <div class="oculto"></div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalShowTodayBuyes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Compras Realizadas Hoy</h4>
              </div>
              <div class="modal-body">
                  
              </div>
              <div class="oculto"></div>
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
     <?php if ($_SESSION['ROLE'] === "1") { ?>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/dashboard.js"></script>
     <?php } else if ($_SESSION['ROLE'] === "2") { ?>
     <script src="../js/main.js"></script>
     <?php } ?>
	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>