<!DOCTYPE html>
<html lang="es">
	<head>
	<title>Login usuario</title>
	<meta charset="utf-8" />
	<?php
		include("cdns.php");
		
		if (isset($_GET['error'])) {
			switch ($_GET['error']) {
			case 1 : $merror ='No existe el usuario'; break;	
			case 2 : $merror ='Usuario y/o contraseña no validos'; break;
			case 3: $merror='Usuario no tiene privilegios'; break;	
			
			}
		} // fin switch
		else $merror='';				
	?>
	<style type="text/css">
		.error { color: red; font-weigth: bold; }
	</style>
	</head>
	<body>
		<div class="jumbotron text-center">
			<h1>Login usuario</h1>
		</div>
		
		<div class="container">
			<div class="row"> <!-- 12 filas de división -->
				<div class="col-sm-6 offset-sm-3 text-center">
					<form method="post" action="check_usuario.php">
					
					
					<div class="form-group text-left">
						<?php echo'<p class="error">'.$merror.'</p>';   ?>
					</div>
					
					<div class="form-group text-left">
						<label for="user">Usuario</label>
						<input class="form-control" type="text" name="user" id="user" placeholder="Ingrese usuario" tabindex="1"/>
					</div>
					
					<div class="form-group text-left">
						<label for="pass">Contraseña</label>
						<input class="form-control" type="password" id="pass" name="pass" tabindex="2"/> 
					</div>
					
				
					<div class="form-group text-center">
						<button class="btn btn-danger" type="reset" tabindex="4"><i class="fas fa-ban fa-1x"></i> Limpiar</button>
						<button class="btn btn-primary" type="submit" tabindex="3"><i class="fas fa-save fa-1x"></i> Enviar</button>						
					</div>
					</form>
					
					<p>Si auún no tiene cuenta puede <a href="form_alta_usuario.php">Registrarse</a> </p>
				</div>
			</div>
				
		
		</div>
	
	
	</body>
	</html>
