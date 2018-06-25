<?php

// FICHERO DE FUNCIONES
/*
1. function conectaBD()
2. function mostrarSelect($tabla_opciones, $name_id, $label, $id_elegido) 
3. function imprimeArray($vector, $titulo='')
*/






/*********************************************************************************/
/* 2. Función que devuelve el texto html para crear un select de formulario
	Parámetros de entrada: 
		$tabla_opciones. Tabla de la BD (con campos id, nombre) con las opciones a mostrar en el select
		$name_id . Id y nombre que tendrá el select devuelto
		$label . Etiqueta label que se mostrará en el select
		$id_elegido. Identificador dentro de las opciones que se mostrará como seleccionada
	Salida:
		Código html para crear un select (<select id....><option value...>.....</select>
	Otros:
		Notar que en el directorio superior al que se le llama debe existir el fichero conexion que crea la conexión a la base de datos y crea la variable $conexion con estos datos

*/
	function mostrarSelect($tabla_opciones, $name_id, $label, $id_elegido) {
		if (!isset($conexion)) {
			// conectar a la base de datos
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
		//	Cerrar conexion a la base de datos
		return $buf;		
	}



/*********************************************************************************/
/* 3. Función que devuelve el texto html para crear mostrar un array
	Entrada:
		$vector: Vector o array del que mostrar el contenido
		$titulo: Título (puede estar vacío) que se quiere mostrar delante del array
	Salida: Devuelve una cadena de texto con el titulo y el contenido del array
*/
function imprimeArray($vector, $titulo=''){
	 if ($titulo != '')	cad='<p>Contenido del vector <b>'.$titulo.'</b></p>';
	else $cad ='';
	$cad .= '<pre>'; 
	$cad .= print_r($vector); 
	$cad .='</pre>';
	return $cad;
}




/* 4. Función a la que se le paas un array con índices y una $cantidad y devuelve una cadena de texto
   con $cantidad de valores seleccionados del array pasado 
	Entradas:
	$arrayIndices : array con los indices de los cuales seleccionar un número de $cantidad
	$cantidad: número de indices a elegir para devolver en forma de cadena
	Salida:
	Una cadena de texto de la forma "a, b, c, d, ..." formada por $cantidad de elementos los cuales son valores del array.
	En caso de que el array contenga menos valores que el número de $cantidad, se devuelve la cadena con todos los valores del array pasado
*/
// TODO. En función de la diferencia entre la cantidad de indices que lleguan y cantidad de indices a devolver, optimizar para que
// o que se elijan los ids a seleccionar, o los ids a eliminar de la lista original(los que sean menos)
function devuelveCadenaPreguntasSeleccionadas($arrayValores, $cantidad){
//	echo imprimeArray($posiblesPreguntas, 'Preguntas llegadas a la función');

	$seleccionados = array();  // array para guardar los números que se vayan seleccionando

	$elementosArray = count($arrayValores);  // número de elementos del array pasado como parámetro

	if ($elementosArray > $cantidad) {
	while (count($seleccionados) < $cantidad) {
		$aleatorio = rand(0, $elementrosArray);  // devuelve un número de indice entre 0 y longitud del array 

// Si el número aleatorio calculado no está ya en el array de seleccionados lo añadimos
		if (!in_array($aleatorio, $seleccionados) ) {
			$seleccionados[] = $aleatorio;
		}
	} // fin while
	// devolvermos una cadena con los valores del array separados por coma (ej. "1, 5, 9, ...")
	return implode(', ', $seleccionados);
} // fin if
	else // el número de elementos del array es inferior a la cantidad de valores que se pide devolver
		// devolvemos una cadena, con todos los números del array que inicialmente pasaron como parámetro
		return implode(', ', $arrayValores);
}
