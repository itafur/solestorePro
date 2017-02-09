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
<body class="bodyColor" ng-app ng-controller="ControllerGroser">

     <?php include('header.php'); ?>

        <div class="container">
            <div class="panel panel-primary panel-home">
                <div class="panel-heading centerText">
                    <h3 class="panel-title"><strong>ADMINISTRACION DE TIENDA</strong></h3>
                </div>
                <div class="panel-body property-body">
                    <div class="centerText">
                        <a class="pointer" data-target="#modalNewProduct" data-toggle="modal" data-whatever="@fat">
                          <span class='glyphicon glyphicon-plus-sign btn-lg colorGreen' aria-hidden='true'></span>
                        </a>
                        <input type="text" class="form-control" placeholder="Realizar búsqueda en general" ng-model="buscar">
                        <br/>
                    </div>
                    <div class="panel panel-default list">
                        <div class="table-responsive">
                            <table class="table table-bordered centerText">
                                <thead>
                                    <tr class="bold">
                                      <td>Código</td>
                                      <td>Producto</td>
                                      <td>Precio Unitario</td>
                                      <td>Stock</td>
                                      <td>SubTotal</td>
                                      <td>Activo</td>
                                      <td>Editar</td>
                                      <td>Abastecer</td>
                                      <td>Eliminar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="item in products | filter:buscar">
                                    <td>{{item.code}}</td>
                                    <td>{{item.product}}</td>
                                    <td>$ {{item.price_unitary | number:0}}</td>
                                    <td>{{item.stock}}</td>
                                    <td>$ {{item.price_unitary * item.stock | number:0}}</td>
                                    <td>
                                        <div ng-if="item.enabled == 'SI' ">
                                            <span class="label label-success">SI</span>
                                        </div>
                                        <div ng-if="item.enabled == 'NO' ">
                                            <span class="label label-default">NO</span>
                                        </div>
                                    </td>
                                    <td>
                                      <a class="pointer" data-target="#modalEditProduct" data-toggle="modal" data-id="{{item.code}}" data-product="{{item.product}}" data-price="{{item.price_unitary}}" data-stock="{{item.stock}}" data-enabled="{{item.enabled}}" data-whatever="@fat"><span class="glyphicon glyphicon-pencil colorProduct"></span></a>
                                    </td>
                                    <td>
                                      <a class="pointer" data-target="#modalShopSupply" data-toggle="modal" data-id="{{item.code}}" data-product="{{item.product}}" data-whatever="@fat"><span class="glyphicon glyphicon-briefcase colorProduct"></span></a>
                                    </td>
                                    <td>
                                      <a class="pointer" data-target="#modalProductDelete" data-toggle="modal" data-id="{{item.code}}" data-name="{{item.product}}"><span class="glyphicon glyphicon-remove-sign colorRed"></span></a>  
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row rowTop">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <h3><label class="label label-primary">TOTAL SALDOS: $ {{ totalGroser | number:0}}</label></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalNewProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText register-client">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Registro de Producto</h4>
              </div>
              <div class="modal-body">
                  <form class="login" action="#" method="POST">
                    <div class="form-group">
                      <label class="control-label">Producto:</label>
                      <input type="text" class="form-control" ng-model="product.product" id="product" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Precio Unitario:</label>
                      <input type="text" class="form-control" id="price" ng-model="product.price_unitary" onkeypress="return onlyNumeric(event)" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Cantidad:</label>
                      <input type="text" class="form-control"  id="stock" ng-model="product.stock" onkeypress="return onlyNumeric(event)" autocomplete="off" maxlength="4">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Disponible:</label>
                      <select id="enabled" class="form-control">
                          <option value="1">SI</option>
                          <option value="0">NO</option>
                      </select>
                    </div>

                    <div class="group-action">
                      <button type="button" class="btn btn-success btn-block" ng-click="addProduct()">Registrar</button>
                    </div>

                    <div class="alert alert-info centerText showMessageSending" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText showMessageSuccessfull" role="alert">
                       <strong>Producto Creado</strong>
                    </div>
                    <div class="alert alert-danger centerText showMessageFail" role="alert"></div>

                  </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText register-client">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Actualización de Producto</h4>
              </div>
              <div class="modal-body">
                  <form class="login" action="#" method="POST">
                    <div class="form-group">
                      <label class="control-label">Producto:</label>
                      <input type="text" class="form-control" ng-model="product.product" id="product" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Precio Unitario:</label>
                      <input type="text" class="form-control"  id="price" ng-model="product.price_unitary" onkeypress="return onlyNumeric(event)" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Cantidad:</label>
                      <input type="text" class="form-control"  id="stock" ng-model="product.stock" onkeypress="return onlyNumeric(event)" autocomplete="off" maxlength="4">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Disponible:</label>
                      <select id="enabledUpdate" class="form-control">
                          <option value="1">SI</option>
                          <option value="0">NO</option>
                      </select>
                    </div>

                    <div class="group-action">
                      <button type="button" class="btn btn-success btn-block" ng-click="updateProduct()">Guardar Cambios</button>
                    </div>

                    <div class="alert alert-info centerText showMessageSending" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText showMessageSuccessfull" role="alert">
                       <strong>El producto fue actualizado</strong>
                    </div>
                    <div class="alert alert-danger centerText showMessageFail" role="alert"></div>

                  </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalShopSupply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText register-client">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Abastecimiento de Producto</h4>
              </div>
              <div class="modal-body">
                  <form class="login" action="#" method="POST">
                    <div class="form-group">
                      <label class="control-label">Producto:</label>
                      <input type="text" class="form-control" id="product" ng-model="product.product" readonly="readonly">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Cantidad:</label>
                      <input type="text" class="form-control" id="cantidad" ng-model="product.stock" onkeypress="return onlyNumeric(event)" autocomplete="off">
                    </div>
                    
                    <div class="group-action">
                      <button type="button" class="btn btn-success btn-block"  ng-click="supplyProduct()">Registrar</button>
                    </div>

                    <div class="alert alert-info centerText showMessageSending" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText showMessageSuccessfull" role="alert">
                       <strong>Abastecimiento finalizado</strong>
                    </div>
                    <div class="alert alert-danger centerText showMessageFail" role="alert"></div>

                  </form>
              </div>
            </div>
          </div>
        </div>


        <div class="modal fade" id="modalProductDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText manage-cancel">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">¿Esta seguro que desea eliminar el Producto?</h4>
              </div>
              <div class="modal-body">

                  <form class="login" action="#" method="POST">
                      <div class="form-group centerText">
                          <label class="control-label">Producto: </label>
                          <span id="nameToDelete"></span>
                      </div>

                      <div class="form-group centerText">
                          <p class="text-danger" align="justify">
                            <b>Nota:</b> Verifique que realmente desea eliminar el producto, pues una vez realizada la operación no hay manera de reversar la acción.
                          </p>
                      </div>

                      <div class="group-action centerText">
                          <button type="button" class="btn btn-danger" ng-click="deleteProduct()">
                          <span class="glyphicon glyphicon-minus-sign"></span> Eliminar
                        </button>
                      </div>

                      <div class="alert alert-info centerText showMessageSending" role="alert">
                            <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                          </div>
                          <div class="alert alert-success centerText showMessageSuccessfull" role="alert">
                             <strong>El producto fue eliminado</strong>
                             <label class="glyphicon glyphicon-ok-sign"></label>
                          </div>
                          <div class="alert alert-danger centerText showMessageFail" role="alert"></div>

                    </form>

              </div>
            </div>
          </div>
        </div>
     	
     
	
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/loadProductList.js"></script>
     <script type="text/javascript">
          // Solo permite ingresar numeros.showMessageSuccessfull
            function onlyNumeric(e){
                var key = window.Event ? e.which : e.keyCode
                return (key >= 48 && key <= 57)
            }
     </script>
	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>