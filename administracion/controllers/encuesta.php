<?php
require '../../config.php';


require '../../models/conexion.php';
require '../../models/helper.php';
require '../models/encuesta.php';

$A = new Encuesta();
$H = new Helper();

$accion = (isset($_GET['accion']) && $_GET['accion'] != "") ? $_GET['accion'] : "default";
switch ($accion) {
    case 'crear':
        if (isset($_POST) && !empty($_POST)) {
            $verT = $A->temaV($_POST["tema"]);
            if ($verT) {
                $primerElemento = $verT[0];
                $id = $primerElemento->id;
                $campos = array("id_tema", "tema", "pregunta");
                $valores = array($id, $_POST["tema"]);
                $numPreguntas = $_POST["numP"];

                $preguntas = array();
                for ($i = 1; $i <= $numPreguntas; $i++) {
                    $nombrePregunta = "pregunta" . $i;
                    $valores = array($id, $_POST["tema"], $_POST[$nombrePregunta]);

                    $campos = array("id_tema", "tema", "pregunta");
                    $A->setTabla("encuesta_2024");
                    $A->insertar($campos, $valores);
                }
                $H->crearMensaje("Se han agregado éxitosamente las preguntas", "success");
                header("Location: https://curso-ameh.com/admin/respuestas.php?T=" . $_POST["tema"]);
            } else {
                $valores = array($_POST["tema"]);
                $campos = array("tema");
                $A->setTabla("temas2024");
                $idT = $A->insertar($campos, $valores);
                if ($idT) {
                    $campos = array("id_tema", "tema", "pregunta");
                    $valores = array($idT, $_POST["tema"]);
                    $numPreguntas = $_POST["numP"];

                    $preguntas = array();
                    for ($i = 1; $i <= $numPreguntas; $i++) {
                        $nombrePregunta = "pregunta" . $i;
                        $valores = array($idT, $_POST["tema"], $_POST[$nombrePregunta]);

                        $campos = array("id_tema", "tema", "pregunta");
                        $A->setTabla("encuesta_2024");
                        $A->insertar($campos, $valores);
                    }
                    $H->crearMensaje("Se han agregado éxitosamente las preguntas", "success");
                    header("Location: https://curso-ameh.com/admin/respuestas.php?T=" . $_POST["tema"]);
                }
            }
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'respuestas':
        if (isset($_POST) && !empty($_POST)) {
            $responses = array();
            foreach ($_POST as $datos => $value) {
                $nombre_campo = '';
                if (strpos($datos, 'pregunta_') === 0) {
                    $indice_pregunta = substr($datos, 9);
                    $pregunta = $value;
                    $nombre_campo = 'numR_' . $indice_pregunta;

                    if (isset($_POST[$nombre_campo])) {
                        $valor_campo = $_POST[$nombre_campo];
                    } else {
                        $respuesta = array('response' => 'error');
                        echo json_encode($respuesta);
                    }

                    $opciones_respuesta = $_POST['op_' . $indice_pregunta];
                    $campos_respuesta = array();
                    $valores_respuesta = array();



                    for ($i = 0; $i < count($opciones_respuesta); $i++) {
                        $valores_respuesta = $opciones_respuesta[$i];
                        $campos_respuesta = "op_" . ($i + 1);
                        $post = 'pregunta_' . $indice_pregunta;

                        $campos = array($campos_respuesta);
                        $valores = array($valores_respuesta);

                        $A->setTabla("encuesta_2024");
                        $condicion = "tema='" . $_POST['tema'] . "' and  pregunta='" . $_POST[$post] . "'";

                        if ($A->actualizar($campos, $valores, $condicion)) {
                            $responses[] = array('response' => 'OK');
                        } else {
                            $responses[] = array('response' => 'error');
                        }
                    }
                }
            }
            echo json_encode($responses);
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'insertar':
        if (isset($_POST) && !empty($_POST)) {
            $verEmail = $A->veremailt($_POST['email'],$_POST['tema']);
            if ($verEmail) {

                $idT = $A->validarTID($_POST['tema']);
                $H->crearMensaje("Lo sentimos, el correo electrónico ingresado ya ha contestado la encuesta.", "warning");
                header("Location: ../encuesta.php?T=" . $idT[0]->id);
            } else {
                foreach ($_POST as $datos => $value) {
                    $nombre_campo = '';
                    if (strpos($datos, 'pregunta_') === 0) {
                        $indice_pregunta = substr($datos, 9);
                        $pregunta = $value;

                        $opciones_respuesta = $_POST['op_' . $indice_pregunta];
                        $campos_respuesta = array();
                        $valores_respuesta = array();

                        for ($i = 0; $i < count($opciones_respuesta); $i++) {
                            $valores_respuesta = $opciones_respuesta[$i];
                            $campos_respuesta = "op_" . $indice_pregunta;
                            $post = 'pregunta_' . $indice_pregunta;

                            $campos = array("tema", "pregunta", "respuesta", "email");
                            $valores = array($_POST['tema'], $_POST[$post], $_POST[$campos_respuesta], $_POST['email']);

                            $A->setTabla("formulario");

                            if ($A->insertar($campos, $valores)) {
                                echo "biem";
                            } else {
                                echo "mal";
                            }
                        }
                    }
                }
                header("Location: https://curso-ameh.com/admin/success.php?T=" . $_POST["tema"]);
                exit;
            }
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'fin':
        if (isset($_GET) && !empty($_GET)) {
            $campos = array("fecha_hr_fin");
            $valores = array(date("Y-m-d H:i:s"));

            $A->setTabla("encuesta_2024");
            $condicion = "tema='" . $_GET['id'] . "'";

            if ($A->actualizar($campos, $valores, $condicion)) {
                $responses[] = array('response' => 'OK');
            } else {
                $responses[] = array('response' => 'error');
            }
            echo json_encode($responses);
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'eliminar':
        if (isset($_GET) && !empty($_GET)) {
            $delete = $A->deleteTeam($_GET['id']);
            if ($delete !== false) {
                $responses[] = array('response' => 'OK');
            } else {
                $responses[] = array('response' => 'error');
            }
            echo json_encode($responses);
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'reactivar':
        if (isset($_GET) && !empty($_GET)) {
            $campos = array("fecha_hr_fin");
            $valores = array("0000-00-00 00:00:00");

            $A->setTabla("encuesta_2024");
            $condicion = "tema='" . $_GET['id'] . "'";

            if ($A->actualizar($campos, $valores, $condicion)) {
                $responses[] = array('response' => 'OK');
            } else {
                $responses[] = array('response' => 'error');
            }
            echo json_encode($responses);
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'verificar_respuestas':
        if (isset($_GET) && !empty($_GET)) {
            $verT = $A->VAli($_GET["T"]);
            if ($verT) {
                $responses[] = array('response' => 'no');
            } else {
                $responses[] = array('response' => 'si');
            }
            echo json_encode($responses);
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'edit':
        if (isset($_POST) && !empty($_POST)) {
            $campos = array("tema");
            $valores = array($_POST['tema']);
            $A->setTabla("temas2024");
            $condicion = "id='" . $_POST['id'] . "'";
            $idTV = $A->actualizar($campos, $valores, $condicion);

            if ($idTV) {
                $responses = array();
                $numPreguntas = 0;

                foreach ($_POST as $clave => $valor) {
                    if (strpos($clave, 'pregunta_') === 0) {
                        $numPreguntas++;
                    }
                }

                for ($i = 0; $i < $numPreguntas; $i++) {
                    $nombrePregunta = "pregunta_" . $i;
                    $origenP = "orig_pregunta_" . $i;

                    $idTema = $_POST['id'];

                    $tema = $_POST["tema"];
                    $pregunta = $_POST[$nombrePregunta];

                    $A->setTabla("encuesta_2024");
                    $campos = array("tema", "pregunta");
                    $valores = array($tema, $pregunta);
                    $condicion = "id_tema = '$idTema' AND pregunta = '" . $_POST[$origenP] . "'";

                    $idTV = $A->actualizar($campos, $valores, $condicion);
                    if ($idTV) {
                        $responses[] = array('response' => 'OK');
                    }
                }
                echo json_encode($responses);

                $H->crearMensaje("Las preguntas se han actualizado correctamente", "success");
                header("Location: https://curso-ameh.com/admin/ediR.php?T=" . $_POST["tema"]);
            } else {
                $responses[] = array('response' => 'error');
            }
            echo json_encode($responses);
            exit;
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'editR':
        if (isset($_POST) && !empty($_POST)) {
            $responses = array();
            $numPreguntas = 0;

            foreach ($_POST as $clave => $valor) {
                if (strpos($clave, 'orig_pregunta_') === 0) {
                    $numPreguntas++;
                    $indice_pregunta = substr($clave, 14);
                    $pregunta = $_POST['orig_pregunta_' . $indice_pregunta];

                    for ($i = 1; isset($_POST[$indice_pregunta . '_op_' . $i]); $i++) {
                        $clave_opcion = $indice_pregunta . '_op_' . $i;
                        $opcion_respuesta = $_POST[$clave_opcion];
                        $campos = 'op_' . $i;

                        $A->setTabla("encuesta_2024");
                        $campos = array($campos);
                        $valores = array($opcion_respuesta);
                        $condicion = " pregunta = '" . $pregunta . "'";
                        $idTV = $A->actualizar($campos, $valores, $condicion);
                        if ($idTV) {
                            $responses[] = array('response' => 'OK');
                        }
                    }
                }
            }
            $H->crearMensaje("Respuestas actualizadas correctamente", "success");
            header("Location: https://curso-ameh.com/admin/");
            exit;
        } else {
            $H->crearMensaje("Error. Verifica los campos", "warning");
            header("Location: ../");
            exit;
        }
        break;
    case 'graph':
        if (isset($_GET['id'])) {
            $idEncuesta = $_GET['id'];
            echo json_encode($datosGrafica);
        } else {
            echo json_encode(['error' => 'ID de encuesta no proporcionado']);
        }
        break;
    case 'qr':
        if (isset($_GET['id'])) {
            $queryString = parse_url($_GET['id'], PHP_URL_QUERY);
            parse_str($queryString, $params);

            $valor = isset($params['T']) ? $params['T'] : null;
            $campos = array("qr");
            $valores = array($_GET['id']);
            $condicion = " id = '" . $valor . "'";
            $A->setTabla("temas2024");
            if ($A->actualizar($campos, $valores, $condicion)) {
                $responses[] = array('response' => 'ok');
            } else {
                $responses[] = array('response' => 'error');
            }
        } else {
            $responses[] = array('response' => 'error');
        }
        echo json_encode($responses);
        break;
    case 'qrSave':
?>
        <script>
            document.getElementById('qr2').addEventListener('click', function() {
                try {
                    var valor = document.getElementById('link').value;
                    console.log('Valor del input:', valor);
                    var url = "controllers/encuesta.php?accion=qr&id=" + valor;
                    fetch(url)
                        .then(response => response.blob()) // Cambiar a response.blob() para obtener los datos binarios
                        .then(blob => {
                            const newWindow = window.open('', '_blank'); // Abrir una nueva ventana en blanco
                            const imageUrl = URL.createObjectURL(blob); // Crear una URL para el objeto binario

                            // Cuando la ventana nueva haya cargado, mostrar la imagen en ella
                            newWindow.onload = function() {
                                const img = newWindow.document.createElement('img');
                                img.src = imageUrl;
                                newWindow.document.body.appendChild(img);
                            };

                            // Cuando se cierre la ventana nueva, liberar la URL del objeto binario
                            newWindow.onunload = function() {
                                URL.revokeObjectURL(imageUrl);
                            };
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                } catch (error) {
                    console.error('Error al generar el código QR:', error);
                }
            });
        </script>
<?php
        break;
    default:
        echo 'DEFAULT';
        break;
}
