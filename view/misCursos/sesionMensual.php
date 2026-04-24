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
                    <div style="padding:56.25% 0 0 0;position:relative;">
                        <iframe src="https://player.vimeo.com/video/1142278785?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>
                <?php } else if($f_actual > $f_fin){
                    ?>
                    <div class="c_primary text-center mb-4">
                        <h4 class="text-danger">La sesión ya ha finalizado</h4>
                    </div>
                    <div style="padding:56.25% 0 0 0;position:relative;">
                        <iframe src="https://player.vimeo.com/video/1142278785?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>

                <?php } else { ?>
                    <div class="c_primary text-center mb-4">
                        <h4>Sesión Mensual: <?php echo $sesiones->conferencia; ?> | <?php echo $sesiones->temario; ?></h4>
                    </div>
                    <div style="padding:56.25% 0 0 0;position:relative;">
                        <iframe src="https://player.vimeo.com/video/<?php echo $sesiones->canal1; ?>?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>
                <?php }
                /*var_dump($sesiones);
                exit;*/
            } else { ?>
                <div class="c_primary"><small>No tienes registro a una sesión mensual próxima</small></div>
                <div style="padding:56.25% 0 0 0;position:relative;">
                    <iframe src="https://player.vimeo.com/video/1142278785?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479%2Fembed" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                </div>
            <?php } ?>
                        
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
