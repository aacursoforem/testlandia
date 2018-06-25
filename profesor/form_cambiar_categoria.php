<?php	// Verificamos que el visitante tiene credencial de administrador
	require("../verifica_profesor.php");
	// echo'<pre>'; print_r($_SESSION); echo'</pre>';
	//echo'<pre>'; print_r($_GET); echo'</pre>';
	$id_profe =$_SESSION['id_usuario'];
//echo '<p>El id de profesor es '.$id_profe.'</p>';

/*********************************************************************************/
	function mostrarSelect($tabla_opciones, $name_id, $label, $id_elegido) {
		if (!isset($conexion)) {
			include("../conexion.php");	
		} 
		$sql = "SELECT id, nombre FROM $tabla_opciones ";
		$result = mysqli_query($conexion, $sql) or die ("Problema al consultar opciones de select");
		$buf ='<label for="'.$name_id.'">'.$label.'</label>';
		$buf .='<select id="'.$name_id.'" name="'.$name_id.'">';
		while ($reg = mysqli_fetch_assoc($result) ) {
			$buf .='<option value="'.$reg['id'].'"';
			if ($reg['id'] == $id_elegido) {
				$buf .= ' selected="selected">';
			} else {
				$buf .='>';
			}
			$buf .=utf8_encode($reg['nombre']).'</option>';
			
		}
		$buf .='</select>';
		return $buf;		
	}

/****************************************************************************/


?>
<!DOCTYPE html>
<html>
<head>
	<title>Listado de Preguntas por categoría</title>
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
			<h1>Listado de preguntas por categoría</h1>
	</div>
	
	<div class="container">
		<div class="row" style="padding-bottom:10px;">
			<div class="col-sm-6 text-left">

			</div>	
		</div>
	</div>
	
	

	
<?php
	if (isset($_GET['ini'])) {  // indica el elemento a partir del cual empezar a mostrar
			$inicio = $_GET['ini'];
		} else {
			$inicio = 0;
		}		
		$REGISTROS_PAGINA = 5;
		$num_total_registros = 0;


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
	//echo $sql2;
	$registros = mysqli_query($conexion, $sql2)  or die ("Error buscando preguntas<br/> $sql");

	?>



<form id="" method="post" action="mod_listado_preguntas.php">
	<!-- Mostramos la cabecera de la tabla -->
<div class="container">
<table class="table  text-left">
<thead class="thead-dark">
		<tr>
			<td colspan="3">Profesor: <b> <?php echo $_SESSION['usuario']; ?></b></td>
		</tr>
		<tr>
			<th>Id</th>
			<th>Categoría</th>
			<th>Pregunta</th>
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
			<td><?php echo  mostrarSelect($tabla_opciones='opciones_categoria', $name_id='id_preg-'.$reg['id'], $label='Categoría', $id_elegido=$reg['id_categoria']); ?></td>
			<td><?php echo utf8_encode($reg['pregunta']);?></td>						
		</tr>
	<?php		
	
	}  // fin while preguntas
	// Liberamos los recursos utilizados por mysqli
	mysqli_free_result($registros);
	mysqli_close($conexion);
?>

	</tbody>
	</table>
	<div class="form-group text-center">				
		<button class="btn btn-danger" type="reset"><i class="fas fa-ban fa-1x"></i> Limpiar</button>
		<button class="btn btn-primary" type="submit"><i class="fas fa-save fa-1x"></i> Guardar</button>
	</div>
				
</form>
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
			echo'<a class="btn btn-primary" href="'.basename(__FILE__).'?ini='.$anterior.'">Anterior</a>&nbsp;';
		} 
		
		$paginas=ceil($num_total_registros/$REGISTROS_PAGINA);
		for ($i=1; $i<=$paginas; $i++) {
			$valor = ($i-1) * $REGISTROS_PAGINA;
			if ($valor != $inicio) {
				echo '<a class="btn btn-primary" href="'.basename(__FILE__).'?ini='.$valor.'" >'.$i.'</a>&nbsp;';
			} else {
				echo '<span class="btn btn-secondary">'.$i.'</span>&nbsp;';
			}		
		}

		// Si en el paso anterior se mostraron 3, (y no es multiplo de 3) quedan registros por mostrar

		if ($reg_total_mostrados < $num_total_registros) {

			$siguiente = $inicio + $REGISTROS_PAGINA;

			echo'<a class="btn btn-primary" href="'.basename(__FILE__).'?ini='.$siguiente.'">Siguiente</a>';

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
