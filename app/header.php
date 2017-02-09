<div class="navbar navbar-default navbar-fixed-top navBarColor">
         <div class="container">
         	<a class="navbar-brand main">
         	    <div class="logo logo-second"><span class="glyphicon glyphicon-shopping-cart "></span></div>
         	    <h6 class="autenticathed"><strong>
         	        <?php session_start(); echo utf8_encode(strtoupper($_SESSION['FULLNAME'])); ?></strong></h6> </a>
         	<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
         		<span class="icon-bar"></span>
         		<span class="icon-bar"></span>
         		<span class="icon-bar"></span>
         	</button>
         	<div class="collapse navbar-collapse navHeaderCollapse">
         		<ul class="nav navbar-nav navbar-right">
         		    <?php if ($_SESSION['ROLE'] == "2") { ?>
         		    <li></small><a href="principal">Inicio</a></li>
         			<li class="dropdown">
         				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Compras <b class="caret"></b></a>
         				<ul class="dropdown-menu">
         					<li><a href="purchase">Nueva Compra</a></li>
         					<li><a href="consult">Consultas</a></li>
         				</ul>
         			</li>
                    <?php } else if ($_SESSION['ROLE'] == "1") { ?>
                    <li></small><a href="principal">Inicio</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="managerClient">Usuarios</a></li>
                            <li><a href="managerGroser">Inventario</a></li>
                            <li><a href="confirmPay">Confirmar Pago</a></li>
                            <li><a href="sale">Nueva Venta</a></li>
                            <li><a href="manageCancel">Cancelar Gestión</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="billState">Estado de Cuentas</a></li>
                            <li><a href="reportBuyes">Reporte de Compras</a></li>
                        </ul>
                    </li>
                    <?php } else if ($_SESSION['ROLE'] == "3") { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><!--<span class="glyphicon glyphicon glyphicon-certificate colorNew" aria-hidden="true"></span>--> Ventas <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="newSale">Nueva Venta</a></li>
                            <!--<li><a href="reportBuyes.php">Estado de Caja</a></li>-->
                        </ul>
                    </li>
                    <?php } ?>
                    
                    <li></small><a class="pointer" data-toggle="modal" data-target=".exampleModal" data-whatever="@fat">Cerrar Sesión</a></li>
         		</ul>
         	</div>
         </div>
     </div>

     <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header color-black">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">¿Realmente Desea Salir?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a id="processLogout" class="btn color-black">Aceptar</a>
                </div>
            </div>
        </div>
    </div>

<div><label id="ID_SESSION"><?php echo $_SESSION['ID']; ?></label><div>
