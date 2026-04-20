<?php

include 'config/config.php';

$ruta = BASE_URL;

if (isset($_GET['recurso'])) {

    switch ($_GET['recurso']) {

        case 'programa':

            $ruta =  BASE_URL . "elearnigdev/pdf/PROGRAMA PRELIMINAR CURSO HBE 2026_V1.pdf";

            $archivoFisico = __DIR__ . "elearnigdev/pdf/PROGRAMA PRELIMINAR CURSO HBE 2026.pdf";

            $version = filemtime($archivoFisico);

            break;

        case  'poster':

            $ruta =  BASE_URL . "imgs/Cartel_Curso_HBE_2026.png";

            break;

        case 'uploadFile':

            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {

                $nombreArchivo = "pruebas.pdf";

                $rutaDestino = "elearnigdev/pdf/" . basename($nombreArchivo);



                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)) {

                    $rutaFile = BASE_URL . $rutaDestino;

                    // Redirigir al archivo subido

                    header("Location: " . '?recurso=programa');

                    exit;
                } else {

                    echo "Error al mover el archivo.";
                }
            } else {

                echo "No se subió ningún archivo válido.";
            }

            exit;

            break;

        default:

            $ruta = BASE_URL . "elearnigdev/";

            break;
    }
}



header("Location: {$ruta}?v={$version}");

exit;
