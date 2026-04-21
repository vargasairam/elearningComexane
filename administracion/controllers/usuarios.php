<?php
require __DIR__.'/../../config/config.php';
require __DIR__.'/../../core/conexion.php';
require __DIR__.'/../../model/alumno.php';
require __DIR__.'/../../model/helper.php';
require __DIR__.'/../../model/usuario.php';

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
$U = new Usuario();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case "login":
        if (isset($_POST['email']) && isset($_POST['password']) && $_POST['password'] != "" && $_POST['email'] != "") {
            $usuario = $U->login($_POST['email'], $_POST['password']);
            
            if ($usuario->registrado) {
                $id_sessionx = $H->crearSesion("admin", $usuario->id);
                /*var_dump($_SESSION[AMBIENTE]['usuario']['rol']);
                exit();*/
                header("Location: ../");
                exit;
            }
            

            header("Location: ../signin.php");
            exit;
        } else {
            $H->crearMensaje("Falta información", "danger");
            header("Location: ../signin.php");
            exit;
        }
        break;
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
