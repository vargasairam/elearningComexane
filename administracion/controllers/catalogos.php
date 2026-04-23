<?php
require __DIR__.'/../../config/config.php';
require __DIR__.'/../../core/conexion.php';
require __DIR__.'/../../model/helper.php';
require __DIR__.'/../../model/catalogos.php';

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

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case "login":
        if (isset($_POST['email']) && isset($_POST['password']) && $_POST['password'] != "" && $_POST['email'] != "") {
            $usuario = $U->login($_POST['email'], $_POST['password']);
            if ($usuario->registrado) {
                $id_sessionx = $H->crearSesion("admin", $usuario->id);
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
    case 'addTipoProducto':
        $campos = array("tipoProducto", "descripcion", "habilitado", "activo");        
        $C->setTabla("e26_tipoProducto");

        if(isset($_POST['id_update'])){
            $valores = array($_POST['tipo_producto'], $_POST["descripcion"], 0, 0);
            $condicion = "id = ". $_POST['id_update'];
            $result = $C->actualizar($campos, $valores, $condicion); 

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
            $valores = array($_POST['tipo_producto'], $_POST["descripcion"], 0, 0);
            $result = $C->insertar($campos, $valores); 

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
    case 'getTipos':
        $data['data'] = $C->GetTipoProductos();
        echo json_encode($data);
    break;
    case 'getTipoProductoById':
        $data = $C->GetTipoProductoById($_POST['id_tipoP']);
        echo json_encode($data);
    break;
    case 'getCursos':
        $data['data'] = $C->getCursos();
        echo json_encode($data);
    break;
    case 'addCurso':
        $campos = array("id_tipoProducto", "titulo", "descripcion", "fecha_hora_inicio", "fecha_hora_fin", "precio", "modulos", "n_modulos", "porcentaje_constancia", "habilitado", "activo", "poster");        
        $C->setTabla("e26_cursos");

        $nombre_archivo = null;
        $path_poster = '../../imgs/cursos_posters/';
        $path_constancia = '../../storage/pdf/constancia_pantilla/';
        $modulos = isset($_POST['modulos']) ? $_POST['modulos'] : 0;
        $n_modulos = isset($_POST['n_modulos']) ? $_POST['n_modulos'] : 0;

        if(isset($_FILES['poster_small']) && $_FILES['poster_small']['error'] === 0){
            $poster_small = $_FILES['poster_small'];
            $poster_name = $poster_small['name'];
            $carpeta_destino = '../../imgs/cursos_posters/';
            

            if (!file_exists($path_poster)) {
                mkdir($path_poster, 0777, true);
            }

            $nombre_archivo = uniqid() . "_" . $poster_small['name'];
            $ruta_completa = $carpeta_destino  . $nombre_archivo;
            move_uploaded_file($poster_small['tmp_name'], $ruta_completa);
        }

        if(isset($_FILES['constancia_pantilla']) && $_FILES['constancia_pantilla']['error'] === 0){
            $constancia_pantilla = $_FILES['constancia_pantilla'];
            $constancia_name = $constancia_pantilla['name'];
            $carpeta_destino = '../../storage/pdf/constancia_pantilla/';
            
            if (!file_exists($path_constancia)) {
                mkdir($path_constancia, 0777, true);
            }

            $nombre_archivo = uniqid() . "_" . $constancia_pantilla['name'];
            $ruta_completa = $carpeta_destino  . $nombre_archivo;
            move_uploaded_file($constancia_pantilla['tmp_name'], $ruta_completa);
        }

        
        if(isset($_POST['id_update'])){
            $datos = $C->getCursoById($_POST['id_update']); 

            if($nombre_archivo == null){
                $nombre_archivo = $datos[0]->poster;
            }

            $valores = array($_POST['tipoCurso'], $_POST["titulo"], $_POST["descripcion"], $_POST["f_inicio"], $_POST["f_fin"], $_POST["precio"], $modulos, $n_modulos, $_POST["porcentaje_constancia"], $_POST["habilitado"], 0, $nombre_archivo);
            $condicion = "id = ". $_POST['id_update'];
            $result = $C->actualizar($campos, $valores, $condicion); 

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
            $valores = array($_POST['tipoCurso'], $_POST["titulo"], $_POST["descripcion"], $_POST["f_inicio"], $_POST["f_fin"], $_POST["precio"], $modulos, $n_modulos, $_POST["porcentaje_constancia"], $_POST["habilitado"], 0, $nombre_archivo); 
            $result = $C->insertar($campos, $valores);

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
    case 'getCursoById':
        $data = $C->getCursoById($_POST['id_curso']);
        echo json_encode($data);
    break;
    case 'updHabilitadoCurso':
        $C->setTabla("e26_cursos");
        $campos = array("habilitado");
        $valores = array($_POST['habilitado']);
        $condicion = "id = ". $_POST['id_curso'];
        $result = $C->actualizar($campos, $valores, $condicion);
        if($result > 0){
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
        echo json_encode($data);
    break;
    case 'getSesiones':
        $data['data'] = $C->GetSesionesAll();
        echo json_encode($data);
    break;
    case 'getSesionById':
        $data = $C->getSesionById($_POST['id_sesion']);
        echo json_encode($data);
    break;
    case 'addSesion':   
        $C->setTabla("e_conferencias");
        $campos = array("conferencia", "ponentes_ids", "descripcion", "temario", "fecha_hora_inicio", "fecha_hora_fin", "canal1", "canal2", "duracion", "poster_sesion");

        $fecha_inicio = $_POST["f_inicio"] . " " . $_POST["h_inicio"];
        $fecha_fin = $_POST["f_fin"] . " " . $_POST["h_fin"];

        $carpeta_destino = '../../imgs/sesiones_mensuales/poster_sesion/';        
        $nombre_archivo = null;

        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        if(isset($_FILES['poster_sesion']) && $_FILES['poster_sesion']['error'] === 0){
            $poster_modulo = $_FILES['poster_sesion'];
            $poster_name = $poster_modulo['name'];

            $nombre_archivo = uniqid() . "_" . $poster_modulo['name'];
            $ruta_completa = $carpeta_destino  . $nombre_archivo;
            move_uploaded_file($poster_modulo['tmp_name'], $ruta_completa);
        }

        if(isset($_POST['id_update'])){
            $datos = $C->getSesionById($_POST['id_update']);

            if($nombre_archivo == null){
                $nombre_archivo = $datos->poster_sesion;
            }

            $valores = array($_POST["titulo"], $_POST["ponentes"], $_POST["detalles"], $_POST["tema"],  $fecha_inicio, $fecha_fin, $_POST["canal1"], $_POST["canal2"], $_POST["duracion"], $nombre_archivo);
            $condicion = "id = ". $_POST['id_update'];
            $result = $C->actualizar($campos, $valores, $condicion); 

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

            $result = $C->insertar($campos, $valores); 

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
