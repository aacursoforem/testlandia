<?php
	require("../verifica_alumno.php");
function imprimeArray($vector, $nombre=''){
	if ($nombre !='') echo 'Contenido del vector <b>'.$nombre.'</b>';
	echo '<pre>';
	print_r($vector);
	echo '</pre>';
}

function imprimePregunta($numPregunta, $id_pregunta, $id_respuesta_elegida){
	// include("../conexion.php");
	global $conexion;
	$sql_pre = "SELECT * FROM preguntas WHERE id=$id_pregunta";
	$res_preg = mysqli_query($conexion, $sql_pre) or die ("Error buscando pregunta");
	$reg_preg = mysqli_fetch_array($res_preg);
	
	$sql_res = "SELECT * FROM respuestas WHERE id_pregunta=$id_pregunta";
	$respuestas = mysqli_query($conexion, $sql_res) or die ("Error buscando respuestas");
	
	echo'<p class="pregunta">'.$numPregunta.'. '.utf8_encode($reg_preg['pregunta']).'</p><ul class="respuestas">';	
	
	while ($reg_res = mysqli_fetch_array($respuestas) ) {
		$estilo ='b';
		if ($id_respuesta_elegida == $reg_res['id']) {
			$elegido = 'checked="checked"';			
		} else $elegido='';
		
		if ($reg_res['id'] == $id_respuesta_elegida) {
			if ($reg_res['es_correcta']==1 		) {
					$estilo = ' style="color:green"';
				} else $estilo= ' style="color:red"';
		}	
	//echo '<p>Valor de $reg_res[\'es_correcta\'] vale: '.$reg_res['es_correcta'].'</p>';
		
		$valor = 'res-'.$reg_res['id'];
		$nameid = 'preg-'.$reg_res['id'];
		echo'<li '.$estilo.'>';
		echo'<input type="radio" id="'.$nameid.'" name="'.$nameid.'" value="'.$valor.'" '.$elegido.'>'.utf8_encode($reg_res['respuesta']);
		echo'</li>';	
	}
	echo'</ul>';
}  // fin function imprimePregunta



	imprimeArray($_POST, '$_POST');


	foreach ($_POST as $clave=>$valor)
	if (strpos($clave, 'preg') > -1 ) {
		$indices = explode("-", $clave);
		$valores = explode("-", $valor);
		$preguntas[$indices[1]] = $valores[1];
	}

	//imprimeArray($preguntas, 'Preguntas [id-pregunta]=>id-respuesta');

	include("../conexion.php");
	$numAciertos = 0;
	$conta = 0;
	foreach ($preguntas as $clave=>$valor) {
		$sql_res = "SELECT id FROM respuestas WHERE id=$valor AND es_correcta=1";
		//echo '<p>'.$sql_res.'</p>';
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


	//imprimePregunta(1, 2, 4);
	//imprimePregunta(2, 2, 5);
	
	$i = 0;
	foreach ($preguntas as $clave => $valor) {
		$i++;		
		imprimePregunta($i, $clave, $valor);		
	}

	mysqli_close($conexion);
?>
