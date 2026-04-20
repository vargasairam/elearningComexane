<main class="wrapper_main wp_public d-flex justify-content-center align-items-center min-vh-100">

    <section class="wrapper_home">

        <div class="d-flex justify-content-end">

            <!-- <a href="http://curso-ameh.com/redireccionPDF.php?recurso=programa&v=<?= time() ?>" target="_blank"

                class="btn btn-primary mb-3 btn-sm">

                Descargar el programa <?= date("Y") ?>

                <i class="ri-file-download-line"></i>

            </a> -->

        </div>

        <div class="content_home signin flex-lg-nowrap flex-md-wrap">

            <div class="drawer_home w-100">

                <div class="content_login">

                    <div class="text-center">

                        <img

                            src="../elearnigdev/imgs/comexane-logo.svg"

                            alt="Logo COMEXANE A. C."

                            class="brand_logo" />

                    </div>



                    <form class="form_login mb-3" action="controller/alumno.php?accion=login" method="POST">

                        <h3 class="text-center mb-0">Iniciar sesión</h3>



                        <div class="form-floating mb-3">

                            <input

                                type="email"

                                class="form-control"

                                id="email"

                                name="email"

                                placeholder="name@example.com" />

                            <label for="floatingInput">Correo electrónico</label>

                        </div>



                        <div class="form-floating my-3">

                            <input

                                type="password"

                                class="form-control"

                                id="password"

                                name="password"

                                placeholder="Password" />

                            <label for="floatingPassword">Contraseña</label>

                        </div>



                        <!-- <a

                            href="/dashboard.html"

                            type="submit"

                            class="btn btn-primary w-100">

                            Iniciar sesión

                        </a> -->

                        <button style="width: 70%;" type="submit" class="btn btn-primary mx-auto d-block mt-4">Iniciar sesión</button>

                    </form>



                    <div class="box_register text-center">

                        <p>

                            ¿Eres nuevo en el Colegio Mexicano de Anestesiología?

                        </p>

                        <a href="registro.php" class="btn btn-secondary w-100 my-3" style="background: #17223c;border-color: #17223c;color: white;">Registrarme</a>

                    </div>

                </div>

            </div>

            <!-- <div class="drawer_hero_home w-100">

                <div

                    class="box_hero_home"

                    style="background-image: url(http://curso-ameh.com/redireccionPDF.php?recurso=poster)"></div>

                <img

                    class="picture_hero_home"

                    src="http://curso-ameh.com/redireccionPDF.php?recurso=poster&v=<?= time() ?>"

                    alt="Agrupación Mexicana para el Estudio de la

              Hematología" />

            </div> -->

            <div class="drawer_hero_home w-100">

                <img

                    class="picture_hero_home_"

                    src="../elearnigdev/imgs/poster2026_comexane.png"

                    alt="Colegio Mexicano de Anestesiología" />

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