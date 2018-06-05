<!DOCTYPE html>
<html lang="es">
<head>
	<title>Alta usuario</title>
	<meta charset="utf-8" />
	<?php include("cdns.php");  ?>
</head> 
<body>
<?php// Insertamos la barra de menú con las opciones
    //include("barra-menu.php");
?>
	<div class="jumbotron text-center">
			<h1>Alta de usuario</h1>
	</div>
	
	<div class="container">
		<div class="row"> <!-- 12 filas de división -->
			<div class="col-sm-6 offset-sm-3 text-center">
				<form method="post" action="alta_usuario.php">
				<div class="form-group text-left">
					<label for="nombre">Nombre de usuario</label>
					<input class="form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese nombre" />
				</div>
				<div class="form-group text-left">
					<label for="correo">Correo electrónico</label>
					<input class="form-control" type="text" name="correo" id="correo" placeholder="Email" />
				</div>
				
				<div class="form-group text-left">
					<label for="pass">Contraseña</label>
					<input class="form-control" type="password" name="pass" id="pass"  />
				</div>
				
				<div class="form-group text-left">
					<label for="tipo">Tipo usuario</label>
					<select name="tipo" id="tipo">
						<option value="1">Alumno</option>
						<option value="2">Profesor</option>
					</select>
				</div>
				
				
				
								
				<div class="form-group text-center">				
					<button class="btn btn-danger" type="reset"><i class="fas fa-ban fa-1x"></i> Limpiar</button>
<button class="btn btn-primary" type="submit"><i class="fas fa-save fa-1x"></i> Guardar</button>
				</div>
				</form>
			</div>
		</div>
	</div>


</body>
</html>
