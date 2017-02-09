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
      .showMessageSending {
        display: none;
      }
      .showMessageSuccessfull {
        display: none;
      }
      .showMessageFail {
        display: none;
      }
    </style>
  </head>
  <body class="bodyColor" ng-app ng-controller="CashController">

       <?php include('header.php'); ?>

          <div class="container">
              <div class="panel panel-danger panel-home">
                  <div class="panel-heading centerText">
                      <span class="glyphicon glyphicon-remove-sign"></span>
                      <h3 class="panel-title"><strong>ANULACIÓN DE GESTIONES</strong></h3>
                  </div>
                  <div class="panel-body property-body">
                      <div class="centerText">
                          <br>
                          <input type="text" class="form-control" placeholder="Buscar gestión por nombre de cliente" ng-model="search.client">
                          <br/>
                      </div>
                      <div class="panel panel-default list">
                          <div class="table-responsive">
                              <table class="table table-bordered centerText">
                                  <thead>
                                      <tr class="bold">
                                        <td>No.</td>
                                        <td>Hora</td>
                                        <td>Cliente</td>
                                        <td>Valor Total</td>
                                        <td>Acción</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr ng-repeat="row in listGestion | filter:search">
                                        <td>{{row.number}}</td>
                                        <td>{{row.time}}</td>
                                        <td>{{row.client}}</td>
                                        <td>${{row.total}}</td>
                                        <td>
                                          <a href="" class="btn btn-danger" data-target="#modalManageCancel" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-id="{{row.id}}" data-total="{{row.total}}" data-name="{{row.client}}" data-time="{{row.time}}">Anular</a>
                                        </td>
                                    </tr>
                                </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <div class="modal fade" id="modalManageCancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header centerText manage-cancel">
                  <h4 class="modal-title" id="exampleModalLabel">Proceso de Anulación</h4>
                </div>
                <div class="modal-body">
                    <form class="login" action="#" method="POST" ng-submit="applyCancel()">
                      <div class="form-group">
                        <label class="control-label">Cliente:</label>
                        <span id="name" ng-model="manage.client"></span>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Hora:</label>
                        <span id="time" ng-model="manage.time"></span>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Total:</label>
                        <span id="total" ng-model="manage.total"></span>
                      </div>

                      <br>

                      <div class="group-action">
                        <button type="button" class="btn btnDismissCancel" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger btnConfirmCancel">
                          <span class="glyphicon glyphicon-minus-sign"></span> Confirmar
                        </button>
                      </div>

                      <div class="alert alert-info centerText showMessageSending" role="alert">
                        <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                      </div>
                      <div class="alert alert-success centerText showMessageSuccessfull" role="alert">
                         <strong>La gestion fue anulada</strong>
                         <label class="glyphicon glyphicon-ok-sign"></label>
                      </div>
                      <div class="alert alert-danger centerText showMessageFail" role="alert"></div>

                    </form>
                </div>
                <div class="oculto"></div>
              </div>
            </div>
          </div>
       	
       
  	
       <script src="../js/jquery-1.11.3.min.js"></script>
       <script src="../js/angular-1.2.5.min.js"></script>
       <script src="../js/angular-locale_es-es.js"></script>
       <script src="../js/cancel.js"></script>
       <!--<script src="../js/manageClient.js"></script>-->
  	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
       <script src="../js/processLogout.js"></script>

  </body>
  </html>