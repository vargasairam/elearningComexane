<?php
require '../config/config.php';
require '../core/conexion.php';
require '../model/alumno.php';
require '../model/helper.php';
require '../model/usuario.php';
require '../model/catalogos.php';
require '../model/socios.php';
require 'redpay.php';


if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    /*var_dump((!isset($_GET['accion']) && ($_GET['accion'] == "login")));
    exit;*/
    if (!isset($_GET['accion']) || ($_GET['accion'] != "login" && $_GET['accion'] != "registroSesion")) {
        header("Location: ../signin.php");
        exit;
    }
    /*if ((!(isset($_GET['accion']) && ($_GET['accion'] == "login"))) || (!(isset($_GET['accion']) && ($_GET['accion'] == "registroSesion")))) {
        header("Location: ../signin.php");
        exit;
    }*/
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$A = new Alumno();
$H = new Helper();
$U = new Usuario();
$C = new Catalogos();
$R = new Redpay();
$S = new Socios();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case "login":
        if (isset($_POST['email']) && isset($_POST['password']) && $_POST['password'] != "" && $_POST['email'] != "") {            
            $alumno = $A->login($_POST['email'], $_POST['password']);
            if ($alumno->registrado) {
                $id_sessionx = $H->crearSesion("alumno", $alumno->id_socio);
                $S->setTabla("e26_logueos");
                $campos = array("alumno_id", "fecha_hora", "ip", "dispositivo", "id_sesion");
                $valores = array($alumno->id_socio, date("Y-m-d H:i:s"), $H->get_real_ip(), strtolower($_SERVER['HTTP_USER_AGENT']), $id_sessionx);
                $S->insertar($campos, $valores);
                $days = 30; // configurable
                $seconds = $days * 24 * 60 * 60;
                setcookie("sessionx_" . AMBIENTE, $id_sessionx, time() + $seconds, "/");

                $H->crearMensaje("Bienvenido", "success");
                header("Location: ../");
                exit;
            } else {
                $alumno = $S->busqSocioByCorreo($_POST['email']);
                if(!empty($alumno)){
                    $H->crearMensaje("Su correo se encuentra registrado, pero la contraseña en incorrecta", "danger");
                    header("Location: ../signin.php");
                    exit;
                }
            }
            
            $H->crearMensaje("Por favor registra tus datos en el formulario.", "danger");
            header("Location: ../registro.php");
            exit;
        } else {
            $H->crearMensaje("Falta información", "danger");
            header("Location: ../signin.php");
            exit;
        }
    break;
    case 'AgregarAlCarrito':
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        $curso_id = $_POST['curso_id'];
        $A->setTabla("e26_cursos_carrito");
        $campos = array("id_alumno", "id_curso");
        $valores = array($id, $curso_id);
        $result = $A->insertar($campos, $valores);

        if($result){
            $data = [
                'status' => 'success',
                'msg' => "Curso agregado al carrito"
            ];
        } else {
            $data = [
                'status' => 'error',
                'msg' => "Hubo un error, intente de nuevo"
            ];
        }
        echo json_encode($data);
    break;
    case 'ProductosEnCarrito':
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        $data = $C->GetCursosCarrito($id);
        echo json_encode($data);
    break;
    case 'GetCursos':
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        $data = $A->GetCursosPagados($id);
        echo json_encode($data);
    break;

    case 'procederPago':
        $id_alumno = $_SESSION[AMBIENTE]['usuario']['id'];
        $email = $S->getAlumnoById($id_alumno)[0]->email;

        $S->setTabla("e26_pagos_cursos");
        $campos = array("id_alumno", "totalPagado", "f_pago", "status");
        $valores = array($id_alumno, $_POST['totalPago'], date("Y-m-d H:i:s"), "PENDIENTE");
        $id_pago = $S->insertar($campos, $valores);

        $referencia = "CMX".$id_pago."-".date("ymdhms");

        foreach($_POST['id_curso'] as $key => $id_curso){
            $S->setTabla("e26_cursos_alumnos");
            $campos = array("id_pago", "id_curso");
            $valores = array($id_pago, $id_curso);
            for ($i = 0; $i < $_POST['cantidad'][$key]; $i++) {
                $S->insertar($campos, $valores);
            }            
        }

        $data = $R->CrearOrden($_POST['totalPago'], $email, $referencia);
        $url = trim($data, '"');
        //var_dump($url);
        echo json_encode($url);
        exit;
    break;
    case 'registroSesion':
        $id_sesion = $_POST['sesion'];
        $correo = $_POST['email'];
        $alumno = $S->busqSocioByCorreo($correo);
        if(empty($alumno)){
            $data = [
                'status' => 'error',
                'msg' => "El correo no existe"
            ];
            echo json_encode($data);
            exit;
        }
        $id_alumno = $alumno[0]->id_socio;
        $folio = new DateTime();
        $folio = $folio->format('dmy');
        $folio .= $id_alumno;

        $S->setTabla("sesionesasistentes");
        $campos = array("sesion_id", "socio_id", "fecha_hora", "folio"); 
        $valores = array($id_sesion, $id_alumno, date("Y-m-d H:i:s"), $folio);
        $validarRegistro = $S->validarRegistroSesion($id_alumno, $id_sesion);
        if($validarRegistro->existe > 0){
            $data = [
                'status' => 'warning',
                'msg' => "Ya te has registrado a esta sesión"
            ];
            $H->crearMensaje($data['msg'], $data['status']);
            header("Location: ../signin.php");
            exit;
        }
        if($S->insertar($campos, $valores)){
            $data = [
                'status' => 'success',
                'msg' => "Te registraste correctamente"
            ];
            $H->crearMensaje($data['msg'], $data['status']);
            header("Location: ../signin.php");
            exit;
        } else {
            $data = [
                'status' => 'error',
                'msg' => "Hubo un error, intente de nuevo"
            ];
            $H->crearMensaje($data['msg'], $data['status']);
            header("Location: ../signin.php");
            exit;
        }
        exit;
    break;
    // ************ AMEH CASES ************
    case 'AplicarBeca':
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        $beca = $A->validarCodigo($_POST['codigo']);

        if ($beca->existe && $beca->disponible) {
			$A->setTabla("codigos");
			$campos = array("usado_por",  "fecha_uso", "disponible");
			$valores = array($id, date("Y-m-d H:i:s"),0);
			$condicion = " id>0 and id=" . $beca->id;
			$A->actualizar($campos, $valores, $condicion);

            if($beca->descuento==100){
                $A->setTabla("inscripciones");
                $campos = array("alumno_id", "estatus", "observaciones",  "fecha_pago", "monto", "hema_2024", "pago_beca");
                $valores = array($alumno->id, "BECADO", "Beca: " . $beca->codigo, date("Y-m-d H:i:s"), 0, 1, 1);
                $A->insertar($campos,  $valores);
            }
            $H->crearMensaje("La beca se aplicó correctamente y el monto fue actualizado.", "success");
        }else{
            $H->crearMensaje("El código no existe o ya fue aplicado anteriormente. Verifica la información e inténtalo de nuevo.", "danger");
        }

        
        header("Location: ../?seccion=pagos");
        exit;
        break;
    default:
        echo 'DEFAULT';
        break;
}
