<?php	// Verificamos que el visitante tiene credencial de administrador
	require("../verifica_alumno.php");
//	 echo'<pre>'; print_r($_SESSION); echo'</pre>';
	 echo'<pre>'; print_r($_POST); echo'</pre>';
	$id_alumno =$_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Examen de alumno</title>
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
			<h1>Examen de alumno</h1>
	</div>
	
	<div class="container">
		<div class="row" style="padding-bottom:10px;">
			<div class="col-sm-6 text-left"></div>	
			
		</div>
	</div>
	
	
	<!-- Mostramos la cabecera de la tabla -->
	<div class="container">

	
<?php

	if (isset($_POST['categoria']) ){  //&& is_int($_POST['categoria']) ) {
		$id_categoria = $_POST['categoria'];		
		$condicionCategoria = ' id_categoria = '.$id_categoria;		
	} else {
		$condicionCategoria = " 1 ";
	}
		
	// Conectamos a la base de datos
	include "../conexion.php";	
	
	// Buscamos un listado de preguntas disponibles (más adelante restringidas a una categoría)
	$sql = "SELECT * FROM preguntas WHERE $condicionCategoria LIMIT 1, 10 ";
	// or die(mysqli_errno($conexion) . mysqli_error($conexion));
	//echo $sql;
	// Ejecutamos la consulta y guardamos el resultSet que devuelve en la variable -$registros-)
	$registros = mysqli_query($conexion, $sql)  or die ("Error buscando preguntas<br/> $sql");
	// Con el resultSet guardado ya en la variable $registros, podemos cerrar la conexión a la BD
	
	/*
	
	
	
	}
	*/
	// Debemos obtener un array unidimensional con los ids de todas las preguntas selccionadas
	
	// Creamos una función que tome como parámetros un número y el array con los id de las posibles pregutnas.
	// La función debe devolver un array de longitud número anterior con los valores de los ids seleccioandos
	
	// Hacer notar que para optimizar hay que comprobar si el número de elementos a eliminar en el array es mayor que el que se deja, o al contrario, solo se deja en el array los seleccionados (el rand elige los ids a eliminar en lugar de los que debe mantener).
	// Desde uno a número de preguntas a mostrar
	
	// Realizamos una segunda consulta con las preguntas id IN (2, 3, 4, ....) seleccioandas antes.
	
	
?>
	<table class="table table-striped text-center">
<thead class="thead-dark">
		<tr>
			<td colspan="2">Alumno: <b> <?php echo $_SESSION['usuario']; ?></b></td>




			<td colspan="3"><form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="">

<?php
	include"../funciones.php";
	echo mostrarSelect($tabla_opciones='opciones_categoria', $name_id='categoria', $label='Categoría', $id_elegido=$id_categoria);
/*
				<label for="categoria">Filtrar por categoría</label>
				<select id="categoria" name="categoria">
					<option value="1">Geografía</option>
					<option value="2">Sistemas operativos</option>
					<option value="3">BB.DD.</option>
					<option value="4">POO</option>
				</select>
*/
?>

				<button type="submit">Filtrar</button>
				</form>
			</td>
		</tr>

	<thead>
	<tbody>
	</tbody>
	</table>
	
	
	
	<form method="post" action="corrige_examen.php" >
<?php
	
	// Recorremos el resultSet para ir extrayendo/mostrando los resultados devueltos
	// Vamos añadiendo a la celda de la tabla el dato tomado del correspondiente valor
	// guardado en el variable $reg
	$tiposCategoria = array(1=>"Geografía", 2=>"Sistemas operativos", 3=>"Bases de datos", 4=>"Programación Orientada a Objetos");
	
	
	$i = 0;
	while ( $reg = mysqli_fetch_array($registros) ) {
		$id_pregunta = $reg['id'];
		$i++;
		?>

		<p class="pregunta"><?php echo $i; echo '. '.utf8_encode($reg['pregunta']); ?></p>
		<ul>
			
	<?php
		$sql_res = "SELECT id, id_pregunta, es_correcta, respuesta FROM respuestas WHERE id_pregunta= $id_pregunta "; //$reg['id']";  // LIMIT 3";
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
