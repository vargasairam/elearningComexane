<?php
require '../config/config.php';
require '../core/conexion.php';
require '../model/alumno.php';
require '../model/helper.php';


$A = new Alumno();
$H = new Helper();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case "subir":

        if(!isset($_POST['categoria'])){
            header("Location: ../subirSocios.php?acceso&error");
			exit;
        }

        $categoria = '';
        $id_categoria = isset($_POST['categoria'])? $_POST['categoria'] : 0 ;
        switch($_POST['categoria']){
            case 1:
                $categoria = 'SOCIO AL CORRIENTE 2026';
                break;
            case 2:
                $categoria = 'RESIDENTE';
                break;
            case 3:
                $categoria = 'SOCIO AL CORRIENTE 2025';
                break;
                
        }

        $response = $A->validarBecadoVistaSubirSocio($_POST['email'],$categoria);

        if(!empty($response)){
            header("Location: ../subirSocios.php?acceso&existente");
			exit;
        }
        

        $campos = ['email','categoria','categoria_id'];
		$valores = [$_POST['email'],$categoria,$id_categoria];
        $A->setTabla("aceptados");
		$id = $A->insertar($campos,  $valores);

        if($id){
            header("Location: ../subirSocios.php?acceso&exito");
			exit;
        }else{
            header("Location: ../subirSocios.php?acceso&error");
			exit;
        }
        break;
    default:
        echo 'DEFAULT';
        break;
}
