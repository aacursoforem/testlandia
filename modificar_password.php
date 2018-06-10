<?php	// Verificamos que el visitante está correctamente logueado
	//include("verifica_user.php");  
	require("verifica_profesor.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Modificación password</title>
	<meta charset="utf-8" />
<?php
		include("cdn_local.php");
		echo"</head>\n<body>\n";

	// Conectamos a la base de datos
	include("conexion.php");

if (isset($_GET['id'])) {
	$id = $_GET['id'];

// Preparamos la sentencia que devolverá los datos del cliente cuyo dni es el pasado
	$sql = "SELECT * FROM usuarios WHERE id=$id" ;
	//echo $sql;
	// Ejecutamos la consulta obteniendo el vector $registro con el resultado 
	$registro = mysqli_query($conexion, $sql) or die("No existe el usuario en la base de datos");
	// Del resultSet obtenido en la consulta, asignamos a $reg una fila de resultados como un array asociativo
	$reg = mysqli_fetch_assoc($registro);  // Obtener una fila de resultados como un array asociativo
	//$reg = mysqli_fetch_array($registro);  // Obtiene una fila de resultados como un array asociativo, numérico, o ambos
	//$reg = mysqli_fetch_row($registro);  // Obtener una fila de resultados como un array enumerado
	
	// Guardamos en distintas variables las partes del resultSet devuelvo como respuesta a nuestra consulta a la base de datos 
	$id = $reg['id'];
	$nombre = $reg['nombre'];
	//$contra = $reg['contra'];	
	//$tipo = $reg['tipo'];
	
	// Ya podemos cerrar la conexión con la base de datos
	mysqli_close($conexion);
	
	// Mostramos el formulario con los valores del registro a modificar obtenidos antes de la BD
	?>
	<body>
		<div class="jumbotron text-center">
			<h1>Modificación de contraseña</h1>
		</div>
	<div class="container">
		<div class="row"> <!-- 12 filas de división -->
			<div class="col-sm-6 offset-sm-3 text-center">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">		
				
				<div class="form-group text-left">
						<label for="id">Id</label>
						<input class="form-control" type="text" name="id" id="id" value="<?php echo $id; ?>" readonly="readonly" />
					</div>
				
				<div class="form-group text-left">
						<label for="user">Usuario</label>
						<input class="form-control" type="text" name="user" id="user" value="<?php echo $nombre; ?>" readonly="readonly"  />
				</div>
				
				<div class="form-group text-left">
						<label for="pass1">Nueva contraseña</label>
						<input class="form-control" type="password" name="pass1" id="pass2" />
				</div>
				
				<div class="form-group text-left">
						<label for="user">Repita la contraseña</label>
						<input class="form-control" type="password" name="pass2" id="pass2" />
				</div>
				
			
				<div class="form-group text-center">
					<!-- <button class="btn btn-danger" type="reset"><i class="fas fa-ban fa-1x"></i> Cancelar</button>  -->
					<a href="listado_usuarios.php" class="btn btn-primary" role="button"><i class="fas fa-arrow-left fa-1x"></i> Volver</a>
					
					<button class="btn btn-primary" type="submit"><i class="fas fa-save fa-1x"></i> Cambiar</button>
					
				</div>
				</form>
			</div>
		</div>
	</div>


<?php

} else if (isset($_POST['user'])) { 
		
	print_r($_POST);
	// Cogemos los datos que nos llega desde el formulario
	$id = $_POST['id'];
	$usuario = $_POST['user'];
	$passUno = $_POST['pass1'];
	$passDos = $_POST['pass2'];
	
	if ($passUno == $passDos) {		
		$pass_cifrada = md5($passUno);		
		// Creamos la sentencia de acción SQL para actualizar la contraseña
		$sql = "UPDATE usuarios SET pass='$pass_cifrada' WHERE id=$id AND nombre='$usuario' ;";		
		// Ejecutamos la sentencia de acción anterior
		echo $sql;
		mysqli_query($conexion, $sql) or die ("No ha sido posible actualizar el dato");
		// Cerramos la conexión a la base de datos
		mysqli_close($conexion);
		$control = 4;
	}	else {
		$control = -4;
		echo'<h3>Las contraseñas introducidas son diferentes. Vuelva a intentarlo</h3>';		
	}

	// Redireccionamos tras haber realizado la actualización del cliente en la BD
	header("location:listado_usuarios.php?control=$control");
	// Para pruebas, sustituimos la anterior redirección por un enlace equivalente
	//echo'<p><a href="listado_usuarios.php?control='.$control.'">Ir al listado</a></p>';
}
?>

</body>
</html>
