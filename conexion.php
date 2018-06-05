<?php

// Para compatibilizar versiones local y clase usamos lo siguiente
// Si NO EXISTE en la carpeta superior el fichero conexion_tienda.php (estamos en servidor de clase) ejecutamos la conexión al servidor de clase
if (!file_exists("../conexion_testlandia.php")) { 
	// Conectamos a la base de datos
	$conexion = mysqli_connect("localhost", "root", "", "testlandia") or die ("Error al conectar a la base de datos");
} else {  // En caso contrario estamos en server local (home) y podemos usar el fichero de conexion a la BD de home
	require("../conexion_testlandia.php");
}

?>
