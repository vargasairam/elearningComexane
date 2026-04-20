<main class="wrapper_main wp_public d-flex justify-content-center align-items-center min-vh-100">
    <section class="wrapper_home">
        <!-- <div class="d-flex justify-content-end">

            <a href="http://curso-ameh.com/redireccionPDF.php?recurso=programa" target="_blank"

                class="btn btn-primary mb-3">

                <small>Descargar el programa <?= date("Y") ?>

                    <i class="ri-file-download-line"></i></small>

            </a>

        </div> -->
        <div class="content_home">
            <div class="drawer_home w-100">
                <div class="d-flex gap-3 align-items-center">
                    <a href="signin.php" class="btn btn_back" style="background: #D43D4A;border-color: #D43D4A;color: white;"><i class="ri-arrow-left-line"></i></a>
                    <h3 class="text-center mt-1">Crear usuario nuevo</h3>
                </div>

                <div class="content_login signin registro">
                    <div class="text-center">
                        <img src="../elearnigdev/imgs/comexane-logo.svg" alt="Logo COMEXANE A. C." class="brand_logo" />
                    </div>

                        <div class="container mt-5">
                            <!-- Barra de progreso -->
                            <div class="progress mb-4">
                                <div class="progress-bar" id="progressBar" style="width:20%"></div>
                            </div>



                            <!-- Indicador de pasos -->
                            <div class="d-flex justify-content-between mb-4 text-center">
                                <div id='tabCuenta' class="step active">Cuenta</div>
                                <div id='tabDatos' class="step">Personales</div>
                               <!--  <div id='tabProfesion' class="step">Fiscales</div> -->
                                <div id='tabUbicacion' class="step">Dirección</div>
                                <!-- <div id='tabPreferencia' class="step">Profesionales</div> -->
                            </div>

                            <!-- <form  id="formRegistro" class="form_register" method="POST" action="./controller/registro.php?accion=Registro" autocomplete="off"> -->

                            <!-- Paso 1 -->

                            <div class="form-step active">
                                <h4 class="mb-4">Cuenta</h4>
                                <?php require_once __DIR__.'/registro/step1.php'; ?>
                            </div>

                            <!-- Paso 2 -->
                            <div class="form-step">
                                <h4 class="mb-4">Datos personales</h4>
                                <?php require_once __DIR__.'/registro/step2.php'; ?>
                            </div>

                            <!-- Paso 3 -->

                            <!-- <div class="form-step">
                                <h4 class="mb-4">Identificación fiscal</h4>
                                <?php require_once __DIR__.'/registro/step3.php'; ?>
                            </div> -->


                            <!-- Paso 4 -->
                            <div class="form-step">
                                <h4 class="mb-4">Dirección</h4>
                                <?php require_once __DIR__.'/registro/step4.php'; ?>
                            </div>


                            <!-- Paso 5 -->
                            <!-- <div class="form-step">
                                <h4 class="mb-4">Datos profesionales</h4>
                                <?php require_once __DIR__.'/registro/step5.php'; ?>
                            </div>  -->

                            <div class="d-flex justify-content-between mt-5 mx-5">
                                <a class="btn prev d-none" style="background: #D43D4A;border-color: #D43D4A;color: white;">Anterior</a>
                                <a class="btn btn-primary next ">Siguiente</a>
                                <a class="btn btn-success d-none enviar" id='enviar'>Enviar registro</a>
                            </div>

                        </div>

                    </form>

                </div>

            </div>



            

           

            <div class="hero_home_registro w-100 fit-content">
                <img class="picture_hero_home_" src="../elearnigdev/imgs/poster2026_comexane.png" alt="Colegio Mexicano de Anestesiología" />
            </div>

        </div>

        <div class="text-end mt-2 foot">

            <small>

                ©2026 Solución desarrollada por

                <a

                    class="c_primary"

                    target="_blank"

                    href="https://jc-innovation.com/">JC Innovation</a>. All Rights Reserved.</small>

        </div>

    </section>

    <?php require_once __DIR__.'/registro/modalPreguntas.php'; ?>
    <?php require_once __DIR__.'/registro/modalTerminos.php'; ?>
</main>


<script src="./js/registro/registro.js"></script>
<script src="./js/registro/steps.js"></script>