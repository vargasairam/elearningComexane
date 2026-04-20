<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set("America/Mexico_City");



include 'config/config.php';
require 'core/conexion.php';
require 'model/helper.php';
require 'model/alumno.php';
require 'model/videos.php';
require 'model/congreso.php';


$H = new Helper();
$A = new Alumno();
$V = new Videos();
$C = new Congreso();
$dias = $C->getAllDias(2025);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">

    <!-- Buttons extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">

</head>

<body>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Registros</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <!-- <a class="btn btn-success" href="excel2024.php">Excel</a> -->
                    <a class="btn btn-success" href="liberarAcceso_2024.php?password=ameh">Actualizar</a>
                    <a class="btn btn-info" href="becas2.php?password=ameh">Becas</a>
                </div>
                <div class="col-12 mt-2">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="data-ble">
                            <thead>
                                <tr>
                                    <!-- <th colspan="4"></th> -->
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                    <?php
                                    $modulo = 0;
                                    foreach ($dias as $dia) {
                                        $modulo++;
                                    ?>
                                        <th>
                                            Módulo <?= $modulo ?>
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                    <?php } ?>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <!-- <th></th> -->
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>#</td>
                                    <td>ID_usuario</td>
                                    <td>Nombre</td>
                                    <td>Correo</td>

                                    <?php foreach ($dias as $dia) { ?>
                                        <td>Minutos Ondeman</td>
                                        <td>% Ondeman</td>
                                        <td>Minutos live (Grabación)</td>
                                        <td>% live (Grabación)</td>
                                        <td>Minutos en vivo</td>
                                        <td>% en vivo</td>
                                        <td>Promedio General</td>
                                    <?php } ?>

                                    <td>Progreso Total General</td>
                                    <td>Categoria</td>
                                    <td>Pais</td>
                                    <td>Estado</td>
                                    <td>Telefono</td>
                                    <td>Estatus</td>
                                    <td>Observaciones</td>
                                    <td>Modulos</td>
                                    <td>Monto</td>
                                    <td>Fecha de Registro</td>
                                    <td>Fecha de pago</td>
                                    <!-- <td>Datos Fiscales</td>  -->
                                </tr>
                                <?php $alumnos = $A->getAlumnos_2024();
                                ?>

                                <?php $a = 1;
                                $i = 0; ?>
                                <?php foreach ($alumnos as $al) {
                                    $progresoTotal_general = 0;
                                ?>
                                    <?php
                                    if ($al->estatus == "PAGADO" || $al->estatus == "BECADO") {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $al->id ?></td>
                                            <td><?= $al->nombre . " " . $al->apellidos ?></td>
                                            <td><?= $al->email ?></td>

                                            <?php
                                            $modulo = 0;
                                            foreach ($dias as $dia) {
                                                $modulo++;

                                                //  calculos ondeman
                                                $resultado = calcularProgresoVideos($modulo, $al, "ondemand");
                                                $minutosOnDemand = round($resultado['minutos_visualizados'], 2);
                                                $porcentajeOnDemand = round($resultado['porcentaje_visualizado'], 2);
                                                $total_minutos_modulo_ondemand = $resultado['total_minutos_modulo'];
                                                // calculos live grabados
                                                $resultado = calcularProgresoVideos($modulo, $al, "live");
                                                $minutosOnLive = round($resultado['minutos_visualizados'], 2);
                                                $porcentajeOnLive = round($resultado['porcentaje_visualizado'], 2);
                                                $total_minutos_modulo_live = $resultado['total_minutos_modulo'];

                                                // calculos evento en vivo
                                                $evento = $V->getEventoEnVivo($modulo);
                                                $resultado_en_vivo = $V->getProgresoEnVivo($modulo, $al->id, $evento->fecha_hora_inicio, $evento->fecha_hora_fin, $evento->duracion);

                                                $sumatoria_en_vivo = ($porcentajeOnLive + round($resultado_en_vivo['porcentaje'], 2));
                                                if ($sumatoria_en_vivo >= 100) {
                                                    $sumatoria_en_vivo = 100;
                                                }

                                                $promedioGeneral = round(($porcentajeOnDemand + $sumatoria_en_vivo) / 2, 2);
                                                if ($promedioGeneral >= 100) {
                                                    $promedioGeneral = 100;
                                                }
                                                $progresoTotal_general = $progresoTotal_general + $promedioGeneral;

                                            ?>

                                                <td><?= $minutosOnDemand ?> / <?php echo $total_minutos_modulo_ondemand;  ?></td>
                                                <td><?= $porcentajeOnDemand ?>%</td>
                                                <td><?= $minutosOnLive ?> / <?php echo $total_minutos_modulo_live;  ?></td>
                                                <td><?= $porcentajeOnLive ?>%</td>
                                                <td><?= $resultado_en_vivo['minutos_visto'] ?>/<?php echo $evento->duracion; ?></td>
                                                <td><?= round($resultado_en_vivo['porcentaje'], 2) ?>%</td>
                                                <td><b><?= $promedioGeneral ?>%</b></td>
                                            <?php } ?>
                                            <td>
                                                <?php
                                                echo round(($progresoTotal_general) / 4, 2);
                                                ?>
                                            </td>
                                            <td>
                                                <?= $al->categoria ?>
                                            </td>
                                            <td><?= $al->pais ?></td>
                                            <td><?= $al->estado ?></td>
                                            <td><?= $al->telefono ?></td>

                                            <td>
                                                <?php
                                                if ($al->estatus == "PAGADO" || $al->estatus == "BECADO") {
                                                    echo $al->estatus;
                                                } else {
                                                    echo "Pendiente";
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?= $al->observaciones ?>
                                            </td>
                                            <td>
                                                <?php
                                                $modulos = $A->getModulosPagados($al->id);
                                                $total = 0;
                                                $text_modulos = "";
                                                $separador = "";
                                                foreach ($modulos as $modulo) {
                                                    $total = $total + $al->monto;
                                                    $text_modulos .= $separador . $modulo->modulo;
                                                    $separador = ", ";
                                                }
                                                echo $text_modulos;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($total > 0) {
                                                    echo $total;
                                                } else {
                                                    echo $al->monto;
                                                }
                                                ?>
                                            </td>

                                            <td><?= $al->fecha_registro ?></td>
                                            <td>
                                                <?= $al->fecha_pago ?>
                                            </td>

                                            <!-- <td>
                                                <?php if ($al->rfc) { ?>
                                                    <?= "RFC: " . $al->rfc . ", Razon social: " . $al->razon_social . ", CP: " . $al->codigo_postal . ", Estado: " . $al->estadof . ", Uso de CFDI: " . $al->uso_de_cfdi ?>
                                                <?php } ?>
                                            </td> -->

                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script> -->

    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <!-- Buttons + dependencias para Excel -->
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script>
         $('#data-ble').DataTable({
    dom: 'Bfrtip',
    scrollX: true,          // importante porque tienes muchas columnas
    pageLength: 25,

    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Exportar a Excel',

            exportOptions: {
                // 👇 SOLO las columnas que quieres exportar
                columns: [
                    0, // #
                    2, // Nombre
                    3, // Correo

                    // columnas de módulos (ajusta si cambian)
                    // ejemplo: primeros 2 módulos completos
                    4,5,6,7,8,9,10, // modulo 1
                    11,12,13,14,15,16,17, // modulo 2
                    18,19,20,21,22,23,24, // modulo 3
                    25,26,27,28,29,30,31, // modulo 4

                    // progreso total
                    // 18,

                    // datos finales importantes
                    32, // Categoria
                    33, // Pais
                    34, // Estado
                    35, // Telefono
                    36, // Estatus
                    37, // Observaciones
                    39,  // Monto
                    40, // Fecha registro
                    41, // Fecha pago
                    42 // Fecha pago
                ]
            }
        }
    ]
});
    </script>
</body>

</html>
<?php
function calcularProgresoVideos($modulo, $al, $tipoVideo = 'ondemand')
{
    global $V; // Asegúrate de que $V es accesible en el contexto de la función

    $videos = $V->getVideosByModulo($modulo, $tipoVideo);
    $total_minutos = 0;

    $total_progreso = 0;
    $total_videos = count($videos);
    $total_minutos_modulo = 0;
    $progreso = 0;
    foreach ($videos as $video) {

        $resultado = $V->getProgresoVideo($video->id, $al->id, $video->duracion);
        $total_minutos_modulo += $video->duracion;
        if ($resultado->progreso >= 100) {
            $total_minutos += $video->duracion;
            $progreso = 100;
            $total_progreso += 100;
        } else {
            if ($resultado->minutos >= $video->duracion) {
                $total_minutos += $video->duracion;
                $progreso = 100;
                $total_progreso += 100;
            } else {
                $total_minutos += $resultado->minutos;
                $progreso = $resultado->progreso;
                $total_progreso += $resultado->progreso;
            }
        }
    }
    if ($total_progreso > 0) {
        $porcentaje_on_demand = $total_progreso / $total_videos;
    } else {
        $porcentaje_on_demand = 0;
    }

    return [
        'total_minutos_modulo' => $total_minutos_modulo,
        'porcentaje_visualizado' => $porcentaje_on_demand,
        'minutos_visualizados' => $total_minutos,
    ];
}

?>