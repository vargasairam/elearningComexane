<?php 
    $modulos = $CC->GetModuloEnvivo($numero);
?>

<div
    class="tab-pane fade"
    id="content-profile"
    role="tabpanel"
    aria-labelledby="tab-profile">

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Fecha de inicio</h5>
            <p class="card-text fs-4"><?= $modulos->fecha_texto ?></p>
        </div>
    </div>
    <?php if($modulos->activar): ?>
    <div class="box_items_cursos mt-5">
        <?php
        $busqueda = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
        $videos = $V->getVideosByRangoDay($numero, $busqueda, "live");
        foreach ($videos as $video) {
            $visualizacion_completa = true;
            $resultado = $V->getProgresoVideo($video->id, $user->id, $video->duracion);
            $progreso_video = $resultado->progreso;
            $progreso = $progreso_video;
            if ($progreso > 100) {
                $progreso = 100;
            }
            if ($progreso < 95) {
                $visualizacion_completa = false;
            }
        ?>
            <div class="item_curso">
                <img
                    class="picture_curso"
                    src="<?= BASE_URL ?>redireccionPDF.php?recurso=poster"
                    alt="" />
                <div class="info_curso">
                    <?php if (!$visualizacion_completa) { ?>
                        <span class="tag_nivel_w basic"><?php echo $progreso; ?> % </span>
                    <?php } else { ?>
                        <span class="tag_nivel basic">Completo</span>
                    <?php } ?>
                    <h5 class="mt-1"><?php echo $video->tema; ?></h5>
                    <!-- <p class="fw-light">Lorem</p> -->
                    <div
                        class="text-muted d-flex justify-content-between w-100 gap-1">
                        <small>
                            <?php if ($video->ponentes != "") { ?>
                                <i class="ri-user-fill"></i> <?php echo $video->ponentes; ?></small>
                    <?php } ?>
                    <small> <i class="ri-time-fill"></i>
                        <?php
                        echo floor(($video->duracion / 60)) . ":" . ($video->duracion % 60);
                        ?>
                    </small>
                    </div>
                    <div
                        class="text-muted d-flex justify-content-between w-100 gap-1">
                        <small><?php echo $video->fecha_texto; ?></small>
                    </div>
                    <hr />
                    <a
                        class="c_primary d-block w-100 text-center btn btn-primary"
                        href="?seccion=ondemand&accion=recording&modulo=<?= $numero ?>&id=<?php echo $video->id; ?>">Ver video</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php endif; ?>
</div>