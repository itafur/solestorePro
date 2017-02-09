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
    #showMessageSending {
      display: none;
    }
    #showMessageSuccessfull {
      display: none;
    }
    #showMessageFail {
      display: none;
    }
    .showWindowForBuy {
      display: none;
    }
    .showWindowEmpty {
      display: none;
    }
  </style>
</head>
<body class="bodyColor">

     <?php include('header.php'); ?>

     <div class="container">
          <div class="panel border-buy panel-home">
                <div class="panel-heading panel-buy2 centerText">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <!--<img src="https://cdn0.iconfinder.com/data/icons/ie_Valentine/48/love_valentines_day_1.png"></img>&nbsp;&nbsp;-->
                            <label class="title-purchase"> Nueva Compra</label>
                            <!--<img src="https://cdn3.iconfinder.com/data/icons/geest-women-kit/128/bag_icons-09-64.png"></img>-->
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <!--<div class="row">
                        <p><i><b><label class="merry">El amor y la amistad se unen para darte lo mejor</label></i></b></p>
                    </div>-->
                </div>
                <div class="panel-body">
                    
                    <div class="showWindowForBuy">
                          <form class="form-horizontal" role="form">
                            <div class="form-group">
                              <label class="col-lg-1 control-label">Producto:</label>
                              <div id="regionProduct" class="col-lg-4 has-error">
                                  <select name="producto" id="productos" class="form-control">
                                      
                                  </select>
                              </div>
                              <label class="col-lg-1 control-label">Cantidad:</label>
                              <div class="col-lg-1">
                                <input type="text" class="form-control" id="cantidad" onkeypress="return onlyNumeric(event)" autocomplete="off" maxlength="4">
                              </div>
                              <div class="col-lg-offset-1 col-lg-1">
                                <button class="btn btn-default" id="btnAddProduct">Agregar</button>
                              </div>
                              <div class="col-lg-offset-1 col-lg-1">
                                <button class="btn btn-success" id="openModal">Confirmar</button>
                              </div>
                            </div>
                          </form>

                          <div class="table-responsive" id="showDetails">
                              <table class="table" id="tableDetails">
                                    <thead>
                                          <tr>
                                              <th>CODIGO</th>
                                              <th>PRODUCTO</th>
                                              <th>CANTIDAD</th>
                                              <th>PRECIO UNITARIO</th>
                                              <th>SUBTOTAL</th>
                                              <th>ACCION</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                              </table>
                          </div>
                    </div>

                    <div class="showWindowEmpty centerText">
                          <p class="text-primary">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            No hay productos disponibles
                          </p>
                    </div>

                </div>
          </div>
     </div>

     <div class="modal fade" id="confirmBuy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Confirmar Compra</h4>
                </div>
                <div class="modal-body">
                    <span><b>¿Está seguro que desea realizar la compra?</b></span>
                </div>
                <div class="modal-footer">
                    <div id="group-action">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" id="toConfirmBuy">Confirmar</button>
                    </div>

                    <div class="alert alert-info centerText" id="showMessageSending" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText" id="showMessageSuccessfull" role="alert">
                       <strong>Felicitaciones, Compra Realizada</strong>
                       <img src="https://cdn2.iconfinder.com/data/icons/free-basic-icon-set-2/300/11-32.png">
                    </div>
                    <div class="alert alert-danger centerText" id="showMessageFail" role="alert"></div>

                </div>
            </div>
        </div>
    </div>

     
  
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/test.js"></script>
     <script type="text/javascript">
          // Solo permite ingresar numeros.
            function onlyNumeric(e){
                var key = window.Event ? e.which : e.keyCode
                return (key >= 48 && key <= 57)
            }
     </script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>