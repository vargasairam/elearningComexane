<?php

$modulos = $CC->GetModulosFecha($numero);

?>

<section class="content_global">

    <?php include_once "view/estructura/header.php"; ?>

    <div class="content_ondemand flex-column">

        <div

            class="drawer_ttl_pleca d-flex justify-content-start gap-2 gap-md-4">

            <div><i class="ri-checkbox-circle-fill ri-3x"></i></div>

            <div>

                <h3 class="mb-0 fw-semibold text">Módulo <?= $numero ?></h3>

                <p>Cursos de actualización en Hematología <?= date("Y") ?></p>

                <div class="d-flex gap-2 mt-4">

                    <?php

                    $videosCount = $V->getVideoCount($numero);

                    ?>

                    <?php if ($modulos->activar):  ?>

                        <div><?= $videosCount->total ?> videos disponibles</div>

                    <?php endif; ?>

                    <!-- <span>&#8226</span>

                    <div>

                        <span>Básico</span>

                        <span><i class="ri-arrow-right-line"></i></span>

                        <span>Avanzado</span>

                    </div> -->

                </div>

            </div>

        </div>

        <?php

        if ($user->categoria_id == 5 && !$H->moduloPagado($user->id, $numero)) {

        ?>

            <div class="w-100">

                <a class="uk-alert-close" uk-close></a>

                <center>

                    <p class="uk-text-dark">

                        <b>Para acceder a los videos de este módulo, es necesario realizar el pago del módulo.</b>

                    </p>

                    <a

                        href="?seccion=pagar"

                        class="btn btn-danger btn_live btn-sm btn_notify">

                        <i class="ri-record-circle-fill"></i> <span>Pagar</span>

                    </a>

                </center>

            </div>

        <?php

        } else { ?>

            <div class="w-100">

                <ul class="nav nav-pills nav-fill" id="tabsExample" role="tablist">

                    <li class="nav-item" role="presentation">

                        <button

                            class="nav-link btn-lg active"

                            id="tab-home"

                            data-bs-toggle="pill"

                            data-bs-target="#content-home"

                            type="button"

                            role="tab"

                            aria-controls="content-home"

                            aria-selected="true">

                            Ondemand

                        </button>

                    </li>

                    <li class="nav-item" role="presentation">

                        <button

                            class="nav-link btn-lg"

                            id="tab-profile"

                            data-bs-toggle="pill"

                            data-bs-target="#content-profile"

                            type="button"

                            role="tab"

                            aria-controls="content-profile"

                            aria-selected="false">

                            En vivo

                        </button>

                    </li>

                </ul>

                <div class="tab-content mt-5" id="tabsExampleContent">

                    <?php include 'ondemand.php'; ?>

                    <?php include 'ondemandLive.php' ?>

                </div>

            </div>

        <?php } ?>



        <!-- <div class="d-flex justify-content-center w-100">

            <a href="http://curso-ameh.com/redireccionPDF.php?recurso=programa" target="_blank"

                class="btn btn-primary mb-3">

                <small>Descargar el programa <?= date("Y") ?>

                    <i class="ri-file-download-line"></i></small>

            </a>

        </div> -->

        <!-- <div class="d-flex justify-content-center w-100">

            <a href="https://curso-ameh.com/?seccion=live" target="_blank"

                class="btn btn-primary mb-3">

                <small>Ver en vivo</small>

            </a>

        </div> -->

    </div>

</section>