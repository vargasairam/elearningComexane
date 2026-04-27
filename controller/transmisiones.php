<?php
require '../config/config.php';
require '../core/conexion.php';
require '../model/alumno.php';
require '../model/helper.php';
require '../model/transmision.php';

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

    /* FUNCIONES AMEH */
    case "guardarLive":
        //NOTA Francisco------------------------------------------------
        $modulo = $T->modulofin($_SESSION[AMBIENTE]['usuario']['id']); //! Busca todos los modulos pagos 
        $alumno = $T->getCategoria($_SESSION[AMBIENTE]['usuario']['id']); //! Busca la categoria para aplicar validaciones del candado

        $fecha_actual = date("Y-m-d H:i:s");

        $candado = false; //!Este candado lo utiizamos para validar los pagos y los modulos

        if ($alumno->categoria_id == 5) {
            //Nota Esta validacion solo aplica si es categoria 5 (pago por modulos)
            foreach ($modulo as $m) {
                if ($m->fecha_hr_fin > $fecha_actual && $m->fecha_hr_inicio < $fecha_actual) { //! aqui validamos si existe un modulo pagado en el rango de fechas de los modulos
                    $candado = true;
                    // echo "Yo fui el actual".$m->id."<br>";
                }
            }
        } else {
            $candado = true;
        }

        if ($candado) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            //AQUI VA EL CONTEO PARA MODULOS
            $A->setTabla("progresos_transmision_modulo");
            $campos = array("usuario_id", "modulo_id", "tiempo", "fecha_hora_inicio");
            $valores = array($_SESSION[AMBIENTE]['usuario']['id'], $data['modulo'], 1, date("Y-m-d H:i:s"));

            $insertado = $A->insertar($campos, $valores);

            if (isset($data)) {
                $module = $T->visualizadoLive($_SESSION[AMBIENTE]['usuario']['id'], $data['modulo']);
                $A->setTabla("progresos_transmision");
                if (!$module) {
                    $campos = array("usuario_id", "modulo_id", "tiempo", "fecha_hora_inicio");
                    $valores = array($_SESSION[AMBIENTE]['usuario']['id'], $data['modulo'], 0, date("Y-m-d H:i:s"));
                    $insertado = $A->insertar($campos, $valores);
                    echo json_encode(array("status" => "success"));
                    exit;
                } else {
                    $campos = array("usuario_id", "modulo_id", "tiempo", "visto_ultimavez");
                    $valores = array($_SESSION[AMBIENTE]['usuario']['id'], $data['modulo'], $data['segundos'], date("Y-m-d H:i:s"));

                    $condicion = "usuario_id=" . $_SESSION[AMBIENTE]['usuario']['id'] . " AND modulo_id=" . $data['modulo'];
                    $A->actualizar($campos, $valores, $condicion);
                    echo json_encode(array("status" => "success"));
                    exit;
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Falta información"));
                exit;
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Falta información"));
            exit;
        }
        break;
    case 'saveQuestion':
        if (isset($_POST)) {
            $A->setTabla('comentarios');
            $campos = array("comentario", "usuario_id", "modulo_id", "fecha_hora", "activo");
            $valores = array($_POST['question'], $_SESSION[AMBIENTE]['usuario']['id'], $_POST['modulo'], date("Y-m-d H:i:s"), 1);
            $insertado = $A->insertar($campos, $valores);
            echo json_encode(array("status" => "success"));
            // header('Location: ../?seccion=live');
            exit;
        } else {
            echo json_encode(array("status" => "error", "message" => "Falta información"));
            // header('Location: ../?seccion=live');
            exit;
        }

        break;

    

    case 'ended':
        if ($_GET['accion'] == "ended" && isset($_GET['video_id']) && is_numeric($_GET['video_id'])) {

            $T->setTabla("progresos_videos");



            $campos = array("completo");

            $valores = array(1);

            $condicion = " video_id=" . $_GET['video_id'] . " and usuario_id=" . $_GET['usuario_id'];

            if ($T->actualizar($campos, $valores, $condicion)) {

                echo json_encode(array('response' => 'ok'));

                exit;
            } else {

                echo json_encode(array('response' => 'fail'));

                exit;
            }
        }

        break;

    case 'sumartiempo':

        $modulo = $T->modulofin($_GET['usuario_id']); //! Busca todos los modulos pagos 

        $alumno = $T->getCategoria($_GET['usuario_id']); //! Busca la categoria para aplicar validaciones del candado



        $fecha_actual = date("Y-m-d H:i:s");



        $candado = false; //!Este candado lo utiizamos para validar los pagos y los modulos



        if ($alumno->categoria_id == 5) {

            //Nota Esta validacion solo aplica si es categoria 5 (pago por modulos)

            foreach ($modulo as $m) {

                if ($m->fecha_hr_fin > $fecha_actual && $m->fecha_hr_inicio < $fecha_actual) { //! aqui validamos si existe un modulo pagado en el rango de fechas de los modulos

                    $candado = true;

                    // echo "Yo fui el actual".$m->id."<br>";

                }
            }
        } else {

            $candado = true;
        }



        if ($candado) {

            //NOTA Francisco------------------------------------------------

            //? Aqui metemos asistencia de a minuto para el conteo de modulo

            $campos = array("usuario_id", "modulo_id", "tiempo", "visto_ultimavez", "fecha_hora_inicio");

            $valores = array($_GET["usuario_id"], $_GET["modulo_id"], 1, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"));

            $T->setTabla("progresos_transmision_modulo");

            $T->insertar($campos, $valores);

            //? Fin conteo modulo

            $T->setTabla("progresos_transmision");

            $vista = $T->transmisionVista($_GET['modulo_id'], $_GET['usuario_id']);

            if ($vista->visto) {

                $campos = array("tiempo", "visto_ultimavez");

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

                $campos = array("usuario_id", "modulo_id", "tiempo", "visto_ultimavez", "fecha_hora_inicio");

                $valores = array($_GET["usuario_id"], $_GET["modulo_id"], 0, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"));

                if ($T->insertar($campos, $valores)) {

                    echo json_encode(array('response' => 'ok'));

                    exit;
                } else {

                    echo json_encode(array('response' => 'fail'));

                    exit;
                }
            }
        } else {

            echo json_encode(array('response' => 'Tiempo de modulo Agotado')); //! redireciona fail por que ya termino su tiempo que pago en el modulo 

            exit;
        }

        break;

    default:

        echo 'DEFAULT';

        break;
}
