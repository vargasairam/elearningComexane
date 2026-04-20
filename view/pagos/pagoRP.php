<?php
require_once __DIR__.'/../../config/config.php';
// webhook_redpay.php
// 1. Validar existencia de POST
/*if (empty($_POST)) {
    http_response_code(400);
    exit('No se recibieron datos');
}*/

// 2. Respuesta inmediata al webhook
http_response_code(200);
header('Content-Type: application/json');


// 3. Obtener datos de $_POST directamente
$data = $_POST;
// $data['ResponseCode'] ="002";
// $data['Status'] = "Accepted";
// 4. Almacenar payload completo como JSON
$payload = json_encode($data);

// 5. Conectar con la base de datos (ajusta credenciales)
$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";port=3307;dbname=" . DB_NAME,
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// 6. Insertar datos en la base de datos
$stmt = $pdo->prepare("
    INSERT IGNORE INTO redpay_webhook_events
    (payload, response_code, status, message, transaction_number, reference_number, transaction_code)
    VALUES
    (:payload, :response_code, :status, :message, :transaction_number, :reference_number, :transaction_code)
");

$stmt->execute([
    ':payload'            => $payload,
    ':response_code'      => $data['ResponseCode'] ?? null,
    ':status'             => $data['Status'] ?? null,
    ':message'            => $data['Message'] ?? null,
    ':transaction_number' => $data['TransactionNumber'] ?? null,
    ':reference_number'   => $data['ReferenceNumber'] ?? null,
    ':transaction_code'   => $data['TransactionCode'] ?? null
]);


    // Obtener primer dígito del ReferenceNumber
    $referenceNumber = $data['ReferenceNumber'] ?? '';
    $primerDigito = substr($referenceNumber, 0, 1);

    // Preparar parámetros en base64 para redirección
    $params = [
        'responseCode'      => base64_encode($data['ResponseCode']),
        'status'            => base64_encode($data['Status']),
        'transactionNumber' => base64_encode($data['TransactionNumber']),
        'referenceNumber'   => base64_encode($data['ReferenceNumber']),
        'transactionCode'   => base64_encode($data['TransactionCode']),
    ];

    $queryString = http_build_query($params);

    //NO ES NECESARIO TENER 2 URL, SOLO ESTA PUESTA PORQUE EL CODIGO ERA COMPARTIDO, SI LAS KEY SON DE DISTINTOS CLIENTES, SOLO DEJA UNA URL
    $URL_REDIRECT_1 = "https://registroeventos.com/anestesia_critica/RedPay/Callback.php";
    $URL_REDIRECT_2 = "";
    // Decidir URL según primer dígito del ReferenceNumber
    if ($primerDigito === '1') {
        $urlRedirect = $URL_REDIRECT_1."?".$queryString;
    } elseif ($primerDigito === '2') {
        $urlRedirect = $URL_REDIRECT_2."?".$queryString;
    } else {
        // Dígito inválido, terminar proceso
        http_response_code(400);
        exit('Referencia inválida');
    }

    // Realizar la redirección
    header("Location: $urlRedirect");
    exit;

?>