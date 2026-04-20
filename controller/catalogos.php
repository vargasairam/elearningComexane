<?php
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../core/conexion.php';
require_once __DIR__.'/../model/catalogos.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$cat = new Catalogos();


$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case "GetCategoriasNombres":

        $AllCategorias = $cat->GetCategoriasNombres();
        $estatus = false;
        if(!empty($AllCategorias)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$AllCategorias]);
        break;
    case 'GetPrefijos':
        $data =$cat->GetPrefijosActivos();

        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
        break;
    case 'GetCatalogos':
        //$prefijos =$cat->GetPrefijosActivos();
        $AllCategoriasNSocio = $cat->GetCategoriasNSocio();
        $paises = $cat->GetPaises();

        $data = (object)[];
        /*if(!empty($prefijos)){
            $data->prefijos=$prefijos;
        }*/

        if(!empty($AllCategoriasNSocio)){
            $data->categorias = $AllCategoriasNSocio;
        }

        if(!empty($paises)){
            $data->paises = $paises;
        }

        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
        exit;
        break;
    case 'GetEstados':
        $input = json_decode(file_get_contents('php://input'));
        $datos = $input->datos;
        $id_pais = $datos->pais;

        $estados = $cat->GetEstadosByIdPais($id_pais);

        $data = (object)[];
        if(!empty($estados)){
            $data->estados=$estados;
        }

        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
    break;
    case 'GetRegimenFiscal':
        $data =$cat->GetRegimenFiscal();

        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
        break;

    case 'GetCFDIAll':
        $data =$cat->GetCFDIAll();

        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
        break;
    case 'GetCFDI':
        $data =$cat->GetCFDI($_GET['id']);

        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
        break;

    case 'SubirPrograma':
        try {
                if (isset($_FILES['programa']) && $_FILES['programa']['error'] === UPLOAD_ERR_OK) {

                $file = $_FILES['programa'];

                // Carpeta destino
                $dir = __DIR__ . '/../pdf/';

                // Si no existe la carpeta, se crea
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

                //Nombre
                $nuevoNombre = 'PROGRAMA PRELIMINAR CURSO HBE 2026_V1.pdf';
                $destino = $dir . $nuevoNombre;

                // Mover archivo
                if (move_uploaded_file($file['tmp_name'], $destino)) {
                } 

            }

            } catch (\Throwable $th) {
                //throw $th;
            }
        header("Location: https://curso-ameh.com/subirPrograma.php");
		exit;
    break;
    case 'GetCursos':
        $data = $cat->GetCursosActivos();
        $estatus = false;
        if(!empty($data)){
            $estatus = true;
        }
        echo json_encode(['status'=>$estatus,'data'=>$data]);
        break;
    default:
        echo 'DEFAULT';
        break;
}
