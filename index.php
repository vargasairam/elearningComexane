<?php
require_once('config/auto_configuracion.php');
require_once('model/alumno.php');
require_once('model/helper.php');
require_once('model/configuracion.php');
require_once('model/socios.php');

$A = new Alumno();
$H = new Helper();
$Conf = new Configuracion();
$S = new Socios();

require_once('route.php');

if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    header("Location: signin.php");
    exit;
}

$configuracion = $Conf->getConfiguracion();
$alumno = $S->getAlumnoById($_SESSION[AMBIENTE]['usuario']['id']);
//calcula el costo si tiene descuento, solo si tiene categoria de PUBLICO EN GENERAL
/*if($alumno->categoria_id==4){
    if(!empty($alumno->descuento)){
        $descuento =  round($alumno->costo * (1 - ($alumno->descuento / 100)),2);
        $alumno->costoCopia = $alumno->costo;
        $alumno->costo = $descuento;
    }
}*/

    $categoria = $A->GetCategoria($_SESSION[AMBIENTE]['usuario']['id']); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title><?= $configuracion->nombre_sistema ?></title>
    <meta charset="UTF-8" />

    <link rel="shortcut icon" href="<?= $configuracion->logo ?>" />

    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta
        http-equiv="Cache-control"
        content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />

    <!-- Chrome, Firefox OS y Opera -->
    <meta name="theme-color" content="<?= $configuracion->color ?>" />
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="<?= $configuracion->color ?>" />
    <!-- iOS Safari -->
    <meta name="mobile-web-app-capable" content="yes" />

    <meta name="author" content="JC Innovations ft. Alex P. Montero" />
    <meta name="application-name" content="<?= $configuracion->nombre_sistema ?>" />
    <meta name="description" content="<?= $configuracion->nombre_sistema ?>" />

    <meta property="og:locale" content="es_ES" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $configuracion->nombre_sistema ?>" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="<?= $configuracion->nombre_sistema ?>" />
    <meta property="og:image" itemprop="image" content="imgs/bg_seo.png" />
    <meta property="og:description" content="<?= $configuracion->nombre_sistema ?>" />
    <title><?= $configuracion->nombre_sistema ?></title>

    <?php include_once "config/auto_script.php"; ?>
</head>

<body>
    <main class="wrapper_global">
        <?php         
            if($_SESSION[AMBIENTE]['usuario']['rol'] == "admin"){
                include_once "view/administracion/estructura/main_menu.php";
            } else {
                include_once "view/estructura/menu/main_menu.php";
            }
        ?>
        <div class="container-fluid mx-md-1 w-100">
            <?php include_once __DIR__ . '/view/' . $vista; ?>
        </div>
    </main>
    <?php include_once "config/base_script.php"; ?>
    <script src="js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            menu();
        });
    </script>
    <?php 
    $activar_vimeo = false;
    if (isset($_GET['seccion']) && ($_GET['seccion']=="ondemand"  && $activar_vimeo)) { ?>
        <script src="https://player.vimeo.com/api/player.js"></script>

        <script>

            $(document).ready(function() { 
                <?php if(isset($videos) && !empty($videos)){
                    foreach ($videos as $video) { ?>
                        $.ajax({
                            type:'GET',
                            url: 'https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/<?=$video->canal1;?>',
                            jsonp: 'callback',
                            dataType: 'jsonp',
                            success: function(data){

                                var thumbnail_src = data.thumbnail_url;
                                $('.thumb_<?php echo $video->id;?>').attr('src', thumbnail_src);
                            }
                        });
                    <?php }
                } ?>
            });
        </script>
    <?php } ?>
</body>

</html>