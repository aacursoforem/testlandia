<?php	// Verificamos que el visitante tiene credencial de administrador
	// include("verifica_admin.php");  
	session_start();
	// echo'<pre>'; print_r($_SESSION); echo'</pre>';
	$id_profe =$_SESSION['id_usuario'];
//echo '<p>El id de profesor es '.$id_profe.'</p>';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Listado de Preguntas</title>
	<meta charset="utf-8" /> 
	<?php
		include("../cdns.php");
		
		// include("cdns.php");
	?>
<style type="text/css">

	.pregunta { color: blue; }

</style>
	
</head> 

<body>
<?php   include("../barra-menu.php");  ?>
	<div class="jumbotron text-center">
			<h1>Listado de preguntas</h1>
	</div>
	
	<div class="container">
		<div class="row" style="padding-bottom:10px;">
			<div class="col-sm-6 text-left">
			<?php
			// En caso de que la llamada al fichero incluya una variable de nombre control,
			// dependiendo del valor que tome ésta mostraremos uno u otro mensaje al usuario
/*
				if (isset($_REQUEST['control'])) {
					$control = $_REQUEST['control'];
					//echo'<p style="color:red">El valor de control es: '.$control.'</p>';
					$mensaje =''; $tipoMensaje='success';
					switch ($control)  {
						case -1 : $mensaje='El DNI ya existe en la base de datos'; $tipoMensaje = 'danger';  break;
						case 1 : $mensaje='Alta realizada con éxito'; $tipoMensaje = 'success';  break;
						case 2 : $mensaje='Cliente eliminado correctamente'; $tipoMensaje = 'success';  break;
						case 3 : $mensaje='Cliente actualizado correctamente';  $tipoMensaje = 'success'; break;				
					}
					echo '<p class="alert alert-'.$tipoMensaje.'">'.$mensaje.'</p>';	
				} 
*/
			?>

			</div>
		
			<div class="col-sm-6 text-right">
				<a href="form_alta_pregunta.php" class="btn btn-primary">Nuevo Pregunta</a>
				<a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left fa-1x"></i> Panel de Gestión</a>
			</div>		
		</div>
	</div>
	
	
	<!-- Mostramos la cabecera de la tabla -->
	<div class="container">
	<table class="table  text-left">
	
<?php
	// Conectamos a la base de datos
	include "../conexion.php";	
	
	// Preparamos la consulta a realizar. Una consulta de selección devuelve un resultSet 
	$sql = "SELECT * FROM preguntas WHERE id_profe='$id_profe'";
	// or die(mysqli_errno($conexion) . mysqli_error($conexion));
	
	// Ejecutamos la consulta y guardamos el resultSet que devuelve en la variable -$registros-)
	$registros = mysqli_query($conexion, $sql)  or die ("Error buscando preguntas<br/> $sql");
	// Con el resultSet guardado ya en la variable $registros, podemos cerrar la conexión a la BD
?>

<thead class="thead-dark">
		<tr>
			<td colspan="2">Profesor: <b> <?php echo $_SESSION['usuario']; ?></b></td>
			<td colspan="3"><form id="">
				<label for="categoria">Filtras por categoría</label>
				<select id="categoria" name="categoria">
					<option value="1">Geografía</option>
					<option value="2">Sistemas operativos</option>
					<option value="3">BB.DD.</option>
					<option value="4">POO</option>
				</select>
				<button type="">Filtrar</button>
				</form>
			</td>
		</tr>
		<tr>
			<th>Id</th>
			<th>Categoría</th>
			<th>Pregunta</th>			
			<th>Modificar</th>
			<th>Eliminar</th>
		</tr>
	<thead>
	<tbody>
<?php
	
	// Recorremos el resultSet para ir extrayendo/mostrando los resultados devueltos
	// Vamos añadiendo a la celda de la tabla el dato tomado del correspondiente valor
	// guardado en el variable $reg
	$tiposCategoria = array(1=>"Geografía", 2=>"Sistemas operativos", 3=>"Bases de datos", 4=>"Programación Orientada a Objetos");

	while ( $reg = mysqli_fetch_array($registros) ) {
		$id_pregunta = $reg['id'];
		?>
		<tr class="pregunta">
			<th><?php echo $reg['id']; ?> </th>
			<td><?php echo $tiposCategoria[$reg['id_categoria']]; ?> </td>
			<td><?php echo $reg['pregunta'];?></td>			
			<td><a href="form_mod_pregunta.php?id=<?php echo $reg['id'];?>"><i class="fas fa-edit"></i></a> </td>
			<td><a href="eliminar_pregunta.php?id=<?php echo $reg['id'];?>"><i class="fas fa-trash-alt"></i></a> </td>
		</tr>
	<?php
		$sql_res = "SELECT * FROM respuestas WHERE id_pregunta= $id_pregunta "; //$reg['id']";  // LIMIT 3";

		$respuestas = mysqli_query($conexion, $sql_res) or die ("Error buscando respuestas");
		while ($reg_res = mysqli_fetch_array($respuestas) ) {
		?>
			<tr  class="respuesta" id="">
			<th>&nbsp; </th> <!-- <th> <?php echo $reg_res['id']; ?> </th>  -->
			<td><?php  ($reg_res['es_correcta'] == true ? $v='Correcta' : $v=''); echo $v; ?> </td>
			<td><?php echo $reg_res['respuesta'];?></td>	
			<td>&nbsp;</td>			<td>&nbsp;</td>
<!--		
			<td><a href="modificar_respuesta.php?id=<?php echo $reg_res['id'];?>"><i class="fas fa-edit"></i></a> </td>
			<td><a href="eliminar_respuesta.php?id=<?php echo $reg_res['id'];?>"><i class="fas fa-trash-alt"></i></a> </td>
-->
		</tr>
<?php
		}  // fin while respuestas
	
	}  // fin while preguntas
	// Liberamos los recursos utilizados por mysqli
	mysqli_free_result($registros);
	mysqli_close($conexion);
	?>

	</tbody>
	</table>
		<div class="footer text-center">
			<p>Creado por mi Mismo</p>
		</div>
	</div>
</body>
</html>
