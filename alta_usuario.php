<?php

if (isset($_POST['nombre'])) {

	$nombre = $_POST['nombre'];
	$correo = $_POST['correo'];
	$pass = $_POST['pass'];
	$pass_cifrada = md5($pass);
	$tipo = $_POST['tipo'];

// Conectamos a la base de datos. Esto crea la variable $conexion asignandole el identificador de una conexión a la BD
	include("conexion.php");
	
	// Buscamos si ya existe un usuario con ese mismo email
	$sql_1 = "SELECT id FROM usuarios WHERE email='$correo' LIMIT 1";
	$busqueda = mysqli_query($conexion, $sql_1) or die(mysqli_error($conexion));
	$num_resultados = mysqli_num_rows($busqueda);
	if ($num_resultados > 0) { // Ya existe un usuario en la BD con ese correo electrónico
		echo "Ya existe el usuario";
		$codigoDevuelto = -1;
	
	} else {  // no existe un usuario con ese correo. Damos de alta el nuevo usuario
		$sql = "INSERT INTO usuarios (nombre, email, pass, tipo) VALUES ('$nombre', '$correo', '$pass_cifrada', '$tipo')" ;		
		$codigoDevuelto = 1;
		// Ejecutamos la sentencia de acción anterior
		mysqli_query($conexion, $sql) or die ("No ha sido posible dar el alta".mysqli_error($conexion)) ;	
	}
	
	// Cerramos la conexión a la base de datos
		mysqli_close($conexion);
		// Hacemos una redirección a la página listado_clientes.php con el parámetro control=1 que indica que se ha introducido sin problemas el nuevo producto en la base de datos
		header("location:resultado.php?control=".$codigoDevuelto);


}	
	