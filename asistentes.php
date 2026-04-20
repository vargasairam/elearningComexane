<?php
require_once('config/auto_configuracion.php');
require_once('model/alumno.php');
require_once('model/helper.php');
require_once('model/configuracion.php');
require "model/pregunta.php";



$H = new Helper();
$preguntass = new Pregunta();
$session = 4;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Preguntas </title><!-- 
		<link href="css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>

	<div class="container">
		<div class="row col-lg-12">
			<div class="col-lg-10 col-lg-offset-1">
				<h3 class="title">Preguntas <a href="asistentes.php" class="btn btn-sm btn-primary">Actualizar</a></h3>
				<table class="table table-bordered">
					<thead>
						<th>#</th>
						<th>Pregunta</th>
						<th>Realizó</th>
						<th>Hora</th>
					</thead>
					<?php
					$preguntas = $preguntass->getAllPreguntas($session);
					$i = 0;
					foreach ($preguntas as $p) {
						$i++;
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $p->pregunta; ?></td>
							<td><?php echo $p->nombre; ?></td>
							<td><?php echo $p->fecha_hora; ?></td>
						</tr>
					<?
					}
					?>
				</table>
				<hr>
				<?php $asistentes = $preguntass->getEstadisticas($session); ?>
				<h3 class="title">Asistentes | Total: <?php echo count($asistentes); ?></h3>
				<table class="table table-bordered">
					<thead>
						<th>#</th>
						<th>Prefijo</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Télefono</th>
						<th>Categoria</th>
						<th>Estado</th>
						<th>País</th>
						<th>Modalidad</th>
						<th>Conexión</th>


					</thead>
					<?php

					$i = 0;
					foreach ($asistentes as $a) {
						$i++;

					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $a->prefijo; ?></td>
							<td><?php echo $a->nombre; ?></td>
							<td><?php echo $a->email; ?></td>
							<td><?php echo $a->telefono; ?></td>
							<td><?php echo $a->categoria; ?></td>
							<td><?php echo $a->estado; ?></td>
							<td><?php echo isset($a->pais) ? $a->pais : "México"; ?></td>

							<td><?php echo "VIRTUAL"; ?></td>
							<td><?php echo $a->fecha_hora; ?></td>



						</tr>
					<?
					}
					?>
				</table>

				<hr>


				<hr>
				<h3 class="title">Estados</h3>
				<table class="table table-bordered">
					<thead>
						<th>#</th>
						<th>Estado</th>
						<th>Total</th>
					</thead>
					<?php
					$asistentes_estado = $preguntass->getEstadisticasByEstadosV($session);
					$i = 0;
					foreach ($asistentes_estado as $e) {
						$i++;
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $e->estado; ?></td>
							<td><?php echo $e->total; ?></td>

						</tr>
					<?
					}
					?>
				</table>

			</div>
		</div>
	</div>
	<script>
		setTimeout('document.location.reload()', 30000);
	</script>
</body>

</html>