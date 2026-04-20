<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="content_live">
        <div class="drawer_video_live">
            <?php
            // var_dump($H->moduloPagado($user->id, 2));
            if ($transmision->existe) {
                if ($user->categoria_id == 5 && !$H->moduloPagado($user->id, $transmision->id)) { ?>
                <?php } else { ?>
                    <div class="embed-video">
                        <?php if (!isset($_GET["canalTraducion"])) { ?>
                            <iframe
                                id="videoFrame"
                                src="https://vimeo.com/event/<?= $transmision->canal1 ?>/embed/interaction"
                                frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture"
                                allowfullscreen></iframe>
                        <?php } else { ?>
                            <iframe
                                id="videoFrame"
                                src="https://vimeo.com/event/<?= $transmision->canal2 ?>/embed/interaction"
                                frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture"
                                allowfullscreen></iframe>
                        <?php } ?>
                    <?php } ?>
                    </div>
                <?php } else { ?>
                    <div style="padding:56.25% 0 0 0;position:relative;">
                        <iframe src="https://player.vimeo.com/video/637981011?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" referrerpolicy="strict-origin-when-cross-origin" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Intro1"></iframe>
                    </div>
                <?php } ?>
        </div>
        <?Php
        if ($user->categoria_id == 5 && !$H->moduloPagado($user->id, $transmision->id)) { ?>
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
        <?php } else { ?>
            <!-- <div class="drawer_opcion_questions cards">
                <ul class="nav nav-pills nav-fill" id="tabsExample" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="tab-home"
                            data-bs-toggle="pill"
                            data-bs-target="#content-home"
                            type="button"
                            role="tab"
                            aria-controls="content-home"
                            aria-selected="true">
                            Preguntas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="tab-profile"
                            data-bs-toggle="pill"
                            data-bs-target="#content-profile"
                            type="button"
                            role="tab"
                            aria-controls="content-profile"
                            aria-selected="false">
                            Canales
                        </button>
                    </li>
                </ul>
                <div class="tab-content mt-4" id="tabsExampleContent">
                    <div
                        class="tab-pane fade show active"
                        id="content-home"
                        role="tabpanel"
                        aria-labelledby="tab-home">
                        <h6 class="mb-4">
                            Escribe aquí tu pregunta y será leido por el coordinador al
                            final de la presentación.
                        </h6>
                        <div>
                            <form id="questionForm" action="controller/transmision.php?accion=saveQuestion" method="post">
                                <textarea
                                    class="form-control mb-3"
                                    id="question"
                                    rows="3"
                                    name="question"
                                    placeholder="Tu pregunta aquí"></textarea>
                                <?php if ($transmision) { ?>
                                    <input type="hidden" name="modulo" id="modulo" value="<?= $transmision->id ?>">
                                    <button type="submit" class="btn btn-primary">
                                        Enviar comentario <i class="ri-arrow-right-line"></i>
                                    </button>
                                <?php } ?>
                            </form>
                            <input type="hidden" id="respuesta">
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.getElementById("questionForm").addEventListener("submit", function(e) {
                            e.preventDefault();
                            let formData = new FormData(this);

                            fetch(this.action, {
                                    method: this.method,
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.status === "success") {
                                        Swal.fire({
                                            position: "top-end",
                                            icon: "success",
                                            title: "Se ha guardado tu pregunta",
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        document.getElementById("question").value = "";
                                    } else {
                                        document.getElementById("respuesta").innerHTML =
                                            "<div class='alert alert-danger'>Error: " + data.message + "</div>";
                                    }
                                })
                                .catch(err => {
                                    document.getElementById("respuesta").innerHTML =
                                        "<div class='alert alert-danger'>Error en la petición</div>";
                                    console.error(err);
                                });
                        });
                    </script>

                </div>
                <div
                    class="tab-pane fade"
                    id="content-profile"
                    role="tabpanel"
                    aria-labelledby="tab-profile">
                    <h5>Canales en vivo</h5>
                    <hr>
                    <div>
                        <a href="?seccion=live&accion=live" class="btn btn-light text-start w-100 mb-2"><i class="ri-play-fill"></i> Español</a>
                        <a href="?seccion=live&accion=live&canalTraducion" class="btn btn-light text-start w-100 "><i class="ri-play-fill"></i> Ingles</a>
                    </div>
                </div>
            </div> -->
        <?php } ?>
    </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function sumarTiempo() {
        let tiempo = 0;
        setInterval(() => {
            tiempo += 1;
            $.ajax({
                url: 'controller/transmisiones.php?accion=guardarLive',
                type: 'POST',
                data: JSON.stringify({
                    modulo: moduleId,
                    segundos: tiempo
                }),
                contentType: 'application/json; charset=utf-8',
                processData: false,
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        console.log("Tiempo guardado:", response);
                    } catch (e) {
                        console.error("Error al parsear respuesta:", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al guardar el tiempo:", error);
                }
            });
        }, 60000);
    }

    function conteoRegresivo(time) {
        var horas = Math.floor(time / 3600);
        var minutos = Math.floor((time % 3600) / 60);
        var segundos = time % 60;

        minutos = minutos < 10 ? '0' + minutos : minutos;
        segundos = segundos < 10 ? '0' + segundos : segundos;
        var resultado = horas + ":" + minutos + ":" + segundos;

        time = Math.floor(time - 1);
        if (time >= 0) {
            setTimeout(
                function() {
                    conteoRegresivo(time);
                }, 1000);
        } else {
            sumarTiempo(<?php echo $transmision->id; ?>);
        }
    }
    var moduleId = <?= $transmision->id ?>;
    <?php
        //var_dump($transmision);
        if($transmision->id != NULL){
            $fecha_hora_inicio = strtotime($transmision->fecha_hora_inicio);
            $ahora = time();
            $segundos_faltantes = $fecha_hora_inicio - $ahora; ?>
            console.log("segundos: <?php echo $segundos_faltantes; ?>");
            <?php if (date('Y-m-d H:i:s') <= $transmision->fecha_hora_fin) { ?>
                console.log("entra sin");
                conteoRegresivo(<?php echo $segundos_faltantes; ?>);
            <?php }
        }
     ?>
</script>