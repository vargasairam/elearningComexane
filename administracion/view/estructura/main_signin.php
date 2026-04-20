<main class="wrapper_main wp_public d-flex justify-content-center align-items-center min-vh-100">
    <section class="wrapper_home">
        <div class="content_home signin flex-lg-nowrap flex-md-wrap">
            <div class="drawer_home w-100">
                <div class="content_login">
                    <div class="text-center">
                        <img src=<?= $configuracion->logo ?> alt="Logo COMEXANE A. C." class="brand_logo"/>
                    </div>

                    <h4 class="text-center mb-0">Sistema de administración</h4>

                    <form class="form_login_admin" action="controllers/usuarios.php?accion=login" method="POST">
                        <h3 class="text-center mb-0">Iniciar sesión</h3>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" />
                            <label for="floatingInput">Correo electrónico</label>
                        </div>

                        <div class="form-floating my-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
                            <label for="floatingPassword">Contraseña</label>
                        </div>
                        <button style="width: 70%;" type="submit" class="btn btn-primary mx-auto d-block mt-4">Iniciar sesión</button>
                    </form>
                </div>
            </div>

            <div class="drawer_hero_home w-100">

                <img

                    class="picture_hero_home_"

                    src="../../elearnigdev/imgs/poster2026_comexane.png"

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