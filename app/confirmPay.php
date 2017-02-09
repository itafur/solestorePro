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
    <style type="text/css">
      tbody tr:hover { background: #E6DFDF; }
      #showMessageSending {
        display: none;
      }
      #showMessageSuccessfull {
        display: none;
      }
      #showMessageFail {
        display: none;
      }
    </style>
  </head>
  <body class="bodyColor" ng-app ng-controller="CashController">

       <?php include('header.php'); ?>

          <div class="container">
              <div class="panel panel-primary panel-home">
                  <div class="panel-heading centerText">
                      <h3 class="panel-title"><strong>GESTIÓN DE PAGOS</strong></h3>
                  </div>
                  <div class="panel-body property-body">
                      <div class="centerText">
                          <br>
                          <input type="text" class="form-control" placeholder="Buscar cliente por nombre" ng-model="buscar.nombre">
                          <br/>
                      </div>
                      <div class="panel panel-default list">
                          <div class="table-responsive">
                              <table class="table table-bordered centerText">
                                  <thead>
                                      <tr class="bold">
                                        <td>Nombre</td>
                                        <td>Saldo</td>
                                        <td colspan="2">Estado Crediticio</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr ng-repeat="cliente in clientes | filter:buscar">
                                      <td>{{cliente.nombre}}</td>
                                      <td>$ {{cliente.saldo}}</td>
                                      <td class="{{cliente.nameClass}}"><strong>{{cliente.statusCrediticio}}</strong></td>
                                      <td><a ng-show="isMoroso(cliente.saldo)" href="" class="btn btn-success" data-target="#modalPayRegister" data-toggle="modal" data-id="{{cliente.id}}" data-saldo="{{cliente.saldo}}" data-name="{{cliente.nombre}}">Pagar</a></td>
                                    </tr>
                                </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <div class="modal fade" id="modalPayRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header centerText register-client">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="exampleModalLabel">Registro de Pago</h4>
                </div>
                <div class="modal-body">
                    <form class="login" action="#" method="POST" autocomplete="off">
                      <div class="form-group">
                        <label class="control-label">Nombre Completo:</label>
                        <input type="text" class="form-control" id="fullname" ng-model="client.fullname" readonly="readonly">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Deuda:</label>
                        <input type="text" class="form-control" id="saldo" ng-model="client.saldo" readonly="readonly">
                      </div>
                      <div id="group-action">
                          <div class="form-group">
                            <label class="control-label">Tipo de Abono</label>
                          </div>
                          <div class="form-group">
                            <input type="radio" name="typeAbono" class="typeAbono" value="1" checked="checked"><label>&nbsp;&nbsp;Completo</label>
                            <input type="radio" name="typeAbono" class="typeAbono" value="0"><label>&nbsp;&nbsp;Parcial</label>
                          </div>

                          <div id="contentComplete" class="alert alert-success"></div>

                          <div id="contentPartial" class="alert alert-warning">
                            <div class="form-group">
                              <label class="control-label">Ingrese su abono:</label>
                              <input type="text" class="form-control" id="abono" ng-model="client.abono" onkeypress="return onlyNumeric(event)">
                            </div>
                          </div>
                          
                          <button type="button" id="btnPayConfirm" class="btn btn-success btn-block" ng-click="registerPay()">Aplicar Pago</button>
                      </div>

                      <div class="alert alert-info centerText" id="showMessageSending" role="alert">
                        <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                      </div>
                      <div class="alert alert-success centerText" id="showMessageSuccessfull" role="alert">
                         <strong>Pago Procesado</strong>
                         <img src="https://cdn2.iconfinder.com/data/icons/free-basic-icon-set-2/300/11-32.png">
                      </div>
                      <div class="alert alert-danger centerText" id="showMessageFail" role="alert"></div>

                    </form>
                </div>
              </div>
            </div>
          </div>
       	
       
  	
       <script src="../js/jquery-1.11.3.min.js"></script>
       <script src="../js/angular-1.2.5.min.js"></script>
       <script src="../js/angular-locale_es-es.js"></script>
       <script src="../js/cashList.js"></script>
       <script type="text/javascript">
          // Solo permite ingresar numeros.
            function onlyNumeric(e){
                var key = window.Event ? e.which : e.keyCode
                return (key >= 48 && key <= 57)
            }
       </script>
       <!--<script src="../js/manageClient.js"></script>-->
  	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
       <script src="../js/processLogout.js"></script>

  </body>
  </html>