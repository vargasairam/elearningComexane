<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="content_live">
        <div class="drawer_video_live">
            <?php 
            
            if(!empty($sesiones)){
                //var_dump($sesiones);
                $f_actual = date("Y-m-d H:i:s");
                $f_actual = strtotime($f_actual);
                $f_inicio = strtotime($sesiones->fecha_hora_inicio);
                $f_fin = strtotime($sesiones->fecha_hora_fin);
                if($f_actual < $f_inicio){ ?>
                    <div class="c_primary text-center mb-4">
                        <h4 class="text-danger">La sesión <?php echo $sesiones->conferencia; ?> aún no ha comenzado </h4>
                    </div>
                    <div class="embed-video">
                        <iframe src="https://player.vimeo.com/video/1142278785?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>
                <?php } else if($f_actual > $f_fin){ ?>
                    <div class="c_primary text-center mb-4">
                        <h4 class="text-danger">La sesión ya ha finalizado</h4>
                    </div>
                    <div class="embed-video">
                        <iframe src="https://player.vimeo.com/video/1142278785?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>
                <?php } else { ?>
                    <div class="c_primary text-center mb-4">
                        <h4>Sesión Mensual: <?php echo $sesiones->conferencia; ?> | <?php echo $sesiones->temario; ?></h4>
                    </div>
                    <div class="embed-video">
                        <iframe src="https://player.vimeo.com/video/<?php echo $sesiones->canal1; ?>?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                        <!-- <iframe
                            id="videoFrame"
                            src="https://vimeo.com/event/<?= $sesiones->canal1 ?>/embed/interaction"
                            frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen>
                        </iframe> -->
                    </div>
                <?php }
                /*var_dump($sesiones);
                exit;*/
            } else { ?>
                <div class="c_primary"><small>No tienes registro a una sesión mensual próxima</small></div>
                <div sclass="embed-video">
                    <iframe src="https://player.vimeo.com/video/1142278785?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                </div>
            <?php } ?>                        
        </div>

        <?php if($f_actual < $f_inicio){ ?>
            <!-- <div class="drawer_opcion_questions cards">
                <div class="c_primary text-center mb-4">
                    <h4 class="text-danger">La sesión aún no ha comenzado</h4>
                </div>
            </div> -->           
        <?php } else if($f_actual > $f_fin){ ?>
            <!-- <div class="drawer_opcion_questions cards">
                <div class="c_primary text-center mb-4">
                    <h4 class="text-danger">La sesión ya ha finalizado</h4>
                </div>
            </div> -->
        <?php } else { ?>
            <div class="drawer_opcion_questions cards mt-5">
                <ul class="nav nav-pills nav-fill" id="tabsExample" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="tab-home"
                            data-bs-toggle="pill"
                            data-bs-target="#content-home"
                            type="button"
                            role="tab"
                            aria-controls="content-home"
                            aria-selected="true">
                            Preguntas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="tab-profile"
                            data-bs-toggle="pill"
                            data-bs-target="#content-profile"
                            type="button"
                            role="tab"
                            aria-controls="content-profile"
                            aria-selected="false">
                            Canales
                        </button>
                    </li>
                </ul>
                <div class="tab-content mt-4" id="tabsExampleContent">
                    <div
                        class="tab-pane fade show active"
                        id="content-home"
                        role="tabpanel"
                        aria-labelledby="tab-home">
                        <h6 class="mb-4">
                            Escribe aquí tu pregunta y será leido por el coordinador al
                            final de la presentación.
                        </h6>
                        <div>
                            <form id="questionForm" method="post">
                                <textarea
                                    class="form-control mb-3"
                                    id="question"
                                    rows="3"
                                    name="question"
                                    placeholder="Tu pregunta aquí"></textarea>
                                    <?php if ($sesiones) { ?>
                                    <input type="hidden" name="modulo" id="modulo" value="<?= $sesiones->id ?>">
                                    <button id="btn_submit" type="submit" class="btn btn-primary">
                                        Enviar comentario <i class="ri-arrow-right-line"></i>
                                    </button>
                                <?php } ?>
                            </form>
                            <input type="hidden" id="respuesta">
                        </div>
                    </div>
                </div>

                <div
                    class="tab-pane fade"
                    id="content-profile"
                    role="tabpanel"
                    aria-labelledby="tab-profile">
                    <h5>Canales en vivo</h5>
                    <hr>
                    <div>
                        <a href="?seccion=live&accion=live" class="btn btn-light text-start w-100 mb-2"><i class="ri-play-fill"></i> Español</a>
                        <a href="?seccion=live&accion=live&canalTraducion" class="btn btn-light text-start w-100 "><i class="ri-play-fill"></i> Ingles</a>
                    </div>
                </div>
            </div>
        <?php } ?>        
    </div>
</section>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<?php
    $scripts_js = [
        "js" => [
            "js/alumno/sesionMensual.js"
        ]
    ];
    /* action="controller/transmision.php?accion=saveQuestion" */ 
?>


