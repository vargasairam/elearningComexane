<?php
require '../config/config.php';
if (!isset($_SESSION[AMBIENTE]['usuario'])) {
	if (!(isset($_GET['accion']) && ($_GET['accion'] == "registropublico" || $_GET['accion'] == "login" || $_GET['accion'] == "loginauth" || $_GET['accion'] == "liberarregistro" || $_GET['accion'] == "liberarAcceso" || $_GET['accion'] == "liberarSocio" || $_GET['accion'] == "ocultar"))) {
		header("Location: ../signin.php");
		exit;
	}
}
ini_set('display_errors', 1);
error_reporting(E_ALL);


require '../core/conexion.php';
require '../model/helper.php';
require '../model/catalogos.php';
require '../model/AlumnoFacturacion.php';

$C = new Catalogos();
$H = new Helper();
$alumnoFacturacion = new AlumnoFacturacion();
$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
	case 'GetFacturacion':
		$alumnoId = $_SESSION[AMBIENTE]['usuario']['id'];
		$facturacion = $alumnoFacturacion->obtener($alumnoId);

        if(empty($facturacion)){
            $data = (object)[];

            $regimen = $C->GetRegimenFiscal();
            $cfdi = $C->GetCFDI('601');
            

            if(!empty($regimen)){
                $data->regimen=$regimen;
            }

            if(!empty($cfdi)){
                $data->cfdi=$cfdi;
            }

            

            $facturacion = $data;

            $status = false;
        }else{
            $status = true;
        }

        $paises = $C->GetPaises();

        if(!empty($paises)){
            $facturacion->paises=$paises;
        }

        

		echo json_encode(['status'=>$status,'data'=>$facturacion]);
	break;

    case 'GuardarFacturacion':

        $requiere_factura = isset($_POST['switchFactura']) ? 1 : 2;
        $id = $_SESSION[AMBIENTE]['usuario']['id'];

        $campos = [
            'requiere_factura'
        ];

        $valores = [
            $requiere_factura
        ];

        $condicion = 'id = '.$id;
        $H->setTabla('e26_alumnos');
        $H->actualizar($campos,$valores,$condicion);

        if($requiere_factura==1){
            $campos = [
                'razon_social',
                'rfc',
                'estado',
                'regimen_fiscal',
                'uso_de_cfdi',
                'alumno_id',
                'municipio',
                'pais',
                'colonia',
                'calle',
                'codigo_postal'
            ];

            $valores = [
                $_POST['razon_fis'],
                $_POST['rfc_fis'],
                $_POST['estado_fis'],
                $_POST['regimen'],
                $_POST['cdfi'],
                $id,
                $_POST['municipio_fis'],
                $_POST['pais_fis'],
                $_POST['colonia_fis'],
                $_POST['calle_fis'],
                $_POST['cp_fis']
            ];

            
            
            $condicion = 'alumno_id = '.$id;
            $H->setTabla('e26_alumno_facturacion');
            
            if($alumnoFacturacion->TieneDatosFactura($id)){
                $H->actualizar($campos,$valores,$condicion);
            }else{
                $H->insertar($campos,$valores);
            }

            try {
                if (isset($_FILES['cif']) && $_FILES['cif']['error'] === UPLOAD_ERR_OK) {

                $file = $_FILES['cif'];

                // Carpeta destino
                $dir = __DIR__ . '/../storage/';

                // Si no existe la carpeta, se crea
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

                //Nombre
                $nuevoNombre = $id.'_Constancia_Situacion_Fiscal' . '.' . $extension;
                $destino = $dir . $nuevoNombre;

                // Mover archivo
                if (move_uploaded_file($file['tmp_name'], $destino)) {
                } 

            }

            } catch (\Throwable $th) {
                //throw $th;
            }
            
        }

        $H->crearMensaje("Datos guardados con éxito.", "success");

        if(isset($_POST['modalPagar'])){
            header("Location: ../?seccion=pagos");
		    exit;
        }

        header("Location: ../?seccion=perfil");
		exit;
        
        break;
    case 'GuardarDesicionRequiereFactura':

        $requiere_factura = $_POST['factura'] == 'si' ? 1 : 2;
        $id = $_SESSION[AMBIENTE]['usuario']['id'];


        $campos = [
            'requiere_factura'
        ];

        $valores = [
            $requiere_factura
        ];

        $condicion = 'id = '.$id;
        $H->setTabla('alumnos');
        $H->actualizar($campos,$valores,$condicion);

        if($requiere_factura==2){
            header("Location: ../?seccion=pagar");
		    exit;
        }
        header("Location: ../?seccion=perfil");
		exit;
        
        break;

}
