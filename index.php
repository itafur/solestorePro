<?php 
    session_start();
    if ($_SESSION) {
        header("Location: app/principal.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sole Store</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">	
	<link rel="stylesheet" type="text/css" href="css/style_owner.css">
	<style type="text/css">

		#showMessageLoginConecting {

			display: none;

		}

		#showMessageLoginIncorrect {

			display: none;

		}

		#showMessageLoginEmpty {

			display: none;

		}

		#showMessageLoginBlocked {

			display: none;

		}

		#showMessageLoginFail {

			display: none;

		}

	</style>
</head>
<body class="body">
	
	<div class="container well" id="sha">
		<div class="row">
					<div class="col-xs-12 logo-main">
						<span class="glyphicon glyphicon-shopping-cart"></span>
						<h3 class="text-center"><i>SOLE STORE</i></h3>
					</div>
		</div> 

		<form class="login" action="#" method="POST">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Usuario" id="username" autocomplete="off">
				</div>
				

				<div class="form-group">
					<input type="password" class="form-control" placeholder="Contraseña" id="password">
				</div>

				<div class="alert alert-info centerText" id="showMessageLoginConecting" role="alert">Conectando con Servidor...</div>

				<div class="alert alert-danger centerText" id="showMessageLoginIncorrect" role="alert">Usuario o Contraseña incorrecta</div>

				<div class="alert alert-danger centerText" id="showMessageLoginEmpty" role="alert">Por favor ingrese el usuario y la contraseña</div>

				<div class="alert alert-warning centerText" id="showMessageLoginBlocked" role="alert">Su Cuenta se encuentra bloqueada. Comuniquese con el Administrador</div>

				<div class="alert alert-danger centerText" id="showMessageLoginFail" role="alert">Error de Conectividad - Reintente</div>


				<button id="btnAccess" class="btn btn-lg btn-default btn-block">Acceder</button>

	    </form>
		
	</div>

	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/processLogin.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>