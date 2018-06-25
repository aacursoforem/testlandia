<?php
	require("../verifica_profesor.php");
	//echo'<pre>'; 	print_r($_POST); 	echo'</pre>';
	

	$id_categ = $_POST['id_categ'];
	$id_pregunta = $_POST['id_pregunta'];
	$texto_pregunta = utf8_decode($_POST['textoPregunta']);
	$id_respuesta_correcta = $_POST['idRespuestaCorrecta'];

	$respuestas = array();

	foreach ($_POST as $clave=>$valor)
	if (strpos($clave, 'resp') > -1 ) {
		$piezas = explode("-", $clave);
		$respuestas[$piezas[1]] = utf8_decode($valor);
	}

//	echo'<pre>'; print_r($respuestas); 	echo'</pre>';

	include("../conexion.php");

	// Consulta de actualización de los datos de la pregunta
	$sql_p = "UPDATE preguntas SET id_categoria=$id_categ, pregunta='$texto_pregunta' WHERE id=$id_pregunta";
	mysqli_query($conexion, $sql_p) or die ("Error actualizando los datos de la pregunta");
	//echo '<br>'.$sql_p;

	foreach ($respuestas as $clave=>$valor) {
		if ($id_respuesta_correcta == $clave) $correcta= 1;
		else $correcta = 0;
		$sql_r ="UPDATE respuestas SET es_correcta=$correcta, respuesta='$valor'  WHERE id=$clave";
		//echo '<br>'.$sql_r;
		mysqli_query($conexion, $sql_r) or die ("Error actualizando datos de la respuesta $clave");
	}

//	header("location:listado_peguntas.php?control=3");
	echo'<p>Actualización correcta</p>';
	echo'<p><a href="listado_preguntas.php?control=3">Volver al listado</p>';
	// TODO. Para volver a la misma pantalla necesitamos conocer el número de orden del registro modificado
	// Habría que recibirlo desde el script listado_preguntas.php
	//echo'<p><a href="listado_preguntas.php?control=3&ini='.($id_pregunta-1).'">Volver al listado</p>';



?>
