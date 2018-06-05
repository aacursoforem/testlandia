<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Alta nueva pregunta</title>
	<meta charset="utf-8" />
	<?php include("../cdns.php");  ?>
</head> 
<body>
<?php// Insertamos la barra de menú con las opciones
    //include("barra-menu.php");
?>
	<div class="jumbotron text-center">
			<h1>Alta de preguntas</h1>
	</div>
	
	<div class="container">
		<div class="row"> <!-- 12 filas de división -->
			<div class="col-sm-6 offset-sm-3 text-center">
				<form method="post" action="alta_pregunta.php">
				<div class="form-group text-left">
					<label for="categ">Categoría</label>
					<select name="categ" id="categ">
						<option value="1">Geografía</option>
						<option value="2">Sistemas operativos</option>
						<option value="3">Bases de datos</option>
						<option value="4">Programación Orientada objetos</option>
					</select>
				</div>
				
				<!--
				<div class="form-group text-left">
					<label for="tipo">Tipo respuesta</label>
					<select name="tipo" id="tipo">
						<option value="1">Respuesta simple</option>
						<option value="2">Respuesta múltiple</option>
					</select>
				</div>
				-->
				
				<!--
				<div class="form-group text-left">
					<label for="num_respuestas">Número respuestas</label>
					<input class="form-control" type="number" name="num_respuestas" id="num_respuestas" min="1" max="4" />
				</div>
				-->
				<?php $_SESSION['id_usuario'] = 0;  ?>
				<input type="hidden" name="id_profesor" id="id_profesor" value="<?php echo $_SESSION['id_usuario']; ?>" />
				
				<div class="form-group text-left">
					<label for="pregunta">Pregunta</label>
					<input class="form-control" type="text" name="pregunta" id="pregunta" />
				</div>
				
				<div class="form-group text-left">
					<label for="r">Respuestas</label>					
				</div>
				
				
				<div class="form-group text-left">
				<div class="form-row">
					<div class="col-1 text-right">
						<input type="radio" id="uno" name="respuestaCorrecta" value="1" />
					</div>
					<div class="col-2 text-left">
						<label for="resp1">Opción 1</label>
					</div>
					<div class="col-9 text-left">
						<input class="form-control" type="text" name="resp1" id="resp1"  />
					</div>
				</div>
				</div> 
				
	
				<div class="form-group text-left">
				<div class="form-row">
					<div class="col-1 text-right">
						<input type="radio" id="dos" name="respuestaCorrecta" value="2" />
					</div>				
					<div class="col-2 text-left">
						<label for="resp2">Opción 2</label>
					</div>
					<div class="col-9 text-left">
						<input class="form-control" type="text" name="resp2" id="resp2"  />
					</div>
				</div>
				</div>
				
				
				
				<div class="form-group text-left">
				<div class="form-row">
					<div class="col-1 text-right">
						<input type="radio" id="tres" name="respuestaCorrecta" value="3" />
					</div>
					<div class="col-2 text-left">
						<label for="resp3">Opción 3</label>
					</div>
					<div class="col-9 text-left">
						<input class="form-control" type="text" name="resp3" id="resp3"  />
					</div>
				</div>
				</div>
				
				<!--
				
				<div class="form-group text-left">
					<label for="resp2">Respuesta 2</label>
					<input class="form-control" type="text" name="resp2" id="resp2"  />
				</div>
				
				<div class="form-group text-left">
					<label for="resp3">Respuesta 3</label>
					<input class="form-control" type="text" name="resp3" id="resp3"  />
				</div>
				
				<div class="form-group text-left">					
					<input type="radio" id="uno" name="respuesta" value="1" />
					<label for="uno">Respuesta 1</label>
					
					<input type="radio" id="dos" name="respuesta" value="2" />
					<label for="dos">Respuesta 2</label>					
					
					<input type="radio" id="tres" name="respuesta" value="3" />
					<label for="tres">Respuesta 3</label>
				</div>
				-->
				
								
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



