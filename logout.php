<?php

session_start();
$_SESSION = array();
session_regenerate_id(true);
session_destroy();


if (file_exists("directorio_raiz.php")) { // en caso de estar en directorio principal ruta añadida es vacio
	$ruta_aniade = '';	
}
else {  
// en caso contrario estamos en un subdirectorio de directorio principal, por lo que ruta añadida
// debe incluir subir un nivel
		$ruta_aniade ='../';	
}

if (!file_exists($ruta_aniade."cdn_local.php")) {   // Estamos en el servidor de clase. Redirigimos a localhost:8080
// clase
	header("location:http://localhost:8080/testlandia/index.php");
} else {  // estamos en servidor de casa
// local
	header("location:/cursoForem/testlandia/index.php");
}
?>
