<?php
	$mensa ='';
	if (isset($_GET['control'])) {
		$control = $_GET['control'];
		
		switch ($control) {
			case -1: $mensa = 'Error dando de alta al nuevo usuario. Ya existe un usuario con este correo'; break;
			case 1: $mensa = 'Usuario dado de alta de forma correcta'; break;
			case 2: $mensa ='Datos de pregunta añadidos a la base de datos'; break;
		
		}
		echo "<p>".$mensa."</p>";
		echo '<p>Pulse <a href="index.php">aquí</a> para continuar</p>';
	}
	
?>
