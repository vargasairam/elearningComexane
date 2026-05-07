<aside class="aside_nav trans" style="background: linear-gradient( 135deg, #C81F3D 0%, #9f2340 30%, #6b2a43 60%, #302D45 100% );">
    <button type="button" class="btn-close" aria-label="Close"></button>
    <div class="box_brand text-center">
        <a href="<?= BASE_URL ?>elearnigdev/administracion/">
            <img src="<?= $configuracion->logo ?>" alt="Logo <?= $configuracion->prefijo ?>" class="brand_logo" />
        </a>
    </div>

    <?php include_once __DIR__."/nadv_admin.php"; ?>

    <footer class="footer">
        ©<?= date("Y") ?> Solución desarrollada por
        <a class="fw-bold" target="_blank" href="https://jc-innovation.com/">JC Innovation</a>. All Rights Reserved.
    </footer>
</aside>