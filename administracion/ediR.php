<?PHP
include 'config.php';
require './models/conexion.php';
require './../models/helper.php';
require './models/encuesta.php';

$A = new Encuesta();
$H = new Helper();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/night-mode.css">
    <link rel="stylesheet" href="../assets/css/framework.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/image-map-pro.min.css">
    <link rel="stylesheet" href="../assets/css/icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <style>
        @media (max-width: 480px) {
            [class*='uk-width'] {
                width: 90%;
                max-width: 90%;
                padding-top: 5px;
                padding-bottom: 5px
            }

            .p-5 {
                padding: 1rem !important;
            }
        }
    </style>
</head>

<body style="background-image: url(../assets/images//imagen-fondo.jpg); background-size: cover;">
    <div class="page-content">
        <div class="uk-width-2-3@m uk-width-1-2@s m-auto">
            <div class="">
                <div class="container">
                    <div class="row">
                        <?php
                        include "view/estructura/header.php";
                        ?>
                        <div class="mb-4 uk-text-center">
                            <?php
                            $tema = $_GET['T'];
                            $preguntas = $A->preguntas($tema);
                            $primerElemento = $preguntas[0];
                            $id = $primerElemento->id_tema;
                            ?>
                            <h3 class="mb-0"><?php echo $tema ?></h3>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="mb-4 uk-text-center">
                                <div class="p-5">
                                    <a href="./edit.php?T=<?php echo $tema ?>" class="btn btn-default">Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-card-default p-4">
                <form id="miFormulario" class="uk-child-width-1-1@s uk-grid-small" uk-grid action="controllers/encuesta.php?accion=editR" method="post">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <?php foreach ($preguntas as $index => $p) { ?>
                        <div class="uk-width-1-1@s">
                            <div class="uk-form-group">
                                <label class="uk-form-label" for=""><?php echo $p->pregunta ?></label>
                                <input type="hidden" name="orig_pregunta_<?php echo $index; ?>" value="<?php echo $p->pregunta ?>">
                            </div>
                        </div>
                        <?php
                        $respuestas = $A->resp($tema, $p->pregunta);
                        $op = 1;
                        foreach ($respuestas[0] as $clave => $valor) {
                            if (strpos($clave, 'op_') === 0 && !empty($valor)) { ?>
                                <div class="uk-width-1-1@s">
                                    <div class="uk-form-group">
                                        <input type="text" name="<?php echo $index; ?>_op_<?php echo $op; ?>" value="<?php echo $valor ?>">
                                    </div>
                                </div>
                        <?php $op++;
                            }
                        } ?>
                    <?php } ?>
                    <div class="uk-width-1-1">
                        <button class="uk-button uk-button-primary" type="submit">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include "view/estructura/footer.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    </script>
</body>

</html>