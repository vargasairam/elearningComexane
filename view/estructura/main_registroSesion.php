<main class="wrapper_main wp_public d-flex justify-content-center align-items-start  min-vh-100">
    <section class="wrapper_home">
        <div class="content_home signin flex-lg-nowrap flex-md-wrap">
            <div class="drawer_home w-100">
                <div class="content_login" style="justify-content: start !important;">
                    <div class="text-center mt-3 mb-4"> 
                        <img src="../elearningComexane/imgs/comexane-logo.svg" alt="Logo COMEXANE A. C." class="brand_logo"/>
                    </div>

                    <div class="text-center mt-6">
                        <form class="form_login mb-3" action="controller/alumno.php?accion=registroSesion" method="POST">
                            <!-- <div class="alert alert-warning alert-outline-coloured alert-dismissible" role="alert">
                                <div class="alert-icon">
                                    <i class="far fa-fw fa-bell"></i>
                                </div>
                                <div class="alert-message">
                                    <strong>Si ya tienes una cuenta como socio, puedes iniciar sesión con las mismas credenciales.</strong>
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div> -->


                            <h3 class="text-center mb-3"> Elige la sesión mensual que deseas registrarte</h3>

                            <div class="form-floating mb-3">
                                <select class="form-control" id="sesion" name="sesion"></select>
                                <label for="floatingInput">Sesión</label>
                            </div>



                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" />
                                <label for="floatingInput">Correo electrónico</label>
                            </div>

                            <button style="width: 70%;" type="submit" class="btn btn-primary mx-auto d-block mt-4">Resgistrar</button>
                        </form>
                    </div>

                    
                </div>
            </div>

            <div class="drawer_hero_home w-100">
                <img class="picture_hero_home_" src="../elearningComexane/imgs/poster2026_comexane.png" alt="Colegio Mexicano de Anestesiología" />
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
</main>

<script src="./js/alumno/registroSesion.js"></script>