<?php

require_once __DIR__ .'/../model/catalogos.php';
require_once __DIR__.'/../model/usuario.php';
require_once __DIR__.'/../model/cursosModulos.php';

$CC = new Catalogos();
$U = new Usuario();
$CM = new CursosModulos();

$seccion = '';
if (isset($_SESSION[AMBIENTE]['usuario']['id'])) {
    $user = $U->getUsuarioById($_SESSION[AMBIENTE]['usuario']['id']);
    $seccion = (isset($_GET['seccion']) && $_GET['seccion'] != "") ? $_GET['seccion'] : "estructura";
}

switch ($seccion) {
    case "administracion":    
        $seccions = "estructura";
        $accion = "main_index";
        $tittle = "Inicio";
    break;
    case "catalogos":  
        switch (isset($_GET['accion']) ? $_GET['accion'] : '') {
            case 'tipoProducto':
                $accion = "tipoProducto";
                $seccions = "catalogos";
                $tittle = "Catálogo de tipos de productos";
            break;
            case 'cursos':
                $accion = "cursos";
                $seccions = "catalogos";
                $tittle = "Catálogo de Productos";
            break;
            default:
                $seccions = "estructura";
                $accion = "main_index";
                $tittle = "Inicio";
            break;
        }
    break;
    case "modulos": 
        switch (isset($_GET['accion']) ? $_GET['accion'] : '') {
            case 'videos':
                $id_modulo = isset($_GET['id_modulo']) ? $_GET['id_modulo'] : 0;
                $modulo = $CM->getModuloById($id_modulo);
                $accion = "videos";
                $seccions = "modulos";
                $tittle = "Videos de ".$modulo[0]->titulo;
            break;
            default:
                $id_curso = isset($_GET['id_curso']) ? $_GET['id_curso'] : 0;
                $curso = $CC->getCursoById($id_curso);
                $seccions = "cursos";
                $accion = "modulos";
                $tittle = "Módulos del ".$curso[0]->titulo;
            break;
        }
    break;
    case "cursos": 
        switch (isset($_GET['accion']) ? $_GET['accion'] : '') {
            case 'videos':
                $id_curso = isset($_GET['id_curso']) ? $_GET['id_curso'] : 0;
                $curso = $CC->getCursoById($id_curso);
                $accion = "videos";
                $seccions = "cursos";
                $tittle = "Videos de ".$curso[0]->titulo;
            break;
            default:
                $accion = "cursos";
                $seccions = "catalogos";
                $tittle = "Catálogo de Productos";
            break;
        }
    break;
    case 'logout':
        unset($_SESSION[AMBIENTE]);
        header("location: signin.php");    
        exit;
    break;
    /*case "modulos":  
        
        switch (isset($_GET['accion']) ? $_GET['accion'] : '') {
            case 'videos':
                $accion = "videos";
                $seccions = "modulos";
                $tittle = "Videos del módulo ".$modulo[0]->titulo;
            break;
            default:
                $seccions = "estructura";
                $accion = "main_index";
                $tittle = "Inicio";
            break;
        }
    break;*/
    default:
        $seccions = "estructura";
        $accion = "main_index";
        $tittle = "Inicio";
    break;  
}    

$vista = $seccions . "/" . $accion . ".php";