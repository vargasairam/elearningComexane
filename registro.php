<?php

require_once('config/auto_configuracion.php');



//$modulo = $configuracion->url_administracion;



if (isset($_SESSION[AMBIENTE]['usuario']['id_sesion'])) {

    header("Location: ./");

}

?>

<!DOCTYPE html>

<html lang="es">



    <head>

        <meta charset="UTF-8" />

        <meta

            name="viewport"

            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

        <meta http-equiv="X-UA-Compatible" content="ie=edge" />

        <meta

            http-equiv="Cache-control"

            content="no-cache, no-store, must-revalidate" />

        <meta http-equiv="Pragma" content="no-cache" />



        <!-- Chrome, Firefox OS y Opera -->

        <!-- <meta name="theme-color" content="<?= $configuracion->color ?>" /> ver como conigurar -->

        <!-- Windows Phone -->

        <!-- <meta name="msapplication-navbutton-color" content="<?= $configuracion->color ?>" /> ver como conigurar -->

        <!-- iOS Safari -->

        <meta name="mobile-web-app-capable" content="yes" />



        <meta name="author" content="JC Innovations ft. Alex P. Montero" />

        <meta name="application-name" content="Plataforma Virtual COMEXANE A.C." />

        <meta name="description" content="Plataforma Virtual COMEXANE A.C." />



        <meta property="og:locale" content="es_ES" />

        <meta property="og:type" content="website" />

        <meta property="og:title" content="Plataforma Virtual COMEXANE A.C." />

        <meta property="og:url" content="" />

        <meta property="og:site_name" content="Plataforma Virtual COMEXANE A.C." />

        <meta property="og:image" itemprop="image" content="imgs/bg_seo.png" />

        <meta property="og:description" content="Plataforma Virtual COMEXANE A.C." />

        <title>Plataforma Virtual COMEXANE A.C.</title>

        <?php include_once "config/auto_script.php"; ?>        
        

    </head>



    <body>
        <?php include_once "config/base_script.php"; ?>
        <?php include_once "view/estructura/main_registro.php"; ?>
       
    </body>
</html>