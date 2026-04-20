<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div

    class="tab-pane fade show active"

    id="content-home"

    role="tabpanel"

    aria-labelledby="tab-home">

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="card-title">Fecha de inicio</h5>

            <p class="card-text fs-4"><?= $modulos->fecha_inicio_texto ?></p>

        </div>

    </div>

    <!-- <form class="box_filters">

        <div class="input-group">

            <span class="input-group-text" id="basic-addon1"><i class="ri-search-line"></i></span>

            <input

                type="text"

                class="form-control "

                placeholder="Buscar por nombre"

                aria-label="Username"

                aria-describedby="basic-addon1" />

        </div>

        <select

            class="form-select"

            aria-label="Selecciona nivel de curso"

            name="type_nivel">

            <option selected>Nivel de cursos</option>

            <option value="1">Básico</option>

            <option value="2">Intermedio</option>

            <option value="3">Avanzado</option>

        </select>

        <button type="button" class="btn btn-primary btn_search">

            <i class="ri-search-line"></i> <span>Buscar curso</span>

        </button>

    </form> -->

    <?php if ($modulos->activar): ?>

        <div class="box_items_cursos mt-5">
            <?php

            $busqueda = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";

            $videos = $V->getVideosByRangoDay($numero, $busqueda, "ondemand");

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
                    <a href="?seccion=ondemand&accion=recording&modulo=<?= $numero ?>&id=<?php echo $video->id; ?>">
                        <?php
                        if ($numero == 1) {
                            $mod = "Módulo 1_1.png";
                        } else if ($numero == 2) {
                            $mod = "Módulo 2_1.jpg";
                        } else if ($numero == 3) {
                            $mod = "Módulo 3_1.jpg";
                        } else if ($numero == 4) {
                            $mod = "Módulo 4_1.jpg";
                        }
                        $urlImag = "https://curso-ameh.com/imgs/2026/" . $mod;
                        ?>
                        <img

                            class="picture_curso thumb_<?php echo $video->id; ?>"

                            src="<?php echo $urlImag; ?>"

                            alt="" />
                    </a>

                    <div class="info_curso">

                        <?php if (!$visualizacion_completa) { ?>

                            <!-- <span class="tag_nivel_w basic"><?php echo $progreso; ?> % </span> -->
                            <div class="progress" role="progressbar" aria-label="Progreso de visualización" aria-valuenow="<?php echo $progreso; ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-warning" style="width: <?php echo $progreso; ?>%"><?php echo $progreso; ?>%</div>
                            </div>

                        <?php } else { ?>

                            <span class="tag_nivel basic">Completo</span>


                        <?php } ?>

                        <h5 class="mt-1"><?php echo $video->tema; ?></h5>

                        <!-- <p class="fw-light">Lorem  </p> -->

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
</section>

<?php
    $scripts_js = [
        "js" => [
            "js/alumno/detallesCurso.js"
        ]
    ];
?>