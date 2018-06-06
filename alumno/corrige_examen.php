<?php
function imprimeArray($vector, $nombre=''){
	if ($nombre !='') echo 'Contenido del vector <b>'.$nombre.'</b>';
	echo '<pre>';
	print_r($vector);
	echo '</pre>';
}

function imprimePregunta($id_pregunta, $id_respuesta, $ok){

}

	imprimeArray($_POST, '$_POST');


	foreach ($_POST as $clave=>$valor)
	if (strpos($clave, 'preg') > -1 ) {
		$indices = explode("-", $clave);
		$valores = explode("-", $valor);
		$preguntas[$indices[1]] = $valores[1];
	}

	imprimeArray($preguntas, 'Preguntas [id-pregunta]=>id-respuesta');

	include("../conexion.php");
	$numAciertos = 0;
	$conta = 0;
	foreach ($preguntas as $clave=>$valor) {
		$sql_res = "SELECT id FROM respuestas WHERE id=$valor AND es_correcta=1";
		echo '<p>'.$sql_res.'</p>';
		$res = mysqli_query($conexion, $sql_res) or die ("Error comprobando pregunta-respuesta");
		$conta++;
		$num = mysqli_num_rows($res);
		if ( $num > 0)  {  // la respuesta es correcta
			$respuestas[$clave]='OK';
			$numAciertos++;
		} else {
			$respuetas[$clave]='Fallo';
		}

	// Imprime (guarda en variable para imprimir) texto de la pregunta, con respuestas y dibujo de OK o de fallo


	}
	echo'<p>Se han contestado '.$conta.' preguntas y se han acertado '.$numAciertos.'</p>';





	mysqli_close($conexion);
?>
