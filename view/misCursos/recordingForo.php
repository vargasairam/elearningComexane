<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <a href="?seccion=foroResidentes" class="btn btn-secondary btn_back mt-3 btn-sm"><i class="ri-arrow-left-line ri-lg"></i></a>
    <div class="content_ondemand">
        <div class="drawer_video_live">
            <div class="box_info_video_live mt-2 mb-4">
                
                <h3 class="fw-semibold mb-1"><?php echo $video->temario; ?></h3>
                <div>
                    <span>
                        <?php if ($video->ponentes_ids != "") { ?>
                            <i class="ri-user-fill"></i> <?php echo $video->ponentes_ids; ?></small>
                        <?php } ?>
                    </span>
                    -
                    <span> <i class="ri-time-fill"></i>
                        <?php
                        echo floor(($video->duracion / 60)) . ":" . ($video->duracion % 60);
                        ?>
                    </span>
                </div>
            </div>
            <div class="embed-video">
                <?php
                /*$resultado = $V->getProgresoVideo($video->id, $_SESSION[AMBIENTE]['usuario']['id'], $video->duracion);
                $progreso = $resultado->progreso;*/
                $video_link = $video->canal1;
                if (isset($_GET['traduccion'])) {
                    $video_link = $video->canal2;
                }
                ?>
                <iframe
                    src="https://player.vimeo.com/video/<?php echo $video_link ?>"
                    frameborder="0"
                    id="video-v"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    var videoId = <?= $video->id ?>;
    var user = <?= $_SESSION[AMBIENTE]['usuario']['id'] ?>;
</script>