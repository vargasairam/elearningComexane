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
            <div class="uk-card-default p-4">
                <div class="mb-4 uk-text-center">
                    <?php
                    $tema = $_GET['T'];
                    $preguntas = $A->preguntas($tema);
                    ?>
                    <h3 class="mb-0">Has contestado satisfactoriamente la encuesta del tema: <?php echo $tema ?></h3>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "view/estructura/footer.php";
    ?>
</body>

</html>