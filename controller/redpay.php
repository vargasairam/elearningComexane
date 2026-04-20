<?php
//require("config.php");
class Redpay {

    public function __construct() { }

    // EMAIL DEL USUARIO QUE VA A PAGAR
    //REFERENCIA ES UNA CADENA DE CARACTERES QUE LA GENERO YO MINIMO 7 Y MAXIMO 30 CARACTERES
    public function CrearOrden($CantidadPago, $emailCliente, $referencia) {
        $token = $this->GetToken();
        $url = $this->CrearTransaccion($CantidadPago,$emailCliente,$referencia,$token);
        return $url->urlRedirect;
    }

    public function ObtenerTransaccion($transactionNumber) {
        $token = $this->GetToken();
        $response = $this->ConsultarTransaccion($transactionNumber,$token);
        return $response;
    }

    private function CrearTransaccion($monto,$email,$newRefencia,$token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => urlPay.'api/pay/createtransaction',
            CURLOPT_TIMEOUT => 45,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "Amount":"'.$monto.'",
                "Currency":"MXN",
                "Email":"'.$email.'",
                "ReferenceNumber":"'.$newRefencia.'"
            }',
            CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
            ),
        ));
        $responses = curl_exec($curl);
        curl_close($curl);
        $responsesUrl = json_decode($responses);
        return $responsesUrl ;
    }
    private function GetToken(){
              
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => urlPay.'api/auth/Authenticate',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"UserId": "'.UserId.'",
            "Password": "'.Password.'"}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: ARRAffinity=a22bee764adf3e9df4bed245a73442b392871d12f9f388b1fbce8aabb0926adb; ARRAffinitySameSite=a22bee764adf3e9df4bed245a73442b392871d12f9f388b1fbce8aabb0926adb'
        ),
        ));
        
        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
            echo 'Error en cURL: ' . curl_error($curl);
            curl_close($curl);
            exit;
        }
        
        curl_close($curl);
        
        // Convertir el JSON en objeto
        $data = json_decode($response);
        
        // Acceder a los datos
        return $data->token;
    }

    private function ConsultarTransaccion($transactionNumber,$token) {
        //CONSULTAR LA DOCUMENTACION DEL TITULO 'Por número de transacción' PARA SABER QUE RESPONSE DEVUELVE
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => urlPay.'api/transaction/response/'.$transactionNumber,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$token
            )
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response;
    }
}
?>