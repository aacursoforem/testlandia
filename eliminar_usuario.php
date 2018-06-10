<?php
	require("verifica_profesor.php");


	if (isset($_GET['cod'])) {

	// Conectamos a la base de datos 
		include("conexion.php");
	
	// Cogemos el valor de la variable llamada id que aparece junto al nombre de este script en la barra de direcciones
		$id = $_GET['cod'];
	// Preparamos la sentencia para borrar el usuario con id = $id (= $_GET['id'])
		$sql = "DELETE FROM usuarios WHERE id=$id" or die ("No se pudo borrar el registro");
	// Ejecutamos la sentencia de borrado
		mysqli_query($conexion, $sql);
	// Cerramos la conexión a la base de datos
		mysqli_close($conexion);
	// Tras borrar el dato, redirigimos el navegador a la web del listado con el código de control 2 (se borró de forma correcta el dato de la tabla)
		header("location:listado_usuarios.php?control=2");
	} else {
		header("location:listado_usuarios.php?control=-2");
	
	}


?>
