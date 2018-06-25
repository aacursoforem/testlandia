<?php
	require("../verifica_profesor.php");
	// echo'<pre>'; print_r($_SESSION); echo'</pre>';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Profesores</title>
	<meta charset="utf-8" />
	<?php
		include("../cdns.php");  ?>
	
</head>


<body>
<?php	include("../barra-menu.php");
	?>	
	Página principal del profesor
	
	<p><a href="form_alta_pregunta.php">Alta preguntas</a></p>
	
	<p><a href="listado_preguntas.php">Listar preguntas</a></p>
	
	<p><a href="form_cambiar_categoria.php">Preguntas con categorías</a></p>
	
	<p><a href="../index.php">Volver al inicio</a></p>
	
</body>
</html>
