<?php
    $cursos = $A->GetCursosPagados($_SESSION[AMBIENTE]['usuario']['id']);
?>

<nav class="nav_menu">
    <ul>
        <li>
            <a href="<?= BASE_URL ?>elearningComexane/" class="btn"><i class="ri-dashboard-line"></i><span>Inicio</span></a>
        </li>
        <li>
            <button
                class="btn d-flex justify-content-between"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseExample"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="ri-video-on-line"></i>
                <span class="w-100">Mis cursos</span>
                <i class="ri-arrow-down-s-line ri-xl"></i>
            </button>
            <?php 
                //var_dump($cursos);
                if(empty($cursos)){ ?>
                    <div class="collapse box_collapse" id="collapseExample">
                        <ul>
                            <li><a>NO HAY CURSOS DISPONIBLES</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <div class="collapse box_collapse" id="collapseExample">
                        <ul>
                            <?php foreach($cursos as $curso){ ?>
                                <li><a href="?seccion=cursos&accion=detalle&curso=<?= $curso->id_curso ?>"><?= $curso->titulo ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php }
            ?>
           
        </li>
        <li>
            <a href="?seccion=live" class="btn"><i class="ri-play-circle-line"></i><span>Sala en vivo</span></a>
        </li>
        <li>
            <a href="?seccion=sesionMensual" class="btn"><i class="ri-calendar-line"></i><span>Sesiones mensuales</span></a>
        </li>
        <!-- <li>
            <a href="<?= BASE_URL ?>elearnigdev/redireccionPDF.php?recurso=programa" target="_blank" class="btn"><i class="ri-file-ai-line"></i><span>Programa en PDF</span></a>
        </li> -->
        
        <!-- <li>
            <a href="?seccion=constancias" class="btn"><i class="ri-award-line"></i><span>Constancias</span></a>
        </li> -->
        <li>
            <a href="https://comexane.com/socios/" target="_blank" class="btn"><i class="ri-apps-line"></i><span>Sistema socios</span></a>
        </li> 
    </ul>
</nav>