<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="content_dashboard">
        <div class="mt-5 drawer_items_dashboard gap-3">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-8 col-xxl-8">
                <div class="box_items_dashboard">
                    <div>
                        <h4 class="mb-3">Mis cursos</h4>
                        <div class="grid">
                            <div class="grid-sizer"></div>
                        </div>
                        <div id="mensaje_no_cursos" class="text-center"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4 col-xxl-4">
                <div class="box_aside_dashboard">
                    <h4 class="mb-3">Mi cuenta</h4>                    
                    <div class="item_user_info cards">
                        <h5 class="fw-semibold mb-1"><?= $user->prefijotxt . " " . $user->nombreconstancia ?></h5>
                        <h6 class="mb-0">Médico Cirujano</h6>
                        <p class="fw-light"><?= $user->email ?></p>
                        <div class="mt-3">
                            <!-- <p class="mb-1">
                            <i class="ri-hospital-line"></i> Centro Médico CDMX
                        </p> -->
                            <p class="mb-0"><i class="ri-phone-line"></i><?= $user->celular ?></p>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="?seccion=perfil" class="btn btn-light btn-sm">Ver más <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    $scripts_js = [
        "js" => [
            "https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js",
            "https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js",
            "js/alumno/misCursos.js"
        ]
    ];
?>