<?php	// Verificamos que el visitante tiene credencial de administrador
	require("../verifica_profesor.php");
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
	.correcta { color: green; }

</style>
	
</head> 

<body>
<?php   include("../barra-menu.php");  
?>
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
						case 1 : $mensaje='Pregunta añadida con éxito'; $tipoMensaje = 'success';  break;
						case 2 : $mensaje='Pregunta eliminada correctamente'; $tipoMensaje = 'success';  break;
						case 3 : $mensaje='Pregunta actualizada correctamente';  $tipoMensaje = 'success'; break;				
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
	if (isset($_GET['ini'])) {  // indica el elemento a partir del cual empezar a mostrar
			$inicio = $_GET['ini'];
		} else {
			$inicio = 0;
		}		
		$REGISTROS_PAGINA = 5;
		$num_total_registros = 0;


	$num_total_registros = mysqli_num_rows($sql_num_total);
	$reg_total_mostrados = $inicio + $REGISTROS_PAGINA;

	// Conectamos a la base de datos
	include "../conexion.php";	
	
	// Preparamos la consulta a realizar. Una consulta de selección devuelve un resultSet 
	$sql = "SELECT * FROM preguntas WHERE id_profe='$id_profe'";
	// or die(mysqli_errno($conexion) . mysqli_error($conexion));
	
	// Ejecutamos la consulta y guardamos el resultSet que devuelve en la variable -$registros-)
	$registros = mysqli_query($conexion, $sql)  or die ("Error buscando preguntas<br/> $sql");
	// Con el resultSet guardado ya en la variable $registros, podemos cerrar la conexión a la BD

	$num_total_registros = mysqli_num_rows($registros);
	$reg_total_mostrados = $inicio + $REGISTROS_PAGINA;
	$sql2 = $sql . " LIMIT $inicio, $REGISTROS_PAGINA ";
	$registros = mysqli_query($conexion, $sql2)  or die ("Error buscando preguntas<br/> $sql");

?>

<thead class="thead-dark">
		<tr>
			<td colspan="2">Profesor: <b> <?php echo $_SESSION['usuario']; ?></b></td>
			<td colspan="3"><form id="">
				<label for="categoria">Filtrar por categoría</label>
				<select id="categoria" name="categoria">
					<option value="1">Geografía</option>
					<option value="2">Sistemas operativos</option>
					<option value="3">BB.DD.</option>
					<option value="4">POO</option>
					<option value="5">Oposita INAP</option>
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
	$tiposCategoria = array(1=>"Geografía", 2=>"Sistemas operativos", 3=>"Bases de datos", 4=>"Programación Orientada a Objetos", 5=>"INAP Oposita");

	while ( $reg = mysqli_fetch_array($registros) ) {
		$id_pregunta = $reg['id'];
		?>
		<tr class="pregunta">
			<th><?php echo $reg['id']; ?> </th>
			<td><?php echo $tiposCategoria[$reg['id_categoria']]; ?></td>
			<td><?php echo utf8_encode($reg['pregunta']);?></td>			
			<td><a href="form_mod_pregunta.php?id=<?php echo $reg['id'];?>"><i class="fas fa-edit"></i></a> </td>
			<td><a href="eliminar_pregunta.php?id=<?php echo $reg['id'];?>"><i class="fas fa-trash-alt"></i></a> </td>
		</tr>
	<?php
		$sql_res = "SELECT * FROM respuestas WHERE id_pregunta= $id_pregunta "; //$reg['id']";  // LIMIT 3";

		$respuestas = mysqli_query($conexion, $sql_res) or die ("Error buscando respuestas");
		while ($reg_res = mysqli_fetch_array($respuestas) ) {
		?>
		<tr class="respuesta" id="">
			<td>&nbsp;</td> 
			<td><?php  ($reg_res['es_correcta'] == 1 ? $v='correcta' : $v=''); echo $v; ?></td>
			<?php echo '<td colspan="1" class="'.$v.'">'.utf8_encode($reg_res['respuesta']);
			?>
			</td><td colspan="2"></td>			
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

<?php
	if ($num_total_registros > 0) {
?>
<!-- PAGINACIÓN -->
		<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
			 <div class="btn-group mr-2 mx-auto" role="group" aria-label="First group">		
		<?php
		// Mostramos el enlace anterior si $inicio no es cero(no estamos en el primer grupo de resultados)
		// en caso contrario mostramos en lugar de un enlace activo un texto
		if ($inicio == 0) {
			echo'<a class="btn btn-secondary">Anterior</a>&nbsp;';		
		} else {
			$anterior = $inicio - $REGISTROS_PAGINA;
			echo'<a class="btn btn-primary" href="listado_preguntas.php?ini='.$anterior.'">Anterior</a>&nbsp;';
		} 
		
		$paginas=ceil($num_total_registros/$REGISTROS_PAGINA);
		for ($i=1; $i<=$paginas; $i++) {
			$valor = ($i-1) * $REGISTROS_PAGINA;
			if ($valor != $inicio) {
				echo '<a class="btn btn-primary" href="listado_preguntas.php?ini='.$valor.'" >'.$i.'</a>&nbsp;';
			} else {
				echo '<span class="btn btn-secondary">'.$i.'</span>&nbsp;';
			}		
		}

		// Si en el paso anterior se mostraron 3, (y no es multiplo de 3) quedan registros por mostrar

		if ($reg_total_mostrados < $num_total_registros) {

			$siguiente = $inicio + $REGISTROS_PAGINA;

			echo'<a class="btn btn-primary" href="listado_preguntas.php?ini='.$siguiente.'">Siguiente</a>';

		} else {

			echo '&nbsp;<span class="btn btn-secondary">Siguente</span>';

		}		

	?>
		</div>
		</div>
		<!--  FIN DE PAGINACIÓN  -->

<?php
} // fin de $num_total_registros>0
?>

		<div class="footer text-center">
			<p>Creado por mi Mismo</p>
		</div>
	</div>
</body>
</html>
