<?php

if (!isset($_SESSION)) {
	session_start();
}

	if (file_exists("directorio_raiz.php")) { // en caso de estar en directorio principal ruta añadida es vacio
		$ruta_aniade = '';		
	}
	else {  
// en caso contrario estamos en un subdirectorio de directorio principal, por lo que ruta añadida
// debe incluir subir un nivel
		$ruta_aniade ='../';	
	}

	$error=0;

	if (!isset($_SESSION['usuario']) ) {	// NO es un usuario dado de alta en el sistema
		$error=2;
	}
	else if ($_SESSION['tipoUser'] != 1) {  // No es un alumno
		$error=3;    	
	}

	$destino = $ruta_aniade.'login_usuario.php?error='.$error;
	if ($error != 0) {
	// Cerramos la actual sesión
		$_SESSION = array();
		session_regenerate_id(true);
		session_destroy();
	// Reenviamos a la página de validación mostrando el errorheader("location:$destino");
		header("location:$destino");
	}



?>
