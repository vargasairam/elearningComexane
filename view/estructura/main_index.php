<section class="content_global" style="margin-bottom: 250px !important;">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="content_dashboard">
        <?php include_once "view/estructura/welcome.php"; ?>
        <div class="mt-5 drawer_items_dashboard gap-3">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="box_items_dashboard">
                    <div class="d-flex flex-column flex-lg-row flex-xl-row justify-content-center justify-content-md-between align-items-start gap-3 mb-5">
                        <div class="cards align-self-start flex-fill">
                            <h3>Mis cursos</h3>
                            <div class="d-flex justify-content-end">
                                <a href="?seccion=misCursos" class="btn btn-link btn-sm">Ver más <i class="ri-arrow-right-line"></i></a>
                            </div>

                            <i class="icon ri-play-circle-line text-white"></i>
                        </div>

                        <div class="cards align-self-start flex-fill bg-constancias">
                            <div class="d-flex justify-content-end">
                                <a href="?seccion=constancias" class="btn btn-link btn-sm text-white">Ver más <i class="ri-arrow-right-line"></i></a>
                            </div>
                        </div>

                        <div class="cards align-self-start flex-fill bg-sesion">
                            <!-- <h3>Sesión Mensual</h3> -->
                            <div class="d-flex justify-content-end">
                                <a href="?seccion=sesionMensual" class="btn btn-link btn-sm text-white">Ver más <i class="ri-arrow-right-line"></i></a>
                            </div>

                            <!-- <i class="icon ri-award-line text-white"></i> -->
                        </div>

                        <!-- <div class="cards align-self-start flex-fill">
                            <h4>Programa Académico 2026</h4>
                            <div class="d-flex justify-content-end">
                                <a href="" target="_blank" class="btn btn-link btn-sm">
                                    Descargar el programa
                                    <i class="ri-arrow-down-line"></i>
                                </a>
                            </div>

                            <i class="icon ri-book-line text-white"></i>
                        </div> -->
                    </div>

                    <div>
                        <h4 class="mb-3">Cátalogo de cursos </h4>
                        <div class="grid">
                            <div class="grid-sizer"></div>
                            <!-- <div class="grid-item">
                                <a href="?seccion=ondemand&amp;accion=recording&amp;modulo=1&amp;id=1">
                                    <img class="picture_curso thumb_1" src="https://curso-ameh.com/imgs/2026/Módulo 1_1.png" alt="">
                                </a>

                                <div class="info_curso">
                                    <div class="progress" role="progressbar" aria-label="Progreso de visualización" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-warning" style="width: 44%">44%</div>
                                    </div>
                                    
                                    <h5 class="mt-1">Anemias carenciales adultos</h5>

                                    <div class="text-muted d-flex justify-content-between w-100 gap-1">
                                        <small>                
                                            <i class="ri-user-fill"></i> Dr. José L. Alvarez Vera
                                        </small>
                                
                                        <small> <i class="ri-time-fill"></i>
                                            0:32
                                        </small>
                                    </div>

                                    <div class="text-muted d-flex justify-content-between w-100 gap-1">
                                        <small>06 de febrero</small>
                                    </div>

                                    <hr>
                                    <a class="c_primary d-block w-100 text-center btn btn-primary" href="?seccion=ondemand&amp;accion=recording&amp;modulo=1&amp;id=1">Ver video</a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            

           <!--  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4 col-xxl-4">
                <div class="box_aside_dashboard">
                    <h4 class="mb-3">Mi cuenta</h4>
                    <div class="item_user_info cards">
                        <h5 class="fw-semibold mb-1"><?= $user->prefijo . " " . $user->n_constancia ?></h5>
                        <h6 class="mb-0">Médico Cirujano</h6>
                        <p class="fw-light"><?= $user->email ?></p>
                        <div class="mt-3">
                            <p class="mb-1">
                            <i class="ri-hospital-line"></i> Centro Médico CDMX
                        </p>
                            <p class="mb-0"><i class="ri-phone-line"></i><?= $user->telefono ?></p>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="?seccion=perfil" class="btn btn-light btn-sm">Ver más <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<?php
    $scripts_js = [
        "js" => [
            "https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js",
            "https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js",
            "js/main_grid.js"
        ]
    ];
?>