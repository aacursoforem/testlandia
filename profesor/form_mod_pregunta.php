<?php
	session_start();
echo'<pre>'; print_r($_SESSION); echo'</pre>';
//echo '<p>El id del profesor es '.$_SESSION['id_usuario'].'</p>';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Modificar pregunta</title>
	<meta charset="utf-8" />
	<?php include("../cdns.php");  ?>
</head> 
<body>
<?php 
// Insertamos la barra de menú con las opciones
    include("../barra-menu.php");
	
	if (isset($_GET['id'])) {
		$id_pregunta = $_GET['id'];
	} else {
		$id_preguta = 0;
	}
	
	// Tomamos los datos de la pregunta de la base de datos
	include("../conexion.php");
	$sql_preg = "SELECT * FROM preguntas WHERE id=$id_pregunta";
	$res_preg  = mysqli_query($conexion, $sql_preg) or die ("Error buscando pregunta");
	$reg = mysqli_fetch_array($res_preg);
	$id_pregunta = $reg['id'];
	$id_categoria = $reg['id_categoria'];
	$id_tipo = $reg['id_tipo'];
	$id_profe = $reg['id_profe'];
	$num_respuestas = $reg['num_respuestas'];
	$pregunta = $reg['pregunta'];
	
	
	// Tomamos los datos de las respuestas asociadas a la pregunta anterior
	$sql_res = "SELECT * FROM respuestas WHERE id_pregunta=$id_pregunta";
	$res_res = mysqli_query($conexion, $sql_res) or die ("Error buscando respuestas");
	$resputas = array();
	while ($resp = mysqli_fetch_array($res_res) ) {
		$indice = $resp['id'];
		$respuestas[$indice] = $resp['respuesta'];
		if ($resp['es_correcta'] == 1) {
		$correctas[$indice] = true;
		} else {
				$correctas[$indice] = false;
		}
	}
	

?>
	<div class="jumbotron text-center">
			<h1>Modificar pregunta</h1>
	</div>
	
	<div class="container">
		<div class="row"> <!-- 12 filas de división -->
			<div class="col-sm-6 offset-sm-3 text-center">
				<form method="post" action="modificar_pregunta.php">
				<div class="form-group text-left">
					<label for="id_categ">Categoría</label>
					<select name="id_categ" id="id_categ">
						<option value="1" <?php if ($id_categoria == 1) echo 'selected="selected"'; ?>>Geografía</option>
						<option value="2" <?php if ($id_categoria == 2) echo 'selected="selected"'; ?>>Sistemas operativos</option>
						<option value="3" <?php if ($id_categoria == 3) echo 'selected="selected"'; ?>>Bases de datos</option>
						<option value="4" <?php if ($id_categoria == 4) echo 'selected="selected"'; ?>>Programación Orientada objetos</option>
					</select>
				</div>
				
	
				<?php //$_SESSION['id_usuario'] = $id_profe;  
				?>
				<input type="hidden" name="id_profesor" id="id_profesor" value="<?php echo $_SESSION['id_usuario']; ?>" />
				<input type="hidden" name="id_pregunta" id="id_pregunta" value="<?php echo $id_pregunta; ?>" />
				
				<div class="form-group text-left">
					<label for="pregunta">Pregunta</label>
					<input class="form-control" type="text" name="textoPregunta" id="textoPregunta" value="<?php echo $pregunta; ?>"/>
				</div>
				
				<div class="form-group text-left">
					<label for="r">Respuestas</label>					
				</div>
				
				
				<?php
					foreach ($respuestas as $clave=>$valor) {
				
				
				?>
				<div class="form-group text-left">
				<div class="form-row">
					<div class="col-1 text-right">
						<input type="radio" id="idRespuestaCorrecta" name="idRespuestaCorrecta" value="<?php echo $clave; ?>" <?php
						if ($correctas[$clave]) echo 'checked="checked"'; ?>/>
					</div>
					<!--
					<div class="col-2 text-left">
						<label for="resp1">Opción 1</label>
					</div>
					-->
					<div class="col-9 text-left">
						<input class="form-control" type="text" name="resp-<?php echo $clave; ?>" id="resp-<?php echo $clave; ?>" value="<?php echo $respuestas[$clave]; ?>" />
					</div>
				</div>
				</div> 
				
				<?php
					} // fin foreach
				?>
				
	
				
								
				<div class="form-group text-center">				
					<button class="btn btn-danger" type="reset"><i class="fas fa-ban fa-1x"></i> Limpiar</button>
<button class="btn btn-primary" type="submit"><i class="fas fa-save fa-1x"></i> Guardar</button>
				</div>
				
				</form>
			</div>
		</div>
	</div>


</body>
</html>



