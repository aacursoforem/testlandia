<?php
	require("../verifica_profe.php");
	
	
//	echo'<pre>'; 	print_r($_POST); 	echo'</pre>';
	
	$id_categoria = $_POST['id_categ'];	
	$id_profesor = $_SESSION['id_usuario'];
	$pregunta = $_POST['pregunta'];
	$id_respuesta_correcta= $_POST['idRespuestaCorrecta'];

	include("../conexion.php");
	
	$sql_preg = "INSERT INTO preguntas (id_categoria, id_profe, pregunta) VALUES ( $id_categoria, $id_profesor, '$pregunta') ";
	//echo $sql_preg;
	// falta añadir id_tipo pregunta(respuesta simple o múltiple), num_respuestas
	
	mysqli_query($conexion, $sql_preg) or die (mysqli_error($conexion));
	// Obtenemos el valor del id creado en la inserción de la pregunta
	$id_pregunta = mysqli_insert_id($conexion);
	

/**************** PRIMERA FORMA DE PROCESAR LAS RESPUESTAS - DESACTIVADA **************/
/*	$resp1 = $_POST['resp-1'];
	$resp2 = $_POST['resp-2'];
	$resp3 = $_POST['resp-3'];

	for ($i=1; $i<=3; $i++) {
		if ($id_respuesta_correcta == $i) {
			$esRespuestaCorrecta = 1; // true;			
		} else $esRespuestaCorrecta = 0; // false;
		$resp = 'resp'.$i;
		$respuesta = $$resp;
		
		$sql_resp = "INSERT INTO respuestas (id_pregunta, es_correcta, respuesta) VALUES ($id_pregunta, $esRespuestaCorrecta, '$respuesta' ) ";
		//echo $sql_resp.'<br/>';
		// mysqli_query($conexion, $sql_resp) or die (mysqli_error($conexion));
	}
*/
	/******************************************************/
	
	
/*************  SEGUNDA FORMA DE PROCESAR LAS RESPUESTAS *******************/
	$respuestas = array();
	foreach ($_POST as $clave=>$valor)
// las respuestas vienen en un input con nombre resp-X, donde X es el número de respuesta
	if (strpos($clave, 'resp-') > -1 ) {
		$piezas = explode("-", $clave);
		$respuestas[$piezas[1]] = $valor;
	}
//	echo'<p>El contenido del array respuestas es:</p>'; echo'<pre>'; print_r($respuestas); echo'</pre>';
	
	foreach ($respuestas as $clave=>$valor) {
		if ($id_respuesta_correcta == $clave) $esRespuestaCorrecta= 1;
		else $esRespuestaCorrecta = 0;
		$sql_r ="INSERT INTO respuestas (id_pregunta, es_correcta, respuesta) VALUES (
		$id_pregunta, $esRespuestaCorrecta, '$valor')";
		//echo '<br>'.$sql_r;
		mysqli_query($conexion, $sql_r) or die ("Error actualizando datos de la respuesta $clave");

	}


	
	echo '<p>Pregunta con respuestas añadidas correctamente <a href="../resultado.php?control=2">Volver</a>';
	echo '<p>Volver a introducir <a href="form_alta_pregunta.php">otra pregunta</a></p>';
	

	
?>
