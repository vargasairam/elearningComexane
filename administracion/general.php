<?PHP
include 'config.php';
require './models/conexion.php';
require './../models/helper.php';
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
                            <h3 class="mb-0">Formulario: "Encuestas".</h3>
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
                <form class="uk-child-width-1-@s uk-grid-small" uk-grid method="POST" action="controllers/encuesta.php?accion=crear">
                    <div uk-height-viewport class="uk-flex uk-flex-middle">
                        <div class="uk-width-3-5@s p-2">
                            <div class="uk-form-group">
                                <label class="uk-form-label" for="">Ingresa el título de la encuesta:</label>
                                <div class="uk-position-relative w-100">
                                    <input class="uk-input uk-form-small" type="text" name="tema" id="tema" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-2-5@s p-4" style="background-color: lemonchiffon;">
                        <div class="uk-form-group">
                            <label class="uk-form-label" for="">Agrega el número de preguntas que requieres realizar en la encuesta:</label>
                            <div class="uk-position-relative w-100">
                                <input class="uk-input uk-form-small" type="number" name="numP" id="numP" required onchange="generarPreguntas()">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-4-5@s p-4" id="preguntasContainer">
                        <div class="uk-form-group">
                            <label class="uk-form-label" for="">Ingrese la pregunta</label>
                            <div class="uk-position-relative w-100">
                                <input class="uk-input uk-form-small" type="text" name="pregunta" id="pregunta">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                            <div class="uk-width-expand@s">

                            </div>
                            <div class="uk-width-auto@s">
                                <input type="submit" class="btn btn-default" value="Guardar"></input>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include "view/estructura/footer.php";
    ?>
    <script>
        function generarPreguntas() {
            var numPreguntas = document.getElementById("numP").value;
            var preguntasContainer = document.getElementById("preguntasContainer");
            preguntasContainer.innerHTML = ""; // Limpiar contenido anterior

            for (var i = 1; i <= numPreguntas; i++) {
                var preguntaDiv = document.createElement("div");
                preguntaDiv.className = "uk-width-4-5@s p-4";
                preguntaDiv.innerHTML = `
          <div class="uk-form-group">
            <label class="uk-form-label" for="pregunta${i}">Ingrese la pregunta ${i}:</label>
            <div class="uk-position-relative w-100">
              <input class="uk-input uk-form-small" type="text" name="pregunta${i}" id="pregunta${i}" required>
            </div>
          </div>
        `;
                preguntasContainer.appendChild(preguntaDiv);
            }
        }
    </script>
</body>

</html>