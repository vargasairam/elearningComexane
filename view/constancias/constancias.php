<section class="content_global">

    <?php include_once "view/estructura/header.php"; ?>

    <div class="content_constancias">

        <h4 class="fw-semibold">
            Plataforma Virtual COMEXANE A.C. <?= date("Y") ?>
        </h4>

        <div class="alert alert-success p-3" role="alert">
            Las constancias estarán disponibles una vez que haya completado al menos el 80 % de visualización de cada curso,
            considerando todo el material disponible.
        </div>

        <div class="cards">
            <div class="table-responsive">
                <table class="table table-hover box_table">
                    <thead>
                        <tr>
                            <th class="fw-semibold" scope="col">Curso</th>
                            <th class="fw-semibold" scope="col">Tema</th>
                            <th class="fw-semibold" scope="col">Módulos</th>
                            <th class="fw-semibold" scope="col">Porcentaje visualizado %</th>
                            <th class="fw-semibold" scope="col">Constancia</th>
                        </tr>
                    </thead>

                    <!-- <tbody>

                        <?php

                        $modulo = 0;

                        $progresoTotal_general = 0;

                        foreach ($dias as $dia) {

                            $modulo++;

                            //  calculos ondeman

                            $resultado = $V->calcularProgresoVideos($modulo, $user, "ondemand");

                            $minutosOnDemand = round($resultado['minutos_visualizados'], 2);

                            $porcentajeOnDemand = round($resultado['porcentaje_visualizado'], 2);

                            $total_minutos_modulo_ondemand = $resultado['total_minutos_modulo'];

                            // calculos live grabados

                            $resultado = $V->calcularProgresoVideos($modulo, $user, "live");

                            $minutosOnLive = round($resultado['minutos_visualizados'], 2);

                            $porcentajeOnLive = round($resultado['porcentaje_visualizado'], 2);

                            $total_minutos_modulo_live = $resultado['total_minutos_modulo'];



                            // calculos evento en vivo



                            $evento = $V->getEventoEnVivo($modulo);

                            $resultado_en_vivo = $V->getProgresoEnVivo($modulo, $user->id, $evento->fecha_hora_inicio, $evento->fecha_hora_fin, $evento->duracion);



                            $sumatoria_en_vivo = ($porcentajeOnLive + round($resultado_en_vivo['porcentaje'], 2));
                            if ($sumatoria_en_vivo >= 100) {
                                $sumatoria_en_vivo = 100;
                            }
                            $promedioGeneral = round(($porcentajeOnDemand + $sumatoria_en_vivo) / 2, 2);
                            if ($promedioGeneral >= 100) {
                                $promedioGeneral = 100;
                            }
                            $progresoTotal_general = $progresoTotal_general + $promedioGeneral;
                            if ($promedioGeneral >= 80) {
                                $bg = "bg-success";
                            } else {
                                $bg = "bg-warning";
                            }
                        ?>
                            <tr>
                                <th>
                                    <img src="../imgs/2026/Módulo 1.jpg" alt="" />
                                </th>
                                <td><?= $evento->nombreModulo; ?></td>
                                <td>Módulo <?= $modulo; ?></td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Warning example"
                                        aria-valuenow="<?= $promedioGeneral ?>" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar <?= $bg ?>" style="width: <?= $promedioGeneral ?>%;">
                                            <?= $promedioGeneral ?>%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- <button type="button" class="btn btn-primary disabled">
                                        <small>Descargar constancia<i class="ri-download-line"></i></small>
                                    </button> -->
                                    <?php
                                    if ($promedioGeneral >= 80) {
                                    ?>
                                        <a href="view/generarConstancia.php?ttr=<?php echo base64_encode($modulo) ?> " target="_blank" class="btn btn-primary">Descargar</a>
                                    <?php

                                    } else {

                                    ?>

                                        <a href="?seccion=ondemand&accion=modulo<?= $modulo; ?>" class="btn btn-primary ">Visualice los videos restantes para poder descargar su constancia</a>

                                    <?php

                                    }

                                    ?>

                                </td>

                            <?php } ?>

                            </tr>

                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
</section>