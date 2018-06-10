<?php
// Siempre antes de nada hay que iniciar la session
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login usuario</title>

</head> 
<body>
<?php
// Conectamos a la base de datos
	include("conexion.php");
	
	//print_r($_POST);
	// Cogemos los datos que nos llega desde el formulario
	$usuario = mysqli_real_escape_string($conexion,$_POST['user']);
	$pass = mysqli_real_escape_string($conexion,$_POST['pass']);
	$cifrada = md5($pass);
	
	$sql = "SELECT id, pass, tipo FROM usuarios WHERE nombre='$usuario'";
	echo $sql;
	$busquedas=mysqli_query($conexion, $sql ) or die(mysqli_error($conexion));
	$resultados = mysqli_num_rows($busquedas);
	// Cerramos la conexión a la base de datos
	mysqli_close($conexion);
	
	if ($resultados != 1) {
		echo "<p>No existe el usuario</p>";
		header("location:login_usuario.php?error=1");			
	} else {	
		$reg = mysqli_fetch_array($busquedas);
		$cifrada_bd = $reg['pass'];	
		$tipoUser = $reg['tipo'];
		if ($cifrada == $cifrada_bd) {
				$codigoDevuelto = 1;
				echo'<p>Usuario validado correctamente</p>';				
				$_SESSION['usuario'] = $usuario;
				$_SESSION['tipoUser'] = $tipoUser; 
				$_SESSION['id_usuario'] = $reg['id'];
				if ($tipoUser == 1) { // Se trata de un alumno
					header("location:alumno/index.php");
				} else if ($tipoUser == 2) {  // se trata de un profesor
					header("location:profesor/index.php");
				} else if ($tipoUser < 1  && $tipoUser > 2) {
					header("location:index.php");
				}
		} else {
			//$_SESSION['usuario'] = 'admin';
			//$_SESSION['tipoUser'] = 1;
				echo'<p>La contraseña introducida no es correcta</p>';
				header("location:login_usuario.php?error=2");
		}
	}	
?>

</body>
</html>
