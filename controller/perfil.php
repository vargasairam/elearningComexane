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
require '../model/alumno.php';
require '../model/socios.php';

$A = new Alumno();
$H = new Helper();
$S = new Socios();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
	case "ActualizarPerfilAcceso":

        $campos = [
            'email',
            'contrasena'
        ];

        $valores = [
            $_POST['email'],
            $_POST['password']
        ];

        $condicion = 'id_socio = '.$_SESSION[AMBIENTE]['usuario']['id'];
        try {
            $S->actualizar($campos,$valores,$condicion);
            $H->crearMensaje("Actualizado correctamente", "success");
        } catch (\Throwable $th) {
            $H->crearMensaje("No se pudo actualizar su información", "danger");
        }

		header("Location: ../?seccion=perfil");
		exit;

		break;
    case "ActualizarPerfilDatosPersonales":

        $campos = [
            'prefijotxt',
            'nombre',
            'apellidop',
            'apellidom',
            'nombreconstancia',
            'f_nacimiento',
            'celular',
            'curp',
        ];

        if($_POST['prefijo'] == 'OTRO'){
            $_POST["prefijo"] = $_POST["prefijo2"] ?? '';
        }

        $valores = [
            $_POST['prefijo'],
            $_POST['nombre'],
            $_POST['apellidop'],
            $_POST['apellidom'],
            $_POST['n_constancia'],
            $_POST['f_nacimiento'],
            $_POST['telefono'],
            $_POST['curp'],
        ];

        $condicion = 'id_socio = '.$_SESSION[AMBIENTE]['usuario']['id'];

        try {
            $S->actualizar($campos,$valores,$condicion);
            $H->crearMensaje("Actualizado correctamente", "success");
        } catch (\Throwable $th) {
            $H->crearMensaje("No se pudo actualizar su información", "danger");
        }
		/*header("Location: ../?seccion=perfil");
		exit;*/
	break;

    case "ActualizarPerfilDatosUbicacion":

        $campos = [
            'calle',
            'numint',
            'numext',
            'colonia',
            'delomun',
            'cp',
            'estado',
        ];

        $valores = [
            $_POST['calle'],
            $_POST['interior'],
            $_POST['exterior'],
            $_POST['colonia'],
            $_POST['municipio'],
            $_POST['cp'],
            $_POST['estado'],
        ];

        $condicion = 'id_socio = '.$_SESSION[AMBIENTE]['usuario']['id'];

        try {
            $S->actualizar($campos,$valores,$condicion);
            $H->crearMensaje("Actualizado correctamente", "success");
        } catch (\Throwable $th) {
            $H->crearMensaje("No se pudo actualizar su información", "danger");
        }
		header("Location: ../?seccion=perfil");
		exit;

	break;

    case "ActualizarPerfilDatosProfesionales":

        $campos = [
            'ced_prof',
            'ced_espec',
            'pregrado',
        ];

        $valores = [
            $_POST['ced_prof'],
            $_POST['ced_espec'],
            $_POST['pregrado'],
        ];

        $condicion = 'id = '.$_SESSION[AMBIENTE]['usuario']['id'];

        try {
            $A->actualizar($campos,$valores,$condicion);
            $H->crearMensaje("Actualizado correctamente", "success");
        } catch (\Throwable $th) {
            $H->crearMensaje("No se pudo actualizar su información", "danger");
        }
		header("Location: ../?seccion=perfil");
		exit;

	break;

}
