<?php

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
require __DIR__ . '/../vendor/autoload.php';


class Helper extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }

    public function crearMensaje($mensaje, $clase)
    {
        $_SESSION[AMBIENTE]['mensaje']['texto'] = $mensaje;
        $_SESSION[AMBIENTE]['mensaje']['clase'] = $clase;
    }

    public function crearSesion($rol, $id) {
        unset($_SESSION[AMBIENTE]['usuario']);
        $this->destruirSession($id);
        //session_start();
        session_regenerate_id();
        $id_sessionx = session_id();
        $_SESSION[AMBIENTE]['usuario']['rol'] = $rol;
        $_SESSION[AMBIENTE]['usuario']['id'] = $id;
        $_SESSION[AMBIENTE]['usuario']['id_sesion'] = $id_sessionx;
        return $id_sessionx;
    }

    public function destruirSession($id) {
        $campos = array("id_sesion");
        $valores = array("");
        $condicion = " alumno_id=" . $id;
        $this->setTabla("e26_logueos");
        $this->actualizar($campos, $valores, $condicion);
    }
    
    public function get_real_ip()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    public function verMensaje()
    {
        $mensaje = array("mensaje" => null, "clase" => null);
        if (isset($_SESSION[AMBIENTE]['mensaje'])) {
            $mensaje = array("texto" => $_SESSION[AMBIENTE]['mensaje']['texto'], "clase" => $_SESSION[AMBIENTE]['mensaje']['clase']);
            unset($_SESSION[AMBIENTE]['mensaje']);
        }
        return $mensaje;
    }

    public function getCategorias() {
		$sql = "SELECT * FROM categorias WHERE activo=1 order by categoria asc";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function mID($id) {
		$sql = "SELECT pm.*,m.*,ca.nombre AS nombreModulo FROM pagos_modulos as pm 
            inner join modulos as m on m.id_modulo=pm.modulo 
            LEFT JOIN cat_modulos ca ON ca.id = m.id_modulo
            where pm.id_socio=$id";
		$sentencia = $this->conexion_db->prepare($sql);
		$sentencia->execute(array());
		$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
		return $resultado;
	}

    public function enviarCorreoConfirmacionPago($alumno, $monto, $datosExtra = null) {
		$asunto = "Confirmación de pago exitoso";
		$mensaje = "
		<tr>
			<td align='left' style='color: #333333; font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 22px;'>
				
				<p style='margin: 0 0 12px 0;'>
					Estimado(a) <b> ".$alumno->nombre." ".$alumno->apellidos."</b>, su pago ha sido procesado con éxito.
				</p>

				<p style='margin: 0 0 8px 0; font-size: 15px;'>
					<b>Monto pagado:</b> $".$monto.".00 MXN
				</p>";

		if($datosExtra != null){
			if(!empty($datosExtra->modulo)) { 
				$mensaje .="<p style='margin: 0 0 8px 0; font-size: 15px;'>
								<b>Módulo adquirido:</b> ".$datosExtra->modulo."
							</p>";
			}else{
				$mensaje .= "<p style='margin: 0 0 8px 0; font-size: 15px;'>
								<b>Curso adquirido:</b> ".$datosExtra->curso."
							</p>";
			}
		}

				

	$mensaje .="<p style='margin: 20px 0 0 0;'>
					Puede acceder al sistema desde el siguiente enlace:<br>
					<a href='".sistema_url."' style='color: #1a73e8;'>
						".sistema_url."
					</a>
				</p>
			</td>
		</tr>
		<tr>
			<td height='15'></td>
		</tr>";
		return $this->enviarMail($alumno->email, $mensaje, $asunto, null, null);
	}

    public function enviarMail($email, $mensaje, $asunto, $adjunto = null, $logo_evento = null) {
        $this->EnviarCorreoBrevo($email, $mensaje, $asunto, $adjunto = null, $logo_evento = null);
	}

    public function EnviarCorreoBrevo($email, $mensaje, $asunto, $adjunto = null, $logo_evento = null)
    {
        $html = $mensaje;

        $plantilla = DIRECTORIOPLANTILLA;

        if ($logo_evento == "") {
			$logo = sociedad_logo;
		} else {
			$logo = $logo_evento;
		}


        $variables = array(
            'ASUNTO' => $asunto ?? '',
            'DIRECCION' => sociedad_direccion,
            'TELEFONO' => sociedad_telefono,
            'SOCIEDAD' =>  sociedad_nombre,
            'LOGO' => $logo ?? '',
            'EMAIL_CONTACTO' => sociedad_email_contacto,
            'ANIO' => date("Y") ?? '',
            'PREFIJO' => sociedad_prefijo,
            'COLOR' => sociedad_email_color,
            'CUERPO' => $html
        );

        if ($html = @file_get_contents($plantilla)) {
            foreach ($variables as $name => $value) {
                $html = str_replace("{" . $name . "}", $value, $html);
            }
        }

        $to = array($email = [
            'email' => $email,
        ]);

        $sender = [
            'name' => sociedad_nombre,
            'email' => emailRemitente,
        ];

        //  'email' => "webdevw21@gmail.com",
        //         'name' => "PROVEEDORES CANIFARMA"
        // $ccp = array(
        //     $email_ccp = [
        //         'email' => "webdevw21@gmail.com",
        //         'name' => "PROVEEDORES CANIFARMA"
        //     ]
        // );
        // $ccp = array(
        //     $email_ccp = [ ]
        // );



        $subject = $asunto;

        $adjunto = null;

        $datos = [
            'sender' => $sender,
            'to' => $to,
            'subject' => $subject,
            'attachment' => $adjunto,
            //'bcc' => $ccp,
            'htmlContent' => $html
        ];

        return $this->sendEmail($datos);
    }

    private function sendEmail($datos)
    {

        $apikey = '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';
        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apikey);

        $apiInstance = new TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            $config
        );

        $sendSmtpEmail = new SendSmtpEmail($datos);

        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            // print_r($result);
            // return ['success' => true, 'data' => $result];
            return true;
        } catch (Exception $e) {
            // echo 'Error al enviar el correo: ', $e->getMessage(), PHP_EOL;
            return ['success' => false, 'error' => $e->getMessage()];
            // return false;
        }
    }

    public function enviarCorreoRegistroCompleto($nombre,$apellido,$email,$password) {

		$asunto = "Confirmación de registro";
		$mensaje = '
		<tr>
		<td  align="left" style="color: #484848; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
		Estimado(a): ' . $nombre . ' ' . $apellido . ', le confirmamos que su registro ha sido exitoso.
		<br>
		<br>
		Sus datos registrados son: <br>
		Correo: <b>' . $email . '</b><br>
		Contraseña: <b>' . $password . '</b><br><br>

		Nombre: <b>' . $nombre . '</b><br>
		Apellidos: <b>' . $apellido . '</b><br>
		<br>
		<br>
		Acceso al sistema: <a href="' . sistema_url . '" >' . sistema_url . '</a>
		</td>
		</tr>
		<tr>
		<td height="15"></td>
		</tr>

		';
		return $this->enviarMail($email, $mensaje, $asunto, null, null);
	}

    public function enviarCorreoRegistro($nombre,$apellido,$email,$password) {

		
		$asunto = "Sus datos se han registrado correctamente";
		$mensaje = '
		<tr>
		<td  align="left" style="color: #484848; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
		Estimado(a): ' . $nombre . ' ' . $apellido . ', le confirmamos que sus datos se han registrado en la plataforma, para confirmar su registro le sugerimos continuar con el proceso en la plataforma realizando el pago o aplicando su código de beca.
		<br>
		<br>
		Sus datos registrados son: <br>
		Correo: <b>' . $email . '</b><br>
		Contraseña: <b>' . $password . '</b><br><br>

		Nombre: <b>' . $nombre . '</b><br>
		Apellido paterno: <b>' . $apellido . '</b><br>
		<br>
		<br>
		<br>
		Acceso al sistema: <a href="' . sistema_url . '" >' . sistema_url . '</a>
		</td>
		</tr>
		<tr>
		<td height="15"></td>
		</tr>

		';
		return $this->enviarMail($email, $mensaje, $asunto, null, null);
	}
    public function moduloPagado($id, $modulo)
    {
        $sql = "SELECT count(*) as pagado 
        FROM pagos_modulos as pm 
        inner join modulos as m on m.id_modulo=pm.modulo 
        where pm.id_socio=$id and pm.status='PAGADO' and pm.modulo=" . $modulo;
        $sentencia = $this->conexion_db->prepare($sql);
        $sentencia->execute(array());
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);
        return $resultado->pagado;
    }
}
