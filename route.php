<?php
require_once('model/transmision.php');
$T = new Transmision();
require_once __DIR__ . '/model/catalogos.php';
require_once __DIR__ . '/model/socios.php';
require_once __DIR__ . '/model/sesionesMensuales.php';

$CC = new Catalogos();
$S = new Socios();

//$transmision = $T->getTransmision();
$seccion = '';

if (isset($_SESSION[AMBIENTE]['usuario']['id'])) {
    $user = $S->alumnoById($_SESSION[AMBIENTE]['usuario']['id']);
    $seccion = (isset($_GET['seccion']) && $_GET['seccion'] != "") ? $_GET['seccion'] : "estructura";
    //$pagado = $A->tienePermisos($_SESSION[AMBIENTE]['usuario']['id']);
    $pagado = true;
    $flagPagos = false;
    $bloquearCategoria = false;
    $congreso2024Ondemand = false;
    $accesoClasesGrabadas = false;
    if (!$pagado && $seccion != "perfil" && $seccion != 'logout') {
        $seccion = "pagar";
        $flagPagos = true;
    } else {
        $accesoClasesGrabadas = true;
        $congreso2024Ondemand = true;
    }

    //if ($A->existePagoModulo($_SESSION[AMBIENTE]['usuario']['id'])) {
    if (true) {
        if ($user->id_categoria == 5) {
            $flagPagos = true;
            $bloquearCategoria = true;
        }
    } else {
        if ($pagado && $seccion == 'pagar' && $user->id_categoria != 5) {
            $seccion = '';
        }
        if ((isset($user->id_categoria) && $user->id_categoria == 5)) {
            $flagPagos = true;
        }
    }
}


switch ($seccion) {
    case 'perfil':
        $accion = "perfil";
        $seccions = "perfil";
        $tittle = "Perfil";
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        require_once 'model/AlumnoFacturacion.php';
        $F = new AlumnoFacturacion();
    break;
    case 'logout':    
        unset($_SESSION[AMBIENTE]);    
        header("location: signin.php");    
        exit;    
    break;       
    case 'misCursos':
        $accion = "misCursos";
        $seccions = "misCursos";
        $tittle = "Mis Cursos";
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
    break;
    case 'cursos':
        switch (isset($_GET['accion']) ? $_GET['accion'] : '') {
            case 'recording':
                include __DIR__ . '/model/videos.php';
                $V = new Videos();
                $video = $V->getVideoById($_GET['id']);
                $accion = "recording";
                $seccions = "misCursos";
                $tittle = $video->titulo;
            break;
            default:
                $id = $_GET['curso'];
                $curso_info = $CC->getCursoById($id);
                $accion = "detallesCurso";
                $seccions = "misCursos";
                $tittle = $curso_info[0]->titulo;
        }
        
        /*$accion = "detallesCurso";
        $seccions = "misCursos";*/
        
    break;
    case "pagar":
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        require_once 'model/AlumnoFacturacion.php';
        $F = new AlumnoFacturacion();
        $seccions = "pagos";
        $accion = "pagar";
        $tittle = "Pagar productos";
    break;
    case "sesionMensual":
        $SM = new SesionMensual();
        $sesiones = $SM->getSesionesMensualesByUsuario($_SESSION[AMBIENTE]['usuario']['id']);
        $id = $_SESSION[AMBIENTE]['usuario']['id'];
        $seccions = "misCursos";
        $accion = "sesionMensual";
        $tittle = "Sesiones mensuales";
    break;
    default:
        $seccions = "estructura";
        $accion = "main_index";
        $tittle = "Inicio";
    break;

    //
    case 'live':
        require_once('model/transmision.php');
        $T = new Transmision();
        $transmision = $T->getTransmision();
        $accion = "live";
        $seccions = "live";
        $tittle = "Sala en vivo";
        break;
    case 'constancias':
        require_once('model/constancia.php');
        require_once('model/congreso.php');
        require_once('model/videos.php');

        $C = new Constancia();
        $Congreso = new Congreso();
        $V = new Videos();

        $modulos = $A->modulP($user->id);
        $dias = $Congreso->getAllDias(2025);
        $accion = "constancias";

        $seccions = "constancias";
        $tittle = "Constancias";
        break;
    case 'ondemand':
        switch (isset($_GET['accion']) ? $_GET['accion'] : '') {
            case 'modulo1':
            case 'modulo2':
            case 'modulo3':
            case 'modulo4':
                include 'model/videos.php';
                $V = new Videos();
                $accionN = $_GET['accion'];
                if (preg_match('/\d+/', $accionN, $matches)) {
                    $numero = $matches[0]; // "1"
                    echo $numero;
                }
                $accion = "modulo";
                $seccions = "ondemand";
                $tittle = "On demand";
            break;
            case 'recording':
                include 'model/videos.php';
                $V = new Videos();
                $video = $V->getVideoById($_GET['id']);
                $numero = $_GET['modulo'];
                $accion = "recording";
                $seccions = "ondemand";
                $tittle = "On demand";
            break;
            default:
                $accion = "ondemand";
                $seccions = "ondemand";
                $tittle = "On demand";
                break;
        }

    break;    
}

$vista = $seccions . "/" . $accion . ".php";