<?php
  require './vendor/autoload.php';
  require './config/config.php';
  require './core/conexion.php';
  require './model/alumno.php';
  require './model/helper.php';

  //\Stripe\Stripe::setApiKey("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");
  //CUENTA O
  //\Stripe\Stripe::setApiKey("sk_test_51MmJTOGuTfIl032Majf4NM807znGxSAzFysiDxy7ke9HDgtha6enG8jYzQU4lobgTE3x4OpWkXBWsEmqT0YZSk2m007pZd6sF2");
//sk_test_51LGlgnIHum4WRUlhMa2wSON53RUe5crkwEMky6gPFHlPmfT09SEaFfurkpgsSBDLEi9FlXeC9s2skoh16iy83XxT00uGEpEDQp
// $stripe = new \Stripe\StripeClient('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');
//MI SK DE PRUEBA
$stripe = new \Stripe\StripeClient(key_stripe_secret);
  $token = $_POST["stripeToken"];
  $amount = $_POST["pago"];
  $description = $_POST["description"];
  $id = $_POST["id"];
  $modulo = (isset($_POST["modulo"])?$_POST["modulo"]:"");
  $descripcion_modulo = (isset($_POST["modulo"])? "Modulo ".$_POST["modulo"]:"");
  $email = $_POST["email"];
  $name = $_POST["name"];

  try {
    $customer = $stripe->customers->create([
        'name' => $name,
        'email' => $email,
        "source" => $token,
    ]);
    $customerID = $customer->id;
    /* $customer = $stripe->customers->retrieve($customerID);
    $customer->sources->create(['source' => 'tok_1ObPyDGuTfIl032MVXwcFJ1m']); */
    /* $charge = \Stripe\Charge::create([ */
    $charge = $stripe->charges->create([
        "amount" => $amount,
        "currency" => "mxn",
        "description" => $description . $descripcion_modulo,
        "customer" => $customerID,
    ]);
    /* var_dump($charge);
    exit; */
    //echo "<pre>", print_r($charge), "</pre>";

    if($charge->status){
        /* var_dump($charge);
        exit; */
        $A = new Alumno();
        $H = new Helper();
        //Se agrego para saber que modulo se compro
        $datosExtra = (object)[
            'modulo'=>null,
            'curso'=>'CURSO HEMATOLOGÍA 2026'
        ];
        if(isset($_POST["modulo"]) && !empty($_POST["modulo"])) {
            //SE AGREGO PARA SABER QUE MODULO SE COMPRO
            require_once __DIR__.'/model/catalogos.php';
            $CC = new Catalogos();
            $NombreModulo = $CC->GetModuloById($modulo);
            $datosExtra->modulo = $NombreModulo->nombre;
            //FIN

            $modulo = $_POST["modulo"];
            $amount= $amount/100;
            
            $A->setTabla("pagos_modulos");
            $campos = array("status", "fecha_pago");
            $valores = array("PAGADO", date("Y-m-d H:i:s"));
            $condicion=" id>0 and status != 'PAGADO' and modulo=$modulo AND  id_socio='".$id."'";
            $A->actualizar($campos, $valores, $condicion);
            
            $existe = $A->getPagoByAlumno2024($id);
            if ($existe) {
                $campos = array("fecha_pago","pago_beca");
				$valores = array(date("Y-m-d H:i:s"),1);
				$A->setTabla("inscripciones");
				$condicion=" alumno_id>0 and alumno_id=".$id;
                $A->actualizar($campos, $valores, $condicion);
            }else{
                $A->setTabla("inscripciones");
                $campos = array("alumno_id", "estatus", "observaciones", "cambio_por", "fecha_caducidad", "fecha_pago", "monto","hema_2024","pago_beca");
                $valores = array($id, "PAGADO", "PAGADO: con Stripe ", 0, "0000-00-00 00:00:00", date("Y-m-d H:i:s"), $amount,1,1);
                $A->insertar($campos, $valores); 
            }
            
           /*  */
        }
        else{
            $existe = $A->getPagoByAlumno2024($id);
            if ($existe) {
                /* echo "existe"; */
                $campos = array("fecha_pago","pago_beca");
				$valores = array(date("Y-m-d H:i:s"),1);
				$A->setTabla("inscripciones");
                $condicion=" alumno_id>0 and alumno_id=".$id;
                $A->actualizar($campos, $valores, $condicion);
            }else{
               /*  echo "no existe"; */
                $amount= $amount/100;
                $A->setTabla("inscripciones");
                $campos = array("alumno_id", "estatus", "observaciones", "cambio_por", "fecha_caducidad", "fecha_pago", "monto","hema_2024","pago_beca");
                $valores = array($id, "PAGADO", "PAGADO: con Stripe", 0, "0000-00-00 00:00:00", date("Y-m-d H:i:s"), $amount,1,1);
                $A->insertar($campos, $valores);
            }
        }
        /* exit; */
        $alumno = $A->getAlumnoById($id);
        $H->enviarCorreoConfirmacionPago($alumno,$amount,$datosExtra);
        $H->crearMensaje("Su pago se ha realizado con exito, puede continuar a la salas en vivo o a consultar los módulos cuando estén disponibles", "success");
        header("Location: ./?seccion=pagar");
        exit;  

        exit;
    }else{
        $H->crearMensaje("No hemos podido transferir su pago", "danger");
        header("Location: ./?seccion=pagar&mod=$modulo");
        exit;
    }

} catch (\Stripe\Exception\CardException $e) {
    // Card was declined
    $H = new Helper();
    $traducciones = array(
        "Your card was declined." => "por permisos del banco.",
        "Your card has insufficient funds." => "por saldo insuficiente.",
        "Your card has expired." => "porque ha caducado.",
        "An error occurred while processing your card. Try again in a little bit." => "un error inesperado, intente de nuevo",
        "Your card's security code is incorrect." => " el código de seguridad es incorrecto",
        "Your card was declined for making repeated attempts too frequently or exceeding its amount limit." => " realizar repetidos intentos con demasiada frecuencia o exceder su límite de monto.",
        "Amount must be at least" => "La cantidad debe ser al menos de $10 mxn",
        "Your card does not support this type of purchase." => "Tu tarjeta no admite este tipo de compra."
        // Agrega más traducciones según sea necesario
    );
    $error = $e->getError();
    $mensajeError = $error->message;
    if (isset($traducciones[$mensajeError])) {
        $mensajeErrorTraducido = $traducciones[$mensajeError];
    } else {
        // Usa el mensaje original si no hay traducción disponible
        $mensajeErrorTraducido = $mensajeError;
    }
    $H->crearMensaje("Su tarjeta fue rechazada: " . $mensajeErrorTraducido, "danger");
    //$H->crearMensaje("Su tarjeta fue rechazada: " . $error->message, "danger");
    if(isset($_POST["modulo"]) && !empty($_POST["modulo"])) {
        header("Location: ./?seccion=pagar&mod=$modulo");
    }else{
        header("Location: ./?seccion=pagar");
    }
    exit;
} catch (\Exception $e) {
    // Other generic exception
    $H = new Helper();
    $H->crearMensaje("No hemos podido procesar su pago: " . $e->getMessage(), "danger");
    if(isset($_POST["modulo"]) && !empty($_POST["modulo"])) {
        header("Location: ./?seccion=pagar&mod=$modulo");
    }else{
        header("Location: ./?seccion=pagar");
    }
    exit;
}
?>