<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Práctica 3 Compiladores</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"> </script>
</head>
<body>
	<nav>Hola</nav>
	<div class="container">
		<div class="hero-unit">
			<div class="page-header">
				<center>
					<h1>Bienvenido</h1>
					<small>  Práctica: Calculadora   </small>

				<p><br><br>
				<?php echo '<form class="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">
					<div class="row form-group">
						<div class="col-xs-4">
							<label for="entrada" >Archivo de entrada:</label>
							<input type="file" name="entrada" id="entrada" class="filestyle" data-classButton="btn btn-primary" data-buttonText="Elegir Archivo"   required >
						</div>					
					</div>
					<br>
					<div class="input-append"><br>
						<input type="submit" class="btn btn-success btn-lg" name="submit" value="Evaluar"/>
					</div>
				</form>'; ?></p>
				</center>
			</div>
		</div>

<?php 

if(isset($_POST['submit'])) {
	//$entrada = $_POST["entrada"];
	$entrada = "assets/";
	$entrada = $entrada ."entrada.txt";
	//creamos una copia del archivo de entrada
	//guardamos la copia en uploads/entrada.c	
	move_uploaded_file($_FILES['entrada']['tmp_name'], $entrada);

	$contenido = "#!/bin/bash\n" ;
	$contenido .= "chmod -R 777 /opt/lampp/htdocs/practica3/\n";
	$contenido .= "cd /opt/lampp/htdocs/practica3/\n";
	$contenido .= "set -e\n";
	$contenido .= "	make -f Makefile\n";
	$contenido .= ":\n";
	
	$fp = fopen("generar_lexico.sh","w");
	fwrite($fp,"");
	fwrite($fp,$contenido);
	fclose($fp) ;

	shell_exec("./generar_lexico.sh");

	echo '<div class="progress progress-info progress-striped active">
	 		<div class="bar" style="width:100%"></div></div>';
	echo '<ul><li><div class="alert alert-info">Archivo de Entrada: </li>' ;
	echo '<li><a class="btn btn-success" href="'.$entrada.'" target="_blank">Archivo de entrada</a></li></ul>';
	echo '<div id="frame">
				<iframe name="iframe_contenido" src="'.$entrada.'" width="100%" height="50%"></iframe>
				</div>';
	echo '<div class="progress progress-info progress-striped active">
	 		<div class="bar" style="width:100%"></div></div>';

	echo '<ul><li><div class="alert alert-info">Archivo: Salida: </li>' ;
	echo '<li><a class="btn btn-success" href="assets/salida.txt" target="_blank">Archivo de salida</a></li></ul>';
	echo '<table id="tabla-final" class="table table-striped table-bordered">';
	
	$temp = array();
	$temp2 = array();
	$auxChar2 = "";
	$archivoEntrada = fopen($entrada, "r");
	
	
	while( !feof($archivoEntrada) ){
		$line = fgets( $archivoEntrada );
		$var = explode(";", $line, 0);
		array_push($temp, $var[0]);
	}


	fclose( $archivoEntrada );
	
	$archivoSalida = fopen("assets/salida.txt", "r");
	
	while( !feof($archivoSalida) ){
		$line = fgets( $archivoSalida );
		$var = explode(" ", $line, 0);
		$var2 = split(" ", $var[0]);
		array_push($temp2, $var2);
	}
	
	fclose( $archivoSalida );

	echo '<thead>
			<th>No. Operacion</th>
			<th id="operacion">Operacion</th>
			<th>Resultado</th>
		   </thead><tbody>';
	
	for( $i = 0; $i < count($temp); $i++){
		if(strcasecmp($temp2[$i][2], "Resultado_indefinido") > 0){
			echo "<tr class = 'danger'>";
			echo "<td>".$temp2[$i][0]."</td>";
			echo "<td>".$temp[$i]."</td>";
			echo "<td>".$temp2[$i][2]."</td>";
			echo "</tr>";
		}else{
			echo "<tr class='success'>";
			echo "<td>".$temp2[$i][0]."</td>";
			echo "<td>".$temp[$i]."</td>";
			echo "<td>".$temp2[$i][2]."</td>";
			echo "</tr>";
		}
	}	
	
	echo '</tbody></table>';
}
?>
<br><br>

</div>
</body>
</html>