<?php
require_once('config.php');
require_once DIRECTORIO . '/../core/conexion.php';
require_once DIRECTORIO . '/../model/configuracion.php';

$Conf = new Configuracion();
$configuracion = $Conf->getConfiguracion();
