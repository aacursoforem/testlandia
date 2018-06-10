<?php	// Verificamos que el visitante está correctamente logueado
	//include("verifica_user.php");  
	require("verifica_profesor.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Modificación usuario</title>
	<meta charset="utf-8" />
	<?php
		include("cdns.php");



	echo"\n</head>\n<body>\n";



// Conectamos a la base de datos. El fichero incluido devuelve en la variable $conexion el recurso a una conexión a la base de datos
include("conexion.php");

// Si no existe definida la variable $_POST['nombre'] mostramos el formulario
if (isset($_GET['id'])) {

	$id = $_GET['id'];

	// Preparamos la sentencia que devolverá los datos del cliente cuyo dni es el pasado
	$sql = "SELECT * FROM usuarios WHERE id=$id" ;
	// Ejecutamos la consulta obteniendo el vector $registro con el resultado 
	$registro = mysqli_query($conexion, $sql) or die("No existe el usuario en la base de datos");
	// Del resultSet obtenido en la consulta, asignamos a $reg una fila de resultados como un array asociativo
	$reg = mysqli_fetch_assoc($registro);  // Obtener una fila de resultados como un array asociativo
	//$reg = mysqli_fetch_array($registro);  // Obtiene una fila de resultados como un array asociativo, numérico, o ambos
	//$reg = mysqli_fetch_row($registro);  // Obtener una fila de resultados como un array enumerado
	
	// Guardamos en distintas variables las partes del resultSet devuelvo como respuesta a nuestra consulta a la base de datos 
	$id = $reg['id'];
	$nombre = $reg['nombre'];
	$correo = $reg['email'];
	//$contra = $reg['contra'];	
	$tipo = $reg['tipo'];
	
	// Ya podemos cerrar la conexión con la base de datos
	mysqli_close($conexion);
	
	// Mostramos el formulario con los valores del registro a modificar obtenidos antes de la BD
	?>
	<body>
		<div class="jumbotron text-center">
			<h1>Modificación de usuario</h1>
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
						<input class="form-control" type="text" name="user" id="user" value="<?php echo $nombre; ?>" />
					</div>

				<div class="form-group text-left">
						<label for="user">Correo</label>
						<input class="form-control" type="text" name="correo" id="correo" value="<?php echo $correo; ?>" />
					</div>

				<!--	
				<div class="form-group text-left">
					<label for="pass">Contraseña</label>
					<input class="form-control" type="password" id="pass" name="pass" value="<?php echo $contra; ?>"/> 
				</div>
					-->
				<div class="form-group text-left">
					<label for="type">Tipo</label>
					<select class="form-control" id="type" name="type" >
						<option value="1" <?php if ($tipo == 1) { echo'selected="selected"'; } ?>>Alumno</option>
						<option value="2" <?php if ($tipo == 2) { echo'selected="selected"'; } ?>>Profesor</option>						
					</select>						
				</div>
			
				<div class="form-group text-center">
					<!-- <button class="btn btn-danger" type="reset"><i class="fas fa-ban fa-1x"></i> Cancelar</button>  -->
					<a href="listado_usuarios.php" class="btn btn-primary" role="button"><i class="fas fa-arrow-left fa-1x"></i> Volver</a>
					
					<button class="btn btn-primary" type="submit"><i class="fas fa-save fa-1x"></i> Guardar</button>
					
				</div>
				</form>
			</div>
		</div>
	</div>
<?php
	} else if (isset($_POST['user'])) {  // Se ha introducido un dato en user
	//print_r($_POST);
	// Cogemos los datos que nos llega desde el formulario
	$id = $_POST['id'];
	$usuario = $_POST['user'];
	//$pass = $_POST['pass'];
	//$cifrada = md5($pass);
	$tipo = $_POST['type'];
	$correo = $_POST['correo'];
	
	// Creamos la sentencia de acción SQL para guardar los datos recogidos por fomulario en la base de datos
//	$sql = "UPDATE usuarios SET nombre='$usuario', contra='$cifrada', tipo=$tipo WHERE id=$id;";
	$sql = "UPDATE usuarios SET nombre='$usuario', email='$correo', tipo=$tipo WHERE id=$id;";
	// Ejecutamos la sentencia de acción anterior
	mysqli_query($conexion, $sql) or die ("No ha sido posible actualizar el dato");
		
	if (mysqli_affected_rows($conexion) == 1) {
		$control = 3;
	} else {
		$control = -3;
	}
	// Cerramos la conexión a la base de datos
	mysqli_close($conexion);
	// Redireccionamos tras haber realizado la actualización del cliente en la BD
	header("location:listado_usuarios.php?control=$control");
	// Para pruebas, sustituimos la anterior redirección por un enlace equivalente
	//echo'<p><a href="listado_usuarios.php?control='.$control.'">Ir al listado</a></p>';
}
?>

</body>
</html>
