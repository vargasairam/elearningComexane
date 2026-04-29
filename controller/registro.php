<?php
require '../config/config.php';
require '../core/conexion.php';
require '../model/alumno.php';
require '../model/socios.php';
require '../model/helper.php';

// if (!isset($_SESSION[AMBIENTE]['usuario'])) {
//     if (!(isset($_GET['accion']) && ($_GET['accion'] == "login"))) {
//         header("Location: ../signin.php");
//         exit;
//     }
// }
ini_set('display_errors', 1);
error_reporting(E_ALL);

$A = new Alumno();
$H = new Helper();
$S = new Socios();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case "Registro":
		$data = json_decode(file_get_contents("php://input"), true);
		$datos = $data['datos']['informacion'];

        date_default_timezone_set('America/Mexico_City');


        if($datos["datos"]["prefijo"] == 'OTRO'){
            $datos["datos"]["prefijo"] = $datos["datos"]["prefijo2"] ?? '';
        }

        //SE VERIFICA SI EXISTE EL CORREO, PARA ACTUALIZAR O INSERTAR
        $alumno = $S->emailRepetido($datos['cuenta']['correo']);
		/*var_dump($datos['cuenta']['correo']);
		var_dump($datos['fiscal']['curp']);
		exit;*/
		
		if ($alumno->repetido) { // actualizar datos del alumno
			echo json_encode(['status' => false, 'msg' => 'El correo electrónico ya está registrado en el sistema de socios, puedes iniciar sesión con las mismas credenciales']);
			exit;
			/*$campos = array("nombre", "apellidop", "apellidom", "calle", "numext", "numint", "colonia", "delomun", "cp", "estado", "celular", "email", "curp", "prefijotxt", "nombreconstancia", "id_categoria");
			
			$valores = array($datos["datos"]["nombre"], 
			$datos["datos"]["apellidop"], 
			$datos["datos"]["apellidom"], 
			$datos["ubicacion"]["calle"], 
			$datos["ubicacion"]["exterior"], 
			$datos["ubicacion"]["interior"], $datos["ubicacion"]["colonia"], $datos["ubicacion"]["municipio"], $datos["ubicacion"]["cp"], $datos["ubicacion"]["estado"], $datos["datos"]["celular"], $datos["cuenta"]["correo"], $datos["fiscal"]["curp"], $datos["datos"]["prefijo"], $datos["datos"]["n_constancia"], $datos["cuenta"]["categoria"]);
			$A->setTabla("socios");
			$condicion = " id_socio > 0 and id_socio = ". $alumno->id_socio;
			$A->actualizar($campos, $valores, $condicion); */
		} else{ // insertar datos del alumno
			$campos = array("contrasena",
			"nombre", 
			"apellidop", 
			"apellidom", 
			"calle",
			"numext", 
			"numint", 
			"colonia", 
			"delomun", 
			"cp", 
			"estado", 
			"celular", 
			"email", 
			"curp", 
			"prefijotxt", 
			"nombreconstancia", 
			"id_categoria");

			$valores = array($datos["cuenta"]["pass"],
			$datos["datos"]["nombre"],
			$datos["datos"]["apellidop"], 
			$datos["datos"]["apellidom"], 
			$datos["ubicacion"]["calle"], 
			$datos["ubicacion"]["exterior"], 
			$datos["ubicacion"]["interior"], 
			$datos["ubicacion"]["colonia"], 
			$datos["ubicacion"]["municipio"], 
			$datos["ubicacion"]["cp"], 
			$datos["ubicacion"]["estado"], 
			$datos["datos"]["celular"], 
			$datos["cuenta"]["correo"], $datos["fiscal"]["curp"], $datos["datos"]["prefijo"], $datos["datos"]["n_constancia"], $datos["cuenta"]["categoria"]);
			$A->setTabla("socios");
			$id = $A->insertar($campos, $valores);
			$alumno->id = $id;
		}

        $alumno = $S->getAlumnoById($alumno->id_socio);

		if ($alumno[0]->id_socio > 0) {
			$id_sessionx = $H->crearSesion("alumno", $alumno[0]->id_socio);
			/*$H->enviarCorreoRegistro($datos["datos"]["nombre"], $datos["datos"]["apellido"], $datos['cuenta']['correo'], $datos["cuenta"]["pass"]);*/

			/*$beca = $A->validarCodigo($_POST['codigo']);
			$id_sessionx = $H->crearSesion("medico", $alumno->id);

			if($liberar){
				$A->setTabla("inscripciones");
				$campos = array("alumno_id", "estatus", "observaciones", "fecha_pago", "monto", "hema_2024", "pago_beca");
				$valores = array($alumno->id, "BECADO",  "Lista ".$motivo_liberacion, date("Y-m-d H:i:s"), 0, 1, 1);
				$A->insertar($campos,  $valores);
				$H->enviarCorreoRegistroCompleto($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["password"]);
				$H->crearMensaje("Bienvenido, su registro está CONFIRMADO", "success");
			}else if ($beca->existe && $beca->disponible) {
				$A->setTabla("codigos");
				$campos = array("usado_por",  "fecha_uso", "disponible");
				$valores = array($alumno->id, date("Y-m-d H:i:s"),0);
				$condicion = " id>0 and id=" . $beca->id;
				$A->actualizar($campos, $valores, $condicion);

                if($beca->descuento==100){
                    $A->setTabla("inscripciones");
                    $campos = array("alumno_id", "estatus", "observaciones",  "fecha_pago", "monto", "hema_2024", "pago_beca");
                    $valores = array($alumno->id, "BECADO", "Beca: " . $beca->codigo, date("Y-m-d H:i:s"), 0, 1, 1);
                    $A->insertar($campos,  $valores);
                    $H->enviarCorreoRegistroCompleto($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["password"]);
                } else{
                    $H->enviarCorreoRegistro($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["password"]);
                }
				

				
				$H->crearMensaje("Bienvenido, su registro está CONFIRMADO", "success");
			}else{
				$H->enviarCorreoRegistro($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["password"]);
				$H->crearMensaje("Bienvenido, sus datos se registraron correctamente. Continúe con el proceso para finalizar su registro.", "success");
			}*/
					
			$A->setTabla("e26_logueos");
			$campos = array("alumno_id", "fecha_hora", "ip", "dispositivo", "id_sesion");
			$valores = array($alumno[0]->id_socio, date("Y-m-d H:i:s"), $H->get_real_ip(), strtolower($_SERVER['HTTP_USER_AGENT']), $id_sessionx);
			$A->insertar($campos, $valores);

			echo json_encode(['status'=>true]);


			//header("Location: ../");
			exit;
		} else {
			/*$H->crearMensaje("Ocurrio un error", "danger");
			header("Location: ../registro.php");*/
			echo json_encode(['status' =>false]);

			exit;
		}

        // $id_sessionx = $H->crearSesion("medico", $id);
        // $A->setTabla("logeos");
        // $campos = array("alumno_id", "fecha_hora", "ip", "dispositivo", "id_sesion");
        // $valores = array($id, date("Y-m-d H:i:s"), $H->get_real_ip(), strtolower($_SERVER['HTTP_USER_AGENT']), $id_sessionx);
        // $A->insertar($campos, $valores);
        // $days = 30; // configurable
        // $seconds = $days * 24 * 60 * 60;
        // setcookie("sessionx_" . AMBIENTE, $id_sessionx, time() + $seconds, "/");

        // $H->crearMensaje("Bienvenido", "success");
        //header("Location: ../");
        exit;

    break;
    case "correoSocio":
        $correo = $_GET['correo'];
        $response = $S->busqSocioByCorreo($correo);
		if(!empty($response)){
			echo json_encode([
				'success' => true,
				'data' => $response
			]);
		} else{
			echo json_encode([
				'success' => false
			]);
		}
    break;
    default:
        echo 'DEFAULT';
        break;
}
