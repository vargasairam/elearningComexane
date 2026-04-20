<?PHP
include 'config.php';
require './models/conexion.php';
require './../models/helper.php';
require './models/encuesta.php';

$A = new Encuesta();
$H = new Helper();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/night-mode.css">
    <link rel="stylesheet" href="../assets/css/framework.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/image-map-pro.min.css">
    <link rel="stylesheet" href="../assets/css/icons.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script defer src="js/app.js"></script>


    <style>
        @media (max-width: 480px) {
            [class*='uk-width'] {
                width: 90%;
                max-width: 90%;
                padding-top: 5px;
                padding-bottom: 5px
            }

            .p-5 {
                padding: 1rem !important;
            }
        }
    </style>
</head>

<body style="background-image: url(../assets/images//imagen-fondo.jpg); background-size: cover;">
    <div class="page-content">
        <div class="uk-width-2-3@m uk-width-1-2@s m-auto">
            <div class="">
                <div class="container">
                    <div class="row">
                        <?php
                        include "view/estructura/header.php";
                        ?>
                        <div class="mb-4 uk-text-center">
                            <?php
                            $tema = $_GET['T'];
                            $preguntas = $A->preguntas($tema);
                            $primerElemento = $preguntas[0];
                            $id = $primerElemento->id_tema;
                            ?>
                            <h3 class="mb-0"><?php echo $tema ?></h3>
                            <?php
                            $mensaje = $H->verMensaje();
                            if (isset($mensaje['texto']) && $mensaje['texto'] != "") {
                            ?>

                                <div class="uk-alert-<?= $mensaje['clase'] ?>" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p><?= $mensaje['texto'] ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mb-4 uk-text-center">
                                <div class="p-5">
                                    <a href="./" class="btn btn-default">Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-card-default p-4">
                <form id="miFormulario" class="uk-child-width-1-2@s uk-grid-small" uk-grid action="controllers/encuesta.php?accion=respuestas" method="post">
                    <input type="hidden" name="tema" value="<?php echo $tema ?>">
                    <?php foreach ($preguntas as $index => $p) : ?>
                        <div class="uk-width-3-5@s">
                            <div class="uk-form-group">
                                <label class="uk-form-label" for=""><?php echo ($index +1).".- ". $p->pregunta ?></label>
                                <input type="hidden" name="pregunta_<?php echo $index; ?>" value="<?php echo $p->pregunta ?>">
                            </div>
                        </div>
                        <div class="uk-width-2-5@s p-4" style="background-color: lemonchiffon;">
                            <div class="uk-form-group">
                                <label class="uk-form-label" for="">Agrega el número de respuestas que requieres realizar en la pregunta:</label>
                                <div class="uk-position-relative w-100">
                                    <input class="uk-input uk-form-small" type="number" name="numR_<?php echo $index; ?>" id="numR_<?php echo $index; ?>" required onchange="generarPreguntas('<?php echo $index; ?>')">
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-4-5@s p-4" id="preguntasContainer_<?php echo $index; ?>">
                            <div class="uk-form-group">
                                <label class="uk-form-label" for="">Ingrese la respuesta</label>
                                <div class="uk-position-relative w-100">
                                    <input class="uk-input uk-form-small" type="text" name="o_<?php echo $index; ?>[]" id="pregunta_<?php echo $index; ?>_0" required>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="uk-width-1-1">
                        <button class="uk-button uk-button-primary" type="submit">Guardar Respuestas</button>
                    </div>
                </form>
                <div class="mb-4 uk-text-center">
                    <div class="uk-width-auto@s p-2" id="qrform">
                        <input type="hidden" id="link" value="https://curso-ameh.com/admin/encuesta.php?T=<?php echo $id ?>">
                        <button id="qr2" class="btn btn-default" style="display: none;">Generar código QR</button>
                    </div>
                </div>
                <div class="mb-4 uk-text-center">
                    <div id="contenedorQR"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "view/estructura/footer.php";
    ?>
    <script>
        function generarPreguntas(index) {
            var letra = String.fromCharCode(65 + index);
            var numRespuestas = document.getElementById("numR_" + index).value;
            var respuestasContainer = document.getElementById("preguntasContainer_" + index);
            respuestasContainer.innerHTML = ""; // Limpiar contenido anterior


            for (var i = 1; i <= numRespuestas; i++) {
                var respuestaDiv = document.createElement("div");
                respuestaDiv.className = "uk-form-group";
                respuestaDiv.innerHTML = `
                    <label class="uk-form-label" for="respuesta${index}_${letra}">Ingrese la respuesta ${String.fromCharCode(64 + i)}:</label>
                    <div class="uk-position-relative w-100">
                        <input class="uk-input uk-form-small" type="text" name="op_${index}[]" id="respuesta_${index}_${letra}" required>
                    </div>
                `;
                respuestasContainer.appendChild(respuestaDiv);
            }
        }

        document.getElementById('miFormulario').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch(this.action, {
                    method: this.method,
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('qr2').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>

</html>