<?php
require __DIR__.'/../../config/config.php';
require __DIR__.'/../../core/conexion.php';
require __DIR__.'/../../model/helper.php';
require __DIR__.'/../../model/catalogos.php';
require __DIR__.'/../../model/foro.php';

if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    if (!(isset($_GET['accion']) && ($_GET['accion'] == "login"))) {
        header("Location: ../signin.php");
        exit;
    }
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$H = new Helper();
$C = new Catalogos();
$FR = new ForoResidentes();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case 'getVideosForo':
        $data['data'] = $FR->getVideosForo();
        echo json_encode($data);
    break;
    case 'getVideoForoById':
        $data = $FR->getVideoForoById($_POST['id_video']);
        echo json_encode($data);
    break;
    case 'addVideoForo':   
        $FR->setTabla("e26_foro_residentes");
        $campos = array("titulo", "ponentes_ids", "descripcion", "temario", "fecha_hora_inicio", "fecha_hora_fin", "canal1", "canal2", "duracion", "portada_video");

        $fecha_inicio = $_POST["f_inicio"];
        $fecha_fin = $_POST["f_fin"];

        $carpeta_destino = '../../imgs/foro_portadas/portadas_videos/';        
        $nombre_archivo = null;

        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        if(isset($_FILES['portada_video']) && $_FILES['portada_video']['error'] === 0){
            $poster_modulo = $_FILES['portada_video'];
            $poster_name = $poster_modulo['name'];

            $nombre_archivo = uniqid() . "_" . $poster_modulo['name'];
            $ruta_completa = $carpeta_destino  . $nombre_archivo;
            move_uploaded_file($poster_modulo['tmp_name'], $ruta_completa);
        }

        if(isset($_POST['id_update'])){
            $datos = $FR->getVideoForoById($_POST['id_update']);

            if($nombre_archivo == null){
                $nombre_archivo = $datos->portada_video;
            }

            $valores = array($_POST["titulo"], $_POST["ponentes"], $_POST["detalles"], $_POST["tema"],  $fecha_inicio, $fecha_fin, $_POST["canal1"], $_POST["canal2"], $_POST["duracion"], $nombre_archivo);
            $condicion = "id = ". $_POST['id_update'];
            $result = $FR->actualizar($campos, $valores, $condicion); 

            if($result){
                $data = [
                    'status' => 'success',
                    'msg' => "Actualizado correctamente"
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'msg' => "Hubo un error, intente de nuevo"
                ];
            }
        } else {
            $valores = array($_POST["titulo"], $_POST["ponentes"], $_POST["detalles"], $_POST["tema"], $fecha_inicio, $fecha_fin, $_POST["canal1"], $_POST["canal2"], $_POST["duracion"], $nombre_archivo);

            $result = $FR->insertar($campos, $valores); 

            if($result > 0){
                $data = [
                    'status' => 'success',
                    'msg' => "Agregado correctamente"
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'msg' => "Hubo un error, intente de nuevo"
                ];
            }
        }
        
        echo json_encode($data);
    break;
    default:
        echo 'DEFAULT';
        break;
}
