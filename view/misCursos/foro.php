<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>

    <div class="content_ondemand flex-column" id="content-home" role="tabpanel" aria-labelledby="tab-home">
        <div class="w-100">
            <?php if(!empty($sesionesForo)){ ?>
                <div class="box_items_cursos mt-5">
                    <?php 
                        /*$busqueda = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";

                        $videos = $V->getVideosByRangoDay($numero, $busqueda, "ondemand");*/

                        foreach ($sesionesForo as $video) { 
                            $fecha = new DateTime($video->fecha_hora_inicio);

                            $formato = new IntlDateFormatter(
                                'es_MX',
                                IntlDateFormatter::LONG,
                                IntlDateFormatter::NONE
                            );

                            $fecha_texto = $formato->format($fecha); ?>
                            <div class="item_curso">
                                <a href="?seccion=foro&accion=recording&id=<?php echo $video->id; ?>">
                                    <img class="picture_curso thumb_<?php echo $video->id; ?>" src="<?php BASE_URL ?>imgs/foro_portadas/portadas_videos/<?php echo $video->portada_video; ?>"

                                        alt="" />
                                </a>

                                <div class="info_curso">
                                    <!-- <?php if (!$visualizacion_completa) { ?>
                                        <div class="progress" role="progressbar" aria-label="Progreso de visualización" aria-valuenow="<?php echo $progreso; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-warning" style="width: <?php echo $progreso; ?>%"><?php echo $progreso; ?>%</div>
                                        </div>
                                    <?php } else { ?>
                                        <span class="tag_nivel basic">Completo</span>
                                    <?php } ?> -->

                                    <h5 class="mt-1"><?php echo $video->titulo; ?></h5>

                                    <div class="text-muted d-flex justify-content-between w-100 gap-1">
                                        <small>
                                            <?php if ($video->ponentes_ids != "") { ?>
                                                <i class="ri-user-fill"></i> <?php echo $video->ponentes_ids; ?>
                                        </small>
                                        <?php } ?>

                                        <small> <i class="ri-time-fill"></i> 
                                            <?php echo floor(($video->duracion / 60)) . ":" . ($video->duracion % 60); ?>
                                        </small>
                                    </div>

                                    <div class="text-muted d-flex justify-content-between w-100 gap-1 mt-2">
                                        <strong><small><i class="ri-calendar-fill"></i> <?php echo $fecha_texto; ?></small></strong>
                                    </div>

                                    <hr />

                                    <a class="c_primary d-block w-100 text-center btn btn-primary"
                                        href="?seccion=foroResidentes&accion=recording&id=<?php echo $video->id; ?>">Ver video
                                    </a>
                                </div>
                            </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="c_primary text-center mb-4 mt-4">
                    <h4 class="text-danger">No hay videos disponibles</h4>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
