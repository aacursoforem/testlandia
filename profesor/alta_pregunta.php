<?php
	session_start();
	
	// TODO validación de que tipo de usuario es profesor
	
	echo'<pre>';
	print_r($_POST);
	echo'</pre>';
	
	$categoria = $_POST['categ'];
	$profesor = $_POST['id_profesor'];
	$pregunta = $_POST['pregunta'];
	$resp1 = $_POST['resp1'];
	$resp2 = $_POST['resp2'];
	$resp3 = $_POST['resp3'];
	$correcta = $_POST['respuestaCorrecta'];
	
	include("../conexion.php");
	
	$sql_preg = "INSERT INTO preguntas (id_categoria, id_profe, pregunta) VALUES ( $categoria, $profesor, '$pregunta') ";
	echo $sql_preg;
	// falta añadir id_tipo pregunta(respuesta simple o múltiple), num_respuestas
	
	mysqli_query($conexion, $sql_preg) or die (mysqli_error($conexion));
	// Obtenemos el valor del id creado en la inserción de la pregunta
	$id_pregunta = mysqli_insert_id($conexion);
	
	

	for ($i=1; $i<=3; $i++) {
		if ($correcta == $i) {
			$esRespuestaCorrecta = 1; // true;			
		} else $esRespuestaCorrecta = 0; // false;
		$resp = 'resp'.$i;
		$respuesta = $$resp;
		
		$sql_resp = "INSERT INTO respuestas (id_pregunta, es_correcta, respuesta) VALUES ($id_pregunta, $esRespuestaCorrecta, '$respuesta' ) ";
		//echo $sql_resp.'<br/>';
		mysqli_query($conexion, $sql_resp) or die (mysqli_error($conexion));
	}
	echo '<p>Pregunta con respuestas añadidas correctamente <a href="../resultado.php?control=2">Volver</a>';
	echo '<p>Volver a introducir <a href="form_alta_pregunta.php">otra pregunta</a></p>';
	
	/*  NOTA AL MARGEN.
	$x = 'variable1';
	$$x = '2';  // doble signo $ 
	echo $variable1;
	*/
	
	
	
?>
