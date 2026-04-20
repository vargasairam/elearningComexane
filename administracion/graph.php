<?PHP
include 'config.php';
require './models/conexion.php';
require './../models/helper.php';
require './models/encuesta.php';

$A = new Encuesta();
$H = new Helper();
$tema = $_GET['T'];
$datos = array();
$valores = $A->opcionesP($tema);
foreach ($valores as $valor) {
    $pregunta = $valor->pregunta;
    $op_1 = $valor->respuesta;
    $total_r = $valor->total_r;

    if (!isset($datos[$pregunta])) {
        $datos[$pregunta] = array(
            'pregunta' => $pregunta,
            'op_1' => array($op_1),
            'total_r' => array($total_r)
        );
    } else {
        $datos[$pregunta]['op_1'][] = $op_1;
        $datos[$pregunta]['total_r'][] = $total_r;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/night-mode.css">
    <link rel="stylesheet" href="../assets/css/framework.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/image-map-pro.min.css">


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
        <div class="uk-width-6-6@m uk-width-6-6@s m-auto p-5">
            <div class="">
                <div class="container">
                    <div class="row">
                        <?php
                        include "view/estructura/header.php";
                        ?>
                        <div class="mb-4 uk-text-center">
                            <?php
                            $preguntas = $A->preguntas($tema);
                            $primerElemento = $preguntas[0];
                            $id = $primerElemento->id_tema;
                            ?>
                            <h3 class="mb-0">Gráfica de encuesta: <?php echo $tema ?></h3>
                            <input type="hidden" data-id="<?php echo $tema ?>">
                        </div>
                        <div class="col-md-2 mb-2 uk-text-center">
                            <div class="mb-4 uk-text-center">
                                <div class="p-2">
                                    <a href="./" class="btn btn-default">Regresar</a>
                                </div>
                                <div class="p-2">
                                    <a href="./graph.php?T=<?php echo $tema ?>" class="btn btn-default">Actualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-card-default p-2">
                <hr>
                <div class="row">
                    <?php $i = 1;
                    foreach ($datos as $index => $pregunta) { ?>
                        <div class="col-md-6">
                            <h6>Pregunta: <?php echo $pregunta['pregunta']; ?></h6>
                            <canvas id="grafica_<?php echo $i; ?>"></canvas>
                        </div>
                        <?php $i++; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "view/estructura/footer.php";
    ?>
    <script>
        <?php
        $i = 1;
        foreach ($datos as $index => $pregunta) { ?>
            const canvasId<?php echo $i; ?> = "grafica_<?php echo $i; ?>";
            const canvas<?php echo $i; ?> = document.getElementById(canvasId<?php echo $i; ?>);
            const ctx<?php echo $i; ?> = canvas<?php echo $i; ?>.getContext('2d');

            const etiquetas<?php echo $i; ?> = <?php echo json_encode($pregunta['op_1']); ?>;
            const datos<?php echo $i; ?> = <?php echo json_encode($pregunta['total_r']); ?>;

            // Creamos un conjunto de datos para esta pregunta
            const dataset<?php echo $i; ?> = {
                label: '<?php echo json_encode($pregunta['pregunta']); ?>',
                data: datos<?php echo $i; ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            };

            // Creamos una nueva instancia de Chart.js para esta pregunta
            new Chart(ctx<?php echo $i; ?>, {
                type: 'bar',
                data: {
                    labels: etiquetas<?php echo $i; ?>,
                    datasets: [dataset<?php echo $i; ?>]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        <?php $i++;
        } ?>
    </script>
</body>

</html>