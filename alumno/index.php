<!DOCTYPE html>
<html lang="es">
<head>
	<title>Alumnos</title>
	<meta charset="utf-8" />
	<?php
		include("../cdns.php");  ?>
	
</head>
<body>
	<?php
/*
		echo'<pre>';
		print_r($_SERVER);
		echo'</pre>';

	echo '<p>El dirname es: '.dirname(__FILE__).'</p>';
	echo'<p>dirname(__FILE__) escrito de forma simplificada es __DIR__'. __DIR__ .'</p>';
	echo '<p>El dirname nivel 1 es: '.dirname(__FILE__ , 1); 
	echo '<p>El dirname nivel 2 es: '.dirname(__FILE__ , 2);
	echo'<p>El directorio actual es '.getcwd().'</p>';
	echo'<p>El base name del dirname es: '.basename(dirname(__FILE__)).'</p>';
	$dir_actual = basename(dirname($_SERVER['REQUEST_URI']));
*/
	?>
	<?php	include("../barra-menu.php");
	?>
	<h1>Página principal del alumno</h1>
	
	<p><a href="realizar_examen.php">Realizar examen</a></p>
	<p><a href="ver_resultados.php">Ver resultados</a></p>
	
</body>
</html>
