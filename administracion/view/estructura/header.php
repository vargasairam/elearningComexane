<header class="wrapper_header">
    <div class="drawer_ttl_header">
        <div class="box_mobile">
            <button class="btn_menu"><i class="ri-menu-line"></i></button>
            <a href="<?= BASE_URL ?>administracion/">
                <img src="<?= $configuracion->logo ?>" alt="Logo <?= $configuracion->prefijo ?>" class="brand_logo" />
            </a>
        </div>

        <h2 class="fw-semibold m-0"><?= $tittle ?></h2>
    </div>

    <div class="drawer_options_header">
        <?php include "view/estructura/drop_admin.php"; ?>
    </div>
</header>