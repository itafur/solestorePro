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
  <link rel="stylesheet" type="text/css" href="../css/loading.css">
  <link rel="stylesheet" type="text/css" href="../css/datepicker.min.css">
  <style type="text/css">
    tbody tr:hover { background: #E6DFDF; }
  </style>
</head>
<body class="bodyColor" ng-app ng-controller="CashController">

     <?php include('header.php'); ?>

        <div class="container">
            <div class="panel panel-primary panel-home">
                <div class="panel-heading centerText">
                    <h3 class="panel-title"><strong>REPORTE DE COMPRAS</strong></h3>
                </div>
                <div class="panel-body property-body">
                    <div class="centerText">
                        <br/>
                        <form class="form-inline" action="#" method="POST">
                            <div class="form-group">
                                <label for="exampleInputName2" class="label label-primary">Desde</label>
                                <input type="text" class="form-control form-control-1 input-sm from" placeholder="Fecha Inicial" ng-model="client.dateStart">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2" class="label label-primary">Hasta</label>
                                <input type="text" class="form-control form-control-2 input-sm to" placeholder="Fecha Final" ng-model="client.dateFinish">
                            </div>
                          <button type="button" class="btn btn-success" ng-click="consultBuyesByRange()">Consultar</button>
                          <button type="button" ng-click="downloadReportBuyes()"><img src="https://cdn0.iconfinder.com/data/icons/very-basic-android-l-lollipop-icon-pack/24/download-2-32.png"></button>
                        </form>
                        <br/>
                    </div>
                    <div class="panel panel-default listReport">
                        <div id="showLoading">
                            <div class="loading blue slow solid thin"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered centerText">
                                <thead>
                                    <tr class="bold">
                                      <td>No.</td>
                                      <td>Cliente</td>
                                      <td>Cantidad de Compras</td>
                                      <td>Total Compras</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="cliente in clientes | filter:buscar">
                                    <td>{{cliente.no}}</td>
                                    <td>{{cliente.fullname}}</td>
                                    <td>{{cliente.countBuyes}}</td>
                                    <td>$ {{cliente.totalBuyes | number:0}}</td>
                                  </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row rowTop">
                        <div class="col-md-4">
                            <br>
                            <div class="messageError alert alert-danger" role="alert">{{client.msg}}</div>
                        </div>
                        <div class="col-md-2">
                            <h3><label class="label label-default">TOTAL COMPRAS: $ {{client.totalBuyes | number:0}}</label></h3>
                        </div>
                        <div class="col-md-1"></div>
                        <!--<div class="col-md-2">
                            <h3><label class="label label-primary">TOTAL SALDOS: $ {{client.totalSaldos | number:0}}</label></h3>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalShowDateRangeBuyes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Compras Realizadas desde {{client.dateStart}} hasta {{client.dateFinish}}</h4>
              </div>
              <div class="modal-body">
                  
              </div>
              <div class="oculto"></div>
            </div>
          </div>
        </div>
     
  
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/reportBuyes.js"></script>
     <script src="../js/bootstrap-datepicker.min.js"></script>
     <script type="text/javascript">
        var startDate = new Date();
        var fechaFin = new Date();
        var FromEndDate = new Date();
        var ToEndDate = new Date();

        $('.from').datepicker({
            autoclose: true,
            minViewMode: 0,
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            $('.to').datepicker('setStartDate', startDate);
        }); 

        $('.to').datepicker({
            autoclose: true,
            minViewMode: 0,
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(selected){
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
            $('.from').datepicker('setEndDate', FromEndDate);
        });
     </script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>