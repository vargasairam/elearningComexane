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
    <title>QR Code</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
</head>

<body>
<div class="mb-4 uk-text-center">
            <?php
            $queryString = parse_url($_GET['id'], PHP_URL_QUERY);
            parse_str($queryString, $params);

            $valor = isset($params['T']) ? $params['T'] : null;
            $tem = $A->temaID($valor);
            $tema = $tem[0]->tema;
            ?>
            <h3 class="mb-0"><?php echo "QR del tema: " .$tema ?></h3>
        </div>
    <div class="container">
        <div id="qrcode"></div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        // Crear el código QR con el valor obtenido
        const qr = new QRCode(document.getElementById('qrcode'), {
            text: id,
            width: 200,
            height: 200
        });
    </script>
</body>

</html>