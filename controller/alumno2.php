<?php
require '../config/config.php';
if (!isset($_SESSION[AMBIENTE]['usuario'])) {
	if (!(isset($_GET['accion']) && ($_GET['accion'] == "registropublico" || $_GET['accion'] == "login" || $_GET['accion'] == "loginauth" || $_GET['accion'] == "liberarregistro" || $_GET['accion'] == "liberarAcceso" || $_GET['accion'] == "liberarSocio" || $_GET['accion'] == "ocultar"))) {
		header("Location: ../signin.php");
		exit;
	}
}
ini_set('display_errors', 1);
error_reporting(E_ALL);


require '../core/conexion.php';
require '../model/helper.php';
require '../model/alumno.php';
require '../model/AlumnoFacturacion.php';

$A = new Alumno();
$H = new Helper();
$alumnoFacturacion = new AlumnoFacturacion();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
	case "actualizarC":

		$validacion = $A->validarBecado($_POST['email']);
		$liberar=false;
		$motivo_liberacion="";
		if(isset($validacion->id)){
			$_POST['categoria']=$validacion->categoria_id;
			if ($validacion->categoria_id==1 || $validacion->categoria_id==2){
				$liberar=true;
				$motivo_liberacion=$validacion->categoria;
			}
			
		}else if ($_POST['categoria'] <= 3 ) {
			$H->crearMensaje("No se pudo actualizar de categoría ya que no aparece como socio al corriente 2025, 2026 o becado, selecciona otra categoría", "danger");
			header("Location: ../");
			exit;
		}
		
		$A->setTabla("alumnos");
		$campos = array("categoria_id");
		$valores = array($_POST['categoria']);
		$condicion = " id='" . $_POST['id'] . "' ";
		$A->actualizar($campos, $valores, $condicion);
		if($_POST['categoria']==5){
			if($A->existePagoModulo($_SESSION[AMBIENTE]['usuario']['id'])){
				$H->crearMensaje("Actualización correcta, su registro está CONFIRMADO", "success");
				header("Location: ../?seccion=pagar");
				exit;
			}
		}
		
		
		if ($liberar) {
			$A->setTabla("inscripciones");
			$campos = array("alumno_id", "estatus", "observaciones", "fecha_pago", "monto", "hema_2024", "pago_beca");
			$valores = array($_POST['id'], "BECADO",  "Lista ".$motivo_liberacion, date("Y-m-d H:i:s"), 0, 1, 1);
			$A->insertar($campos,  $valores);
			// $H->enviarCorreoRegistroCompleto($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["password"]);
			$H->crearMensaje("Actualización correcta, su registro está CONFIRMADO", "success");
			header("Location: ../");
			exit;
		}
		$H->crearMensaje("Actualizado correctamente", "success");
		header("Location: ../");
		exit;

		break;
	case "modulo":
		$exite_mod = $A->existeM($_POST['alumno'], $_POST['modulo']);
		if (!$exite_mod) {
			$m = $_POST['modulo'];
			$A->setTabla("pagos_modulos");
			$campos = array("id_socio", "modulo", "fecha");
			$valores = array($_POST['alumno'], $_POST['modulo'], date("Y-m-d H:i:s"));
			$pago = $A->insertar($campos, $valores);
			$H->crearMensaje("Se ha guardado éxitosamente el módulo, continua en el formulario de pago", "success");
			header("Location: ../?seccion=pagar&mod=$m");
			exit;
		} else {
			$H->crearMensaje("Ya seleccionaste este módulo, si no has realizado puedes continuar mas abajo.", "danger	");
			header("Location: ../?seccion=pagar");
			exit;
		}
		break;

	// case "liberarregistro":
	// 	$alumno = $A->getAlumnoById($_GET['alumno']);
	// 	$A->setTabla("inscripciones");
	// 	$campos = array("alumno_id", "estatus", "observaciones", "fecha_pago", "monto");
	// 	$valores = array($alumno->id, "PAGADO", "Liberado", date("Y-m-d H:i:s"), 0);
	// 	$pago = $A->insertar($campos, $valores);

	// 	$folio = str_pad($pago, 5, "0", STR_PAD_LEFT);

	// 	$H->enviarCorreoConfirmacionEvento($alumno, $folio);

	// 	$H->crearMensaje("Bienvenido", "success");
	// 	header("Location: ../admin/students.php");
	// 	exit;
	// 	break;





	// case "becar":
	// 	if (isset($_POST['beca']) && $_POST['beca'] != "" && is_numeric($_POST['alumno'])) {
	// 		if (isset($_POST['beca']) && $_POST['beca'] != "") {
	// 			$beca = $A->validarCodigo($_POST['beca']);
	// 			if($beca->existe){
	// 				if($beca->usado_por){
	// 					$H->crearMensaje("El código de beca ya no se encuentra disponible, si tiene problemas con su código envia un correo a jesus@jc-innovation.com para obtener soporte.", "danger");
	// 					header('Location: https://curso-ameh.com/?seccion=pagar');
	// 					exit;
	// 				}else{
	// 					$alumno = $A->getAlumnoById($_POST['alumno']);
	// 					$A->setTabla("codigos");
	// 					$campos = array("usado_por",  "fecha_uso", "disponible");
	// 					$valores = array($alumno->id, date("Y-m-d H:i:s"),0);
	// 					$condicion = " id>0 and id=" . $beca->id;
	// 					$A->actualizar($campos, $valores, $condicion);

	// 					$A->setTabla("inscripciones");
	// 					$campos = array("alumno_id", "estatus", "observaciones",  "fecha_pago", "monto", "hema_2024", "pago_beca");
	// 					$valores = array($alumno->id, "BECADO", "Beca: " . $beca->codigo, date("Y-m-d H:i:s"), 0, 1, 1);
	// 					$A->insertar($campos,  $valores);

	// 					$H->enviarCorreoRegistroCompleto($alumno->nombre, $alumno->apellidos, $alumno->email, $alumno->password);
	// 					$H->crearMensaje("Su beca fue aplicada, su registro está confirmado ", "success");
	// 					header('Location: https://curso-ameh.com/?seccion=pagar');
	// 					exit;
	// 				}
	// 			}else{
	// 				$H->crearMensaje("El código de beca no es válido, verifica tu código,  si tiene problemas con su código envia un correo a jesus@jc-innovation.com para obtener soporte", "danger");
	// 				header('Location: https://curso-ameh.com/?seccion=pagar');
	// 				exit;
	// 			}
	// 		}
	// 		$H->crearMensaje("El código de beca ingresado no es válido", "danger");
	// 		header('Location: https://curso-ameh.com/?seccion=pagar');
			
	// 	} else {
	// 		$H->crearMensaje("Ingresa código de beca", "danger");
	// 	}
	// 	header('Location: ../');
	// 	exit;
	// break;



	// case 'liberarAcceso':
	// 	$A->setTabla("inscripciones");
	// 	$campos = array("alumno_id", "estatus", "observaciones", "cambio_por", "fecha_caducidad", "fecha_pago", "monto");
	// 	$valores = array($_GET['usuario'], "PAGADO", "Liberado", 0, "0000-00-00 00:00:00", date("Y-m-d H:i:s"), 0);
	// 	$A->insertar($campos, $valores);

	// 	$alumno = $A->getAlumnoById($_GET['usuario']);
	// 	$H->enviarCorreoConfirmacionEvento($alumno, $folio);

	// 	header("Location: ../liberarAcceso.php?password=ameh");
	// 	break;

	// case 'liberarSocio':
	// 	if (isset($_GET['id'])) {
	// 		$A->setTabla("validaciones");
	// 		$campos = array("observacion");
	// 		$valores = array(2023);
	// 		$condicion = ' id=' . $_GET['id'];
	// 		if ($A->actualizar($campos, $valores, $condicion)) {
	// 			header("Location: ../vigencias.php?mensaje=exito");
	// 			exit;
	// 		}
	// 		header("Location: ../vigencias.php?mensaje=error");
	// 		exit;
	// 	} else {
	// 		$datos = $A->getValidacionEmail(trim($_POST['email']));
	// 		if ($datos && $datos->email) {
	// 			$A->setTabla("validaciones");
	// 			$campos = array("observacion");
	// 			$valores = array($_POST['anio']);
	// 			$condicion = ' id=' . $datos->id;
	// 			if ($A->actualizar($campos, $valores, $condicion)) {
	// 				header("Location: ../vigencias.php?mensaje=exito");
	// 				exit;
	// 			}
	// 			header("Location: ../vigencias.php?mensaje=error");
	// 			exit;
	// 		} else {
	// 			$A->setTabla("validaciones");
	// 			$campos = array("observacion", "email");
	// 			$valores = array($_POST['anio'], trim($_POST['email']));
	// 			if ($A->insertar($campos, $valores)) {
	// 				header("Location: ../vigencias.php?mensaje=exito");
	// 				exit;
	// 			}
	// 			header("Location: ../vigencias.php?mensaje=error");
	// 			exit;
	// 		}
	// 	}
	// 	header("Location: ../vigencias.php?mensaje=error");
	// 	exit;

	// 	break;


	// case 'editar':
	// 	if (!$A->actualizarAlumno($_SESSION[AMBIENTE]['usuario']['id'], $_POST)) {
	// 		$H->crearMensaje("Se desconoce la petición", "danger");
	// 	}
	// 	header("Location: ../?seccion=perfil&accion=editar");
	// 	break;

	// case 'facturacion':
	// 	/** @var integer|null $alumnoId */
	// 	$alumnoId = $_SESSION[AMBIENTE]['usuario']['id'];
	// 	/** @var false|array $facturacion */
	// 	$facturacion = $alumnoFacturacion->obtener($alumnoId, true);
	// 	if (!$facturacion) {
	// 		$facturacion = $alumnoFacturacion->crear($alumnoId, $_POST);
	// 		header('Location: ../?seccion=perfil&accion=editar');
	// 		return;
	// 	}
	// 	if (!$alumnoFacturacion->modificarAlumno($alumnoId, $_POST)) {
	// 		$H->crearMensaje('error al actualizar', 'error');
	// 	}
	// 	header('Location: ../?seccion=perfil&accion=editar');
	// 	break;
	// case 'ocultar':
	// 	$campos = array('activo');
	// 	$valores = array(1);
	// 	$condicion = " id=" . $_GET['id'];
	// 	$A->setTabla("comentarios");
	// 	$A->actualizar($campos, $valores, $condicion);
	// 	$responses[] = array('response' => 'si');
	// 	echo json_encode($responses);
	// 	break;

	default:
		echo 'DEFAULT';
		break;
}
