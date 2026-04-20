<?php
require_once(__DIR__.'/../config/auto_configuracion.php');
require_once(__DIR__.'/../model/alumno.php');
require_once(__DIR__.'/../model/helper.php');
require_once(__DIR__.'/../model/configuracion.php');

$A = new Alumno();
$H = new Helper();
$Conf = new Configuracion();

require_once(__DIR__.'/route.php');

if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    header("Location: signin.php");
    exit;
}

$configuracion = $Conf->getConfiguracion();
$usuario = $U->getUsuarioById($_SESSION[AMBIENTE]['usuario']['id']); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title><?= $configuracion->nombre_sistema ?></title>
    <meta charset="UTF-8" />

    <link rel="shortcut icon" href="<?= $configuracion->logo ?>" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.min.css">

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

    <?php include_once __DIR__."/../config/auto_script.php"; ?>
</head>

<body>
    <main class="wrapper_global">
        <?php include_once "view/estructura/menu/main_menu.php"; ?>
        <div class="container-fluid mx-md-1 w-100">
            <?php include_once __DIR__ . '/view/' . $vista; ?>
        </div>
    </main>
    <?php include_once __DIR__."/../config/base_script.php"; ?>
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