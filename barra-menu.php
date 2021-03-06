<?php
if (!isset($_SESSION)) {
	session_start();
}
// Comprobamos si estamos en el directorio principal de la aplicación
// mirando si en la actual ubicación existe el fichero cdns.php
if (file_exists("directorio_raiz.php")) { // en caso de estar en directorio principal ruta añadida es vacio
	$ruta_aniade = '';	
}
else {  
// en caso contrario estamos en un subdirectorio de directorio principal, por lo que ruta añadida
// debe incluir subir un nivel
		$ruta_aniade ='../';	
}
 // Otra forma de realizar lo anterior (saber si estamos en directorio principal o uno de sus subdirectorios es
 // usar getcwd() que devuelve el directorio actual, y comprobar que este termina en el nombre_directorio_principal/ en cuyo caso estaríamos en directorio_principal, y si no estamos en uno de los subdirectorios

echo'
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Testlandia</a>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">';
  if (isset($_SESSION['usuario'])) {
  	echo'<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
  <li class="nav-item dropdown"><a class="nav-link" href="'.$ruta_aniade.'listado_usuarios.php">Listado usuarios</a></li>';      	  

	if ($_SESSION['tipoUser']== 1 ) { // se trata de un alumno
		echo'<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'alumno/">Menú Alumno</a></li>  '; }
	else if ($_SESSION['tipoUser']== 2 ) { // se trata de un profesor
		echo'<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'profesor/">Menú Profesor</a></li>';
	}
echo'</ul>';
	}   	  


	echo'<ul class="navbar-nav navbar-right">';
	if (isset($_SESSION['usuario'])) {
		echo '<li class="nav-item active">Hola '.$_SESSION['usuario'].' <a class="nav-link" href="'.$ruta_aniade.'logout.php">Salir <i class="fas fa-sign-out-alt"></i></a></li>';
	} else {
		echo'<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'login_usuario.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
		echo'<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'form_alta_usuario.php">Registro</a></li>';
	}
	echo'</ul></div></nav>';
	
?>
