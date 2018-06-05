<?php
//$dir_actual = basename(dirname(__FILE__));
$dir_actual = basename(dirname($_SERVER['REQUEST_URI']));
///echo '<p>El directorio actual es '.$dir_actual.'</p>';

if ( $dir_actual == 'testlandia') {
	$aniade_ruta ='';
} else if ($dir_actual =='alumno' || $dir_actual =='profesor') {
	$aniade_ruta='../';
}
// Para compatibilizar versiones local y clase usamos lo siguiente
// Si NO EXISTE en la carpeta superior el fichero conexion_tienda.php (estamos en servidor de clase) ejecutamos la conexión al servidor de clase
if (!file_exists($aniade_ruta."../conexion_testlandia.php")) { 
	// Conectamos a la base de datos
	$conexion = mysqli_connect("localhost", "root", "", "testlandia") or die ("Error al conectar a la base de datos Conex. Clase");
} else {  // En caso contrario estamos en server local (home) y podemos usar el fichero de conexion a la BD de home
	require($aniade_ruta."../conexion_testlandia.php");
}

?>
