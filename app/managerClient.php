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
    #showMessageSendingPassword {
      display: none;
    }
    #showMessageSuccessfullPassword {
      display: none;
    }
    #showMessageFailPassword {
      display: none;
    }
    #showMessageSendingUpdate {
      display: none;
    }
    #showMessageSuccessfullUpdate {
      display: none;
    }
    #showMessageFailUpdate {
      display: none;
    }
    #showMessageSendingDelete {
      display: none; 
    }
    #showMessageSuccessfullDelete {
      display: none;
    }
    #showMessageSuccessfullDelete {
      display: none;
    }
    #showMessageFailDelete {
      display: none;
    }
    #showMessagePendingDelete {
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
<body class="bodyColor" ng-app ng-controller="ControladorFiltros">

     <?php include('header.php'); ?>

        <div class="container">
            <div class="panel panel-primary panel-home">
                <div class="panel-heading centerText">
                    <h3 class="panel-title"><strong>ADMINISTRACION DE CLIENTES</strong></h3>
                </div>
                <div class="panel-body property-body">
                    <div class="centerText">
                        <a class="pointer" data-target="#modalNewClient" data-toggle="modal" data-whatever="@fat">
                          <span class='glyphicon glyphicon-plus-sign btn-lg colorGreen' aria-hidden='true'></span>
                        </a>
                        <input type="text" class="form-control" placeholder="Buscar Cliente por Nombre, Por Ejemplo: Carlos" ng-model="buscar.nombre">
                        <br/>
                    </div>
                    <div class="panel panel-default list">
                        <div class="table-responsive">
                            <table class="table table-bordered centerText">
                                <thead>
                                    <tr class="bold">
                                      <td>Nombre</td>
                                      <td>Usuario</td>
                                      <td>Correo Electronico</td>
                                      <td>Activo</td>
                                      <td>Editar</td>
                                      <td>Cambiar Clave</td>
                                      <td>Eliminar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="cliente in clientes | filter:buscar">
                                    <td>{{cliente.nombre}}</td>
                                    <td>{{cliente.username}}</td>
                                    <td>{{cliente.correo}}</td>
                                    <td>
                                        <div ng-if="cliente.estado == 'SI' ">
                                            <span class="label label-success">SI</span>
                                        </div>
                                        <div ng-if="cliente.estado == 'NO' ">
                                            <span class="label label-default">NO</span>
                                        </div>
                                    </td>
                                    <td>
                                      <a class="pointer" data-target="#modalEditClient" data-toggle="modal" data-id="{{cliente.id}}" data-fullname="{{cliente.nombre}}" data-email="{{cliente.correo}}" data-state="{{cliente.estado}}" data-whatever="@fat"><span class="glyphicon glyphicon-pencil colorEdit"></span></a>
                                    </td>
                                    <td>
                                      <a class="pointer" data-target="#modalChangePassword" data-toggle="modal" data-id="{{cliente.id}}"><span class="glyphicon glyphicon-user colorEdit"></span></a>
                                    </td>
                                    <td>
                                      <a class="pointer" data-target="#modalUserDelete" data-toggle="modal" data-id="{{cliente.id}}" data-name="{{cliente.nombre}}"><span class="glyphicon glyphicon-remove-sign colorRed"></span></a>  
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalNewClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText register-client">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Registro de Cliente</h4>
              </div>
              <div class="modal-body">
                  <form class="form-vertical" action="#" method="POST">
                    <div class="form-group">
                      <label class="control-label">Nombre Completo:</label>
                      <input type="text" class="form-control" ng-model="cliente.fullname"id="fullname" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Email:</label>
                      <input type="text" class="form-control"  id="email" ng-model="cliente.email">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Usuario:</label>
                      <input type="text" class="form-control" id="username" ng-model="cliente.username" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Contraseña:</label>
                      <input type="password" class="form-control"  id="password" ng-model="cliente.password">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Confirmar Contraseña:</label>
                      <input type="password" class="form-control"  id="confirmPassword" ng-model="cliente.confirmPassword">
                    </div>

                    <div class="group-action">
                      <button id="btnAddClient" type="button" class="btn btn-success btn-block" ng-click="agregarCliente()">Registrar</button>
                    </div>

                    <div class="alert alert-info centerText" id="showMessageSending" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText" id="showMessageSuccessfull" role="alert">
                       <strong>Usuario Creado</strong>
                    </div>
                    <div class="alert alert-danger centerText" id="showMessageFail" role="alert"></div>

                  </form>
              </div>    
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalEditClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText register-client">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Actualización de Cliente</h4>
              </div>
              <div class="modal-body">
                  <form class="login" action="#" method="POST">
                    <div class="form-group">
                      <label class="control-label">Nombre Completo:</label>
                      <input type="text" class="form-control" ng-model="cliente.fullname"id="fullname" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Email:</label>
                      <input type="text" class="form-control"  id="email" ng-model="cliente.email">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Activo:</label>
                      <select id="state" class="form-control">
                          <option value="1">SI</option>
                          <option value="0">NO</option>
                      </select>
                    </div>

                    <div class="group-action">
                      <button type="button" class="btn btn-success btn-block" ng-click="actualizarCliente()">Guardar Cambios</button>
                    </div>

                    <div class="alert alert-info centerText" id="showMessageSendingUpdate" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText" id="showMessageSuccessfullUpdate" role="alert">
                       <strong>El usuario fue actualizado</strong>
                    </div>
                    <div class="alert alert-danger centerText" id="showMessageFailUpdate" role="alert"></div>

                  </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText register-client">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Modificación de Clave</h4>
              </div>
              <div class="modal-body">
                  <form class="login" action="#" method="POST">
                    <div class="form-group">
                      <label class="control-label">Nueva Contraseña:</label>
                      <input type="password" class="form-control" id="password" ng-model="cliente.password">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Confirmar Contraseña:</label>
                      <input type="password" class="form-control" id="confirmPassword" ng-model="cliente.confirmPassword">
                    </div>
                    
                    <div class="group-action">
                      <button type="button" class="btn btn-success btn-block" ng-click="cambiarClave()">Autorizar</button>
                    </div>

                    <div class="alert alert-info centerText" id="showMessageSendingPassword" role="alert">
                      <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                    </div>
                    <div class="alert alert-success centerText" id="showMessageSuccessfullPassword" role="alert">
                       <strong>La contraseña fue actualizada</strong>
                    </div>
                    <div class="alert alert-danger centerText" id="showMessageFailPassword" role="alert"></div>

                  </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalUserDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header centerText manage-cancel">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="colorWhite" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">¿Esta seguro que desea eliminar el Usuario?</h4>
              </div>
              <div class="modal-body">

                  <form class="login" action="#" method="POST">
                      <div class="form-group centerText">
                          <label class="control-label">Nombre: </label>
                          <span id="nameToDelete"></span>
                      </div>

                      <div class="form-group centerText">
                          <p class="text-danger" align="justify">
                            <b>Nota:</b> Verifique que realmente desea eliminar el usuario, pues una vez realizada la operación no hay manera de reversar la acción.
                          </p>
                      </div>

                      <div class="group-action centerText">
                          <button type="button" class="btn btn-danger" ng-click="deleteUser()">
                          <span class="glyphicon glyphicon-minus-sign"></span> Eliminar
                        </button>
                      </div>

                      <div class="alert alert-info centerText" id="showMessageSendingDelete" role="alert">
                            <span class="glyphicon glyphicon-hourglass"></span> Por favor espere...
                          </div>
                          <div class="alert alert-success centerText" id="showMessageSuccessfullDelete" role="alert">
                             <strong>El usuario fue eliminado</strong>
                             <label class="glyphicon glyphicon-ok-sign"></label>
                          </div>
                          <div class="alert alert-danger centerText" id="showMessageFailDelete" role="alert"></div>
                          <div class="alert alert-info centerText" id="showMessagePendingDelete" role="alert">No es posible eliminar al usuario, debido a que tiene un saldo pendiente</div>

                    </form>

              </div>
            </div>
          </div>
        </div>
     	
     
	
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script src="../js/angular-1.2.5.min.js"></script>
     <script src="../js/angular-locale_es-es.js"></script>
     <script src="../js/loadClientList.js"></script>
     <!--<script src="../js/manageClient.js"></script>-->
	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="../js/processLogout.js"></script>

</body>
</html>