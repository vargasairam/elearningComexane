<?php

include 'config.php';
require './models/conexion.php';
require './../models/helper.php';
require './models/encuesta.php';

$A = new Encuesta();
$H = new Helper();

$developer = true;

$seccion = (isset($_GET['seccion']) && $_GET['seccion'] != "") ? $_GET['seccion'] : "dashboard";
$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "dashboard";

$jc=str_contains($alumno->email, 'jc-innovation.com');
switch ($seccion) {
	case "editRes":
		require 'models/conferencia.php';
		$C = new Conferencia();
		$conferencias = $A->getAllConferencias();
		$script = "programa/editR.php";
	break;
}
?>