<?php
	require("../verifica_profesor.php");
//	echo'<pre>'; 	print_r($_POST); 	echo'</pre>';
	
	$respuestas = array();

	foreach ($_POST as $clave=>$valor)
	if (strpos($clave, 'id_preg') > -1 ) {
		$piezas = explode("-", $clave);
		$respuestas[$piezas[1]] = $valor;
	}

//	echo'<pre>'; print_r($respuestas); 	echo'</pre>';
	include("../conexion.php");


	foreach ($respuestas as $clave=>$valor) {
		$sql ="UPDATE preguntas SET id_categoria=$respuestas[$clave] WHERE id=$clave";
		//echo '<br>'.$sql;
		mysqli_query($conexion, $sql) or die ("Error actualizando datos de las categoría pregunta id: $clave");
	}

//	header("location:listado_peguntas.php?control=3");
	echo'<p>Actualización correcta</p>';
	echo'<p><a href="index.php">Volver al incio</p>';
	
	echo'<p><a href="form_cambiar_categoria.php">Volver a cambiar categorías de preguntas</a></p>';

?>
