<?php
	session_start();
// Comprobamos si estamos en el directorio principal de la aplicación
// mirando si en la actual ubicación existe el fichero cdns.php
if (file_exists("cdns.php")) { // en caso de estar en directorio principal ruta añadida es vacio
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
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	  <li class="nav-item dropdown"><a class="nav-link" href="#">Opción uno</a></li>      	  
      <li class="nav-item active"><a class="nav-link" href="#">Opción dos</a></li>      
    </ul>
	
	<ul class="navbar-nav navbar-right">
';
	if (isset($_SESSION['usuario'])) {
		echo '<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar</a></li>';
	} else {
		echo'<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'login_usuario.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
		echo'<li class="nav-item active"><a class="nav-link" href="'.$ruta_aniade.'form_alta_usuario.php">Registro</a></li>';
	}
	echo'</ul></div></nav>';
	
?>