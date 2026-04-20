<?php if ($seccions == 'pagos') {

    $seccions = 'Inscripciones';
} ?>



<header class="wrapper_header">

    <div class="drawer_ttl_header">

        <div class="box_mobile">

            <button class="btn_menu"><i class="ri-menu-line"></i></button>

            <a href="<?= BASE_URL ?>">

                <img

                    src="<?= $configuracion->logo ?>"

                    alt="Logo <?= $configuracion->prefijo ?>"

                    class="brand_logo" />

            </a>

        </div>

        <h2 class="fw-semibold m-0"><?= $tittle ?></h2>
        <!-- <h4>
            Si no esta en vivo, 
        </h4> -->

        <!-- <?php if (isset($_GET['seccion']) && $_GET['seccion'] == 'ondemand') { ?>

            <a

                href="?seccion=pagar"

                class="btn btn-danger btn_live btn-sm btn_notify">

                <i class="ri-record-circle-fill"></i> <span>Pagar</span>

                <i class="ri-arrow-right-line"></i>

            </a>

        <?php } ?> -->

    </div>

    <div class="drawer_options_header">

        

        <!-- <a href="#" type="button" class="btn btn-light btn-sm btn_info">

            <i class="ri-error-warning-line ri-lg"></i>

        </a> -->

        <?php 
            if($_SESSION[AMBIENTE]['usuario']['rol'] == "admin"){ 
                include "view/administracion/estructura/drop_admin.php";
            } else {
                include "view/estructura/drop.php";
            }
        
        ?>

    </div>

</header>