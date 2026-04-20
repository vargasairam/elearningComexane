 <div class="page-content-inner">


 	<?php
	$pagoCal = base64_decode($_GET['ttl']);
	if(isset($_POST['codigodescuento'])){
		$validar=$A->validarCodigo($_POST['codigodescuento']);
		if($validar->valido){
			if($validar->usado_por){
				if($validar->usado_por != $alumno->id){
					$H->crearMensaje('El código ya está en uso.', 'warning');
					echo "<script>window.location.href = './?seccion=pagar';</script>";
					exit;
				}else{
					$pagoCal = ($pagoCal-($pagoCal*.4));
				}
			}else{
				
				$A->setTabla("codigosdescuento");
				$campos = array("usado_por", "fecha_uso");
				$valores = array($alumno->id, date("Y-m-d H:i:s"));
				$condicion=" codigo='".$_POST['codigodescuento']."'";
				$A->actualizar($campos, $valores,$condicion);
			}
			
			
		}
		if(!$validar->valido){
			$H->crearMensaje('El código no existe.', 'warning');
			echo "<script>window.location.href = './?seccion=pagar';</script>";
			exit;
		}
		
	}
	
 	require_once 'paypal/paypal.class.php';
 	$PayPal = new paypal_class();
 	$PayPal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
 	$this_script = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?seccion=paypal&categoria=" . $_GET['categoria'] . "&ttl=" . $_GET['ttl'];

 	if (empty($_GET['action'])) {
 		$_GET['action'] = 'process';
 	}
 	$descripcion = sistema_nombre . " - " . $_GET['categoria'];
 	switch ($_GET['action']) {

 		case 'process':
 		$PayPal->add_field('business', paypal_email);
 		$PayPal->add_field('return', $this_script . '&action=success');
 		$PayPal->add_field('cancel_return', $this_script . '&action=cancel');
 		$PayPal->add_field('notify_url', $this_script . '&action=ipn');
 		$PayPal->add_field('item_name', eliminar_acentos($descripcion) . " - Ref: " . $alumno->id);

 		$PayPal->add_field('currency_code', 'MXN');

 		$PayPal->add_field('amount', $pagoCal);
 		?>
 		<br><br>
 		<header class="panel-heading text-center">
 			<h2 class="h2 mt-none mb-sm text-dark text-weight-bold text-center">
 				Espera 5 segundos para redireccionar...
 			</h2>
 		</header>
 		<div class="panel-body">
 			<div class="col-md-12 text-center">
 				<img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/bnr_loading1.gif" alt="Check out with PayPal" />

 				<?php
 				$PayPal->submit_paypal_post();
	// $PayPal->dump_fields();
 				?>
 				<br><br> 	<center><img src="https://www.paypalobjects.com/marketing/web/mx/logos-buttons/tarjetas.png" alt="Check out with PayPal" /></center>

 			</div>
 		</div>

 		<?php
 		break;

 		case 'success':
 		if (is_numeric($pagoCal)) {
 			$A->setTabla("inscripciones");
 			$campos = array("alumno_id", "estatus", "observaciones", "fecha_pago", "monto");
 			$valores = array($alumno->id, "PAGADO", "Pagado con PayPal", date("Y-m-d H:i:s"), $pagoCal);
 			$pago = $A->insertar($campos, $valores);

		// $socio = $S->getSocioById($pago->socio_id);
 			$folio = str_pad($pago, 5, "0", STR_PAD_LEFT);
		// $H->enviarAvisoPaypal($socio->nombre . " " . $socio->apellidop . " " . $socio->apellidom, "ID: " . $_GET['id'] . " - " . eliminar_acentos($descripcion), $pago->total);
 			$H->enviarCorreoConfirmacionEvento($alumno, $folio);
 		}

 		?>
 		<header class="panel-heading">

 			<br><br><br>
 			<div class="bg-gradient-success uk-light" uk-alert> <a class="uk-alert-close" uk-close></a>
 				Su pago se ha realizado con éxito, en breve le enviaremos un correo de confirmación de registro
 			</div>


 		</header>
 		<div class="panel-body">
 			<div class="col-md-12 text-center">

 				<p>
 					<a href="./" class="btn btn-success" >Continuar</a>
 				</p>
 			</div>
 		</div>
 		<?php
 		break;

 		case 'cancel':
 		?>
 		<br><br><br><br>
 		<header class="panel-heading text-center">
 			<h2 class="h2 mt-none mb-sm text-dark text-weight-bold text-center">
 				Su orden ha sido cancelada
 			</h2>
 		</header>
 		<div class="panel-body">
 			<div class="col-md-12 text-center">
 				<p>
 					<a href="./?seccion=pagar" class="btn-info btn">Da click aquí para ver los datos para transferencia o depósito</a>
 				</p>
 			</div>
 		</div>
 		<br><br><br>
 		<?php
 		break;

 		case 'ipn':
 		if ($p->validate_ipn()) {
 			$subject = 'Notificación de pago instantaneo en la cuenta de ' . sistema_nombre;
 			$to = 'jesus@jc-innovation.com';
 			$body = "Ha recibido un pago de registro en su cuenta de paypal\n";
 			$body .= "De " . $p->ipn_data['payer_email'] . " el " . date('m/d/Y');
 			$body .= " a las " . date('g:i A') . "\n\Detalles:\n";

 			foreach ($p->ipn_data as $key => $value) {$body .= "\n$key: $value";}
 			mail($to, $subject, $body);
 		}
 		break;
 	}
 	?>















 	<br><br><br><br><br><br>













 </div>
 <?php

 function eliminar_acentos($cadena) {

	//Reemplazamos la A y a
 	$cadena = str_replace(
 		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
 		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
 		$cadena
 	);

	//Reemplazamos la E y e
 	$cadena = str_replace(
 		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
 		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
 		$cadena);

	//Reemplazamos la I y i
 	$cadena = str_replace(
 		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
 		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
 		$cadena);

	//Reemplazamos la O y o
 	$cadena = str_replace(
 		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
 		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
 		$cadena);

	//Reemplazamos la U y u
 	$cadena = str_replace(
 		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
 		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
 		$cadena);

	//Reemplazamos la N, n, C y c
 	$cadena = str_replace(
 		array('Ñ', 'ñ', 'Ç', 'ç'),
 		array('N', 'n', 'C', 'c'),
 		$cadena
 	);

 	return $cadena;
 }
?>