<?php
require __DIR__.'/../../config/config.php';
require __DIR__.'/../../core/conexion.php';
require __DIR__.'/../../model/helper.php';
require __DIR__.'/../../model/cursosModulos.php';
require __DIR__.'/../../model/cursosVideos.php';

if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    if (!(isset($_GET['accion']) && ($_GET['accion'] == "login"))) {
        header("Location: ../signin.php");
        exit;
    }
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$H = new Helper();
$CM = new CursosModulos();
$CV = new CursosVideos();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case 'addModulo':   
        $CM->setTabla("e26_modulos_cursos");
        $campos = array("id_curso", "titulo", "detalles", "f_inicio", "f_fin", "poster_modulo");

        $carpeta_destino = '../../imgs/cursos_posters/modulos_posters/';        
        $nombre_archivo = null;

        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        if(isset($_FILES['poster_modulo']) && $_FILES['poster_modulo']['error'] === 0){
            $poster_modulo = $_FILES['poster_modulo'];
            $poster_name = $poster_modulo['name'];

            $nombre_archivo = uniqid() . "_" . $poster_modulo['name'];
            $ruta_completa = $carpeta_destino  . $nombre_archivo;
            move_uploaded_file($poster_modulo['tmp_name'], $ruta_completa);
        }

        if(isset($_POST['id_update'])){
            $datos = $CM->getModuloById($_POST['id_update']);

            if($nombre_archivo == null){
                $nombre_archivo = $datos[0]->poster_modulo;
            }

            $valores = array($_POST['id_curso'], $_POST["titulo"], $_POST["detalles"], $_POST["fecha_inicio"], $_POST["fecha_fin"], $nombre_archivo);
            $condicion = "id = ". $_POST['id_update'];
            $result = $CM->actualizar($campos, $valores, $condicion); 

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
            $valores = array($_POST['id_curso'], $_POST["titulo"], $_POST["detalles"], $_POST["fecha_inicio"], $_POST["fecha_fin"], $nombre_archivo);
            $result = $CM->insertar($campos, $valores); 

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
    case 'getModulosCurso':
        $data['data'] = $CM->getModulosCurso($_POST['id_curso']);
        echo json_encode($data);
    break;
    case 'getModuloById':
        $data = $CM->getModuloById($_POST['id_modulo']);
        echo json_encode($data);
    break;
    // Videos del curso
    case 'addVideo':   
        $CV->setTabla("e26_videos_cursos");
        $campos = array("id_curso", "id_modulo", "titulo", "tema", "ponentes", "descripcion", "fecha_texto", "canal1", "canal2", "duracion", "tipo", "portada_video");

        $carpeta_destino = '../../imgs/cursos_posters/portadas_videos/';        
        $nombre_archivo = null;

        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        if(isset($_FILES['portada']) && $_FILES['portada']['error'] === 0){
            $poster_modulo = $_FILES['portada'];
            $poster_name = $poster_modulo['name'];

            $nombre_archivo = uniqid() . "_" . $poster_modulo['name'];
            $ruta_completa = $carpeta_destino  . $nombre_archivo;
            move_uploaded_file($poster_modulo['tmp_name'], $ruta_completa);
        }

        $id_modulo = isset($_POST['id_modulo']) ? $_POST['id_modulo'] : 0;

        if(isset($_POST['id_update'])){
            $datos = $CV->getVideoById($_POST['id_update']);

            if($nombre_archivo == null){
                $nombre_archivo = $datos[0]->portada_video;
            }

            $valores = array($_POST['id_curso'], $id_modulo, $_POST["titulo"], $_POST["tema"], $_POST["ponentes"], $_POST["detalles"], $_POST["f_publicacion"], $_POST["canal1"], $_POST["canal2"], $_POST["duracion"], "ondemand", $nombre_archivo);
            $condicion = "id = ". $_POST['id_update'];
            $result = $CV->actualizar($campos, $valores, $condicion); 

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
            $valores = array($_POST['id_curso'], $id_modulo, $_POST["titulo"], $_POST["tema"], $_POST["ponentes"], $_POST["detalles"], $_POST["f_publicacion"], $_POST["canal1"], $_POST["canal2"], $_POST["duracion"], "ondemand", $nombre_archivo);
            $result = $CV->insertar($campos, $valores); 

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
    case 'getVideosCurso':
        $data['data'] = $CV->getVideosCurso($_POST['id_curso']);
        echo json_encode($data);
    break;
    case 'getVideoById':
        $data = $CV->getVideoById($_POST['id_video']);
        echo json_encode($data);
    break;
    case 'getVideosModulo':
        $data['data'] = $CV->getVideosModulo($_POST['id_curso'], $_POST['id_modulo']);
        echo json_encode($data);
    break;
    default:
        echo 'DEFAULT';
        break;
}
