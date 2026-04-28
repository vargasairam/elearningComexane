<?php
require '../config/config.php';
require '../core/conexion.php';
require '../model/alumno.php';
require '../model/helper.php';
require '../model/transmision.php';
require '../model/sesionesMensuales.php';

if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    if (!(isset($_GET['accion']) && ($_GET['accion'] == "login"))) {
        header("Location: ../signin.php");
        exit;
    }
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$A = new Alumno();
$H = new Helper();
$T = new Transmision();
$SM = new SesionMensual();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case 'addminutoVideo':
        $T->setTabla("e26_progreso_videos");
        $vista = $T->videoVista($_POST['video_id'], $_POST['usuario_id']);

        if ($vista->visto) {
            $campos = array("minutos", "ultima_vez");
            $valores = array($vista->tiempo + 1, date("Y-m-d H:i:s"));
            $condicion = " id=" . $vista->id;

            if ($T->actualizar($campos, $valores, $condicion)) {
                echo json_encode(array('response' => 'ok'));
                exit;
            } else {
                echo json_encode(array('response' => 'fail'));
                exit;
            }
        } else {
            $campos = array("socio_id", "video_id", "minutos", "ultima_vez");
            $valores = array($_POST["usuario_id"], $_POST["video_id"], 1, date("Y-m-d H:i:s"));

            if ($T->insertar($campos, $valores)) {
                echo json_encode(array('response' => 'ok'));
                exit;
            } else {
                echo json_encode(array('response' => 'fail'));
                exit;
            }
        }
    break;

    case 'saveQuestion':
        if (isset($_POST)) {
            $A->setTabla('e26_comentarios');
            $campos = array("comentario", "socio_id", "sesion_id", "fecha_hora", "activo");
            $valores = array($_POST['question'], $_SESSION[AMBIENTE]['usuario']['id'], $_POST['modulo'], date("Y-m-d H:i:s"), 1);
            $insertado = $A->insertar($campos, $valores);
            $data = [
                'status' => 'success',
                'msg' => "Pregunta enviada"
            ];
        } else {
            $data = [
                'status' => 'error',
                'msg' => "Hubo un error, intente de nuevo"
            ];
        }
        echo json_encode($data);
    break;

    /* MARCAR VIDEO COMPLETADO */
    case 'endedVideo':
        $T->setTabla("e26_progreso_videos");

        $campos = array("completo");
        $valores = array(1);
        $condicion = " video_id=" . $_POST['video_id'] . " and usuario_id=" . $_POST['usuario_id'];

        if ($T->actualizar($campos, $valores, $condicion)) {
            echo json_encode(array('response' => 'ok'));
            exit;
        } else {
            echo json_encode(array('response' => 'fail'));
            exit;
        }
    break;

    /* MARCAR ASISTENCIA A LA SESION */
    case 'addminutoSesion':
        $SM->setTabla("e26_progreso_sesionM");
        $vista = $SM->sesionVista($_POST['sesion_id'], $_POST['usuario_id']);

        if ($vista->visto) {
            $campos = array("minutos", "ultima_vez");
            $valores = array($vista->tiempo + 1, date("Y-m-d H:i:s"));
            $condicion = " id = " . $vista->id;

            if ($SM->actualizar($campos, $valores, $condicion)) {
                echo json_encode(array('response' => 'ok'));
                exit;
            } else {
                echo json_encode(array('response' => 'fail'));
                exit;
            }
        } else {
            $campos = array("socio_id", "sesion_id", "minutos", "ultima_vez");
            $valores = array($_POST["usuario_id"], $_POST["sesion_id"], 1, date("Y-m-d H:i:s"));

            if ($SM->insertar($campos, $valores)) {
                echo json_encode(array('response' => 'ok'));
                exit;
            } else {
                echo json_encode(array('response' => 'fail'));
                exit;
            }
        }
    break;

    /* MARCAR ASISTENCIA COMPLETA EN SESION */
    case 'endedSesion':
        $T->setTabla("e26_progreso_sesionM");

        $campos = array("completo");
        $valores = array(1);
        $condicion = " sesion_id = " . $_POST['sesion_id'] . " and socio_id = " . $_POST['usuario_id'];

        if ($T->actualizar($campos, $valores, $condicion)) {
            echo json_encode(array('response' => 'ok'));
            exit;
        } else {
            echo json_encode(array('response' => 'fail'));
            exit;
        }
    break;

    default:
        echo 'DEFAULT';
    break;
}
