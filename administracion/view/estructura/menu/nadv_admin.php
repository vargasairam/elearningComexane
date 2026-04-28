<nav class="nav_menu">
    <ul>
        <li>
            <a href="<?= BASE_URL ?>/administracion/?seccion=administracion" class="btn"><i class="ri-dashboard-line"></i><span>Inicio</span></a>
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
                <span class="w-100">Catálogos</span>
                <i class="ri-arrow-down-s-line ri-xl"></i>
            </button>
            <div class="collapse box_collapse" id="collapseExample">
                <ul>
                    <li><a href="?seccion=catalogos&accion=tipoProducto">Tipo de producto</a></li>
                    <li><a href="?seccion=catalogos&accion=cursos">Cursos</a></li>
                    <li><a href="?seccion=catalogos&accion=sesionesMensuales">Sesiones mensuales</a></li>
                </ul>
            </div>
        </li>
        <!-- <li>
            <a href="<?= BASE_URL ?>elearnigdev/redireccionPDF.php?recurso=programa" target="_blank" class="btn"><i class="ri-file-ai-line"></i><span>Programa en PDF</span></a>
        </li> -->
        <!-- <li>
            <a href="?seccion=constancias" class="btn"><i class="ri-award-line"></i><span>Constancias</span></a>
        </li> -->
    </ul>
</nav>