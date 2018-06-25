<?php	// Verificamos que el visitante tiene credencial de administrador
	require("../verifica_alumno.php");
//	 echo'<pre>'; print_r($_SESSION); echo'</pre>';
	 //echo'<pre>'; print_r($_POST); echo'</pre>';
	$id_alumno =$_SESSION['id_usuario'];
	include"../funciones.php";





?>
<!DOCTYPE html>
<html>
<head>
	<title>Opciones del Examen del alumno</title>
	<meta charset="utf-8" /> 
	<?php include("../cdns.php"); ?>
	<style type="text/css">
		.pregunta { color: blue; }
	</style>
	
</head> 

<body>
<?php 
	if (isset($_POST['categoria']) ){  //&& is_int($_POST['categoria']) ) {
		$id_categoria = $_POST['categoria'];		
		$condicionCategoria = ' id_categoria = '.$id_categoria;		
		$numPreguntas = $_POST['numPreguntas'];
	} else {
		$condicionCategoria = " 1 ";
		$numPreguntas =10;
	}
		
	// Conectamos a la base de datos
	include "../conexion.php";	
    include("../barra-menu.php");  
?>
	<div class="jumbotron text-center">
			<h1>Examen de alumno</h1>
	</div>
	
	<div class="container">
		<div class="row" style="padding-bottom:10px;">
			<div class="col-sm-6 text-left"></div>	
			
		</div>
	</div>
	
	
	<!-- Mostramos la cabecera de la tabla -->
	<div class="container">

	<table class="table table-striped text-center">
<thead class="thead-dark">
		<tr>
			<td colspan="2">Alumno: <b> <?php echo $_SESSION['usuario']; ?></b></td>
			<td><form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="">
			<td>
				<label for="numPreguntas">Núm. preguntas</label>
				<input type="number" min="1" max="15" value="<?php echo $numPreguntas;?>" name="numPreguntas" id="numPreguntas"/>
			</td>
			<td>

<?php

	echo mostrarSelect($tabla_opciones='opciones_categoria', $name_id='categoria', $label='Categoría', $id_elegido=$id_categoria); ?>
				<button type="submit">Filtrar</button>
				</form>
			</td>
		</tr>

	<thead>
	<tbody>
	</tbody>
	</table>


	
<?php

	
	// Pedimos a la BD un listado de todas las preguntas disponibles de una categoría
//	$sql = "SELECT * FROM preguntas WHERE $condicionCategoria LIMIT 1, $numPreguntas ";
	$sql = "SELECT id FROM preguntas WHERE $condicionCategoria";
	// Ejecutamos la consulta y guardamos el resultSet que devuelve en la variable -$registros-)
	$registros = mysqli_query($conexion, $sql)  or die ("Error buscando preguntas<br/> $sql");
	$numRegistros = mysqli_num_rows($registros);
	// Si se han devuelto registros
	if ($numRegistros > 0) {	
	// Creamos array con los ids de todas las preguntas devueltas
		$posPreguntas = array();  // array donde guardar preguntas que cumplen con la condición
		while ($reg = mysqli_fetch_assoc($registros)) {
			$posPreguntas[] = $reg['id'];
		}
		// llamamos a la función que devolverá $numPreguntas seleccionadas del array de todas
		// las preguntas que hemos buscado en la anterior consulta
		// (elige $numPreguntas del array de todas las preguntas posibles $posPreguntas

		$resPreguntas = devuelveCadenaPreguntasSeleccionadas($posPreguntas, $numPreguntas);
		 //echo'<pre>'; print_r($resPreguntas); echo'</pre>';
	} // fin if ($numRegistros > 0)
		
	// Con la lista de los ids de las preguntas elegidas aleatoriamente ($resPreguntas) las seleccionamos
	// de la base de datos y las mostramos junto con sus posibles respuestas
	$sql = "SELECT * FROM preguntas WHERE id IN ($resPreguntas) LIMIT 1, $numPreguntas ";
	$registros = mysqli_query($conexion, $sql)  or die ("Error buscando preguntas<br/> $sql");
?>

		
	<form method="post" action="corrige_examen.php" >
<?php
	
	// Recorremos el resultSet para ir extrayendo/mostrando los resultados devueltos
	// Vamos añadiendo a la celda de la tabla el dato tomado del correspondiente valor
	// guardado en el variable $reg
	//$tiposCategoria = array(1=>"Geografía", 2=>"Sistemas operativos", 3=>"Bases de datos", 4=>"Programación Orientada a Objetos");
	
	
	$i = 0;
	while ( $reg = mysqli_fetch_array($registros) ) {
		$id_pregunta = $reg['id'];
		$i++;
		?>

		<p class="pregunta"><?php echo $i.'. '.utf8_encode($reg['pregunta']); ?></p>
		<ul>
			
	<?php
		$sql_res = "SELECT id, id_pregunta, es_correcta, respuesta FROM respuestas WHERE id_pregunta= $id_pregunta "; 
		//echo $sql_res;
		$respuestas = mysqli_query($conexion, $sql_res) or die ("Error buscando respuestas");
		while ($reg_res = mysqli_fetch_array($respuestas) ) {
			//if ($reg_res['es_correcta']) $valor = 'Correcta';
			//else $valor='';
			$valor = 'res-'.$reg_res['id'];
			$nameid = 'preg-'.$reg['id'];			
		?>
		
			<li  class="respuesta">
				<input type="radio" id="<?php echo $nameid; ?>"< name="<?php echo $nameid; ?>" value="<?php echo $valor; ?>"/> 
				<?php echo utf8_encode($reg_res['respuesta']);?>
			</li>	
			


<?php
		}  // fin while respuestas
?>
	</ul>
<?php	
	}  // fin while preguntas
	// Liberamos los recursos utilizados por mysqli
	mysqli_free_result($registros);
	mysqli_close($conexion);
	?>
	<button type="submit">Enviar</button>
	</form>

		<div class="footer text-center">
			<p style="color:#CCC">Creado por mi Mismo</p>
		</div>
	</div>
</body>
</html>
