<?php	// Verificamos que el visitante tiene credencial de administrador
	//include("verifica_admin.php");  ?>
<!DOCTYPE html>
<html lang="es">
<head
	<title>Listado de Usuarios</title>
	<meta charset="utf-8" /> 
	
	<?php include("cdns.php"); 	?>


<script type="text/javascript">
	function confirmaModificar(codigo, nombre) {
		var respuesta= confirm("¿Está seguro de que quiere modificar los datos del usuario "+nombre+" ?");
		if (respuesta == true) {
			//alert("has aceptado modificar");
			location.href="modificar_usuario.php?id="+codigo;			
		}
		else {
			alert("Has elegido que no modificar");
		}
	}


	function confirmaEliminar(codigo, nombre) {
			var respuesta = confirm("¿Está seguro de que quiere ELIMINAR al usuario "+nombre+"?");
			if (respuesta == true) {
				//alert("Has aceptado eliminar el usuario.");
				location.href="eliminar_usuario.php?cod="+codigo;
			} else {
				alert("Has declinado eliminar al usuario");
			}
	}
</script>
	
</head> 

<body>
<?php   include("barra-menu.php");  ?>
	<div class="jumbotron text-center">
			<h1>Listado de usuarios</h1>
	</div>
	
	<div class="container">
		<div class="row" style="padding-bottom:10px;">
			<div class="col-sm-6 text-left">
			<?php
			// En caso de que la llamada al fichero incluya una variable de nombre control,
			// dependiendo del valor que tome ésta mostraremos uno u otro mensaje al usuario
				if (isset($_REQUEST['control'])) {
					$control = $_REQUEST['control'];
					//echo'<p style="color:red">El valor de control es: '.$control.'</p>';
					$mensaje =''; $tipoMensaje='success';
					switch ($control)  {
						case -1 : $mensaje='Error: El usuario ya existe en la base de datos'; $tipoMensaje = 'danger';  break;
						case 1 : $mensaje='Alta usuario realizada con éxito'; $tipoMensaje = 'success';  break;					
						case -2 : $mensaje='Usuario no pudo ser eliminado'; $tipoMensaje = 'danger';  break;
						case 2 : $mensaje='Usuario eliminado correctamente'; $tipoMensaje = 'success';  break;
						case 3 : $mensaje='Usuario actualizado correctamente';  $tipoMensaje = 'success'; break;
						case 4 : $mensaje='La contraseña del usuario se actualizó.';  $tipoMensaje = 'success'; break;
						case -4 : $mensaje='Error: Contraseñas introducidas son diferentes.';  $tipoMensaje = 'danger'; break;
						
										
					}
					echo '<p class="alert alert-'.$tipoMensaje.'">'.$mensaje.'</p>';	
				} 
			?>
			</div>
		
			<div class="col-sm-6 text-right">
				<a href="form_alta_usuario.php" class="btn btn-primary">Nuevo Usuario</a>
				<a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left fa-1x"></i> Panel de Gestión</a>
			</div>		
		</div>
	</div>
	
	
	<!-- Mostramos la cabecera de la tabla -->
	<div class="container">
	<table class="table table-striped text-center">
	<thead class="thead-dark">
		<tr>
			<th>Id</th>
			<th>Usuario</th>	
			<th>Correo electrónico</th>					
			<th>Tipo</th>
			<th>Modificar</th>
			<th>Eliminar</th>
			<th>Password</th>
		</tr>
	<thead>
	<tbody>
<?php
	// Conectamos a la base de datos
	include("conexion.php");	
	
	// Preparamos la consulta a realizar. Una consulta de selección devuelve un resultSet 
	$sql = "SELECT * FROM usuarios" ;
	// or die(mysqli_errno($conexion) . mysqli_error($conexion));
	
	// Ejecutamos la consulta y guardamos el resultSet que devuelve en la variable -$registros-)
	$registros = mysqli_query($conexion, $sql) or die ("Error buscando usuarios");
	// Con el resultSet guardado ya en la variable $registros, podemos cerrar la conexión a la BD
	mysqli_close($conexion);
	
	// Recorremos el resultSet para ir extrayendo/mostrando los resultados devueltos
	// Vamos añadiendo a la celda de la tabla el dato tomado del correspondiente valor
	// guardado en el variable $reg
	$tiposUsuario = array(1=>"Alumno", 2=>"Profesor");
	while ( $reg = mysqli_fetch_array($registros) ) {
		?>
	<tr>
			<th><?php echo $reg['id']; ?> </th>
			<td><?php echo $reg['nombre']; ?> </td>
			<td><?php echo $reg['email']; ?> </td>
			<?php   /* echo '<td>'.$reg['contra'].'</td>'; */?>			
			<td><?php echo $tiposUsuario[$reg['tipo']]; ?></td>
			<td><a href="javascript:confirmaModificar(<?php echo $reg['id'];?>, '<?php echo $reg['nombre']; ?>')"><i class="fas fa-edit"></i></a> </td>

			<td><a href="javascript:confirmaEliminar(<?php echo $reg['id'];?>, '<?php echo $reg['nombre']; ?>')"><i class="fas fa-trash-alt"></i></a> </td>

			<td><a href="modificar_password.php?id=<?php echo $reg['id'];?>"><i class="fas fa-key fa-1x"></i> Cambiar contraseña</a></td>
		</tr>
	<?php
	}  // fin while
	// Liberamos los recursos utilizados por mysqli
	mysqli_free_result($registros);
	?>

	</tbody>
	</table>
		<div class="footer text-center">
			<p>Creado por mi Mismo</p>
		</div>
	</div>
</body>
</html>

