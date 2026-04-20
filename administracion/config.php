<?php
//Variables de sistema
define("AMBIENTE", "VIRTUAL_AMEH A.C");
define("sistema_nombre", "PLATAFORMA VIRTUAL AMEH A.C");
define("sistema_leyenda", "CURSO AMEH A.C.");
define("sistema_url", "https://curso-ameh.com/");
define("sociedad_nombre", "Agrupación Mexicana para el Estudio de la Hematología, A.C.");
define("sociedad_web", "https://curso-ameh.com/");
define("sociedad_prefijo", "AMEH A.C");
define("sociedad_logo", "");
define("sociedad_dominio", "jc-innovation.live");
define("sociedad_direccion", "San Francisco # 1626-Desp 406, Del Valle Del. B. Juárez, Benito Juárez, 03100 Ciudad de México, CDMX");
define("sociedad_telefono", "52 (55) 5534 1856");
define("sociedad_email_contacto", "coord_administrativa@amehac.org"); //mmtac@gmail.com
define("sociedad_email_envio", "coord_administrativa@amehac.org"); //ammtac@gmail.com
define("sociedad_email_copia", "jcinnovation2019@gmail.com"); //registrobrb@gmail.com
define("sociedad_email_administracion", "coord_administrativa@amehac.org"); //ammtac@gmail.com
define("sociedad_email_respuesta", "coord_administrativa@amehac.org"); //ammtac@gmail.com
define("sociedad_email_institucional", "coord_administrativa@amehac.org"); //ammtac@gmail.com
define("sociedad_email_facturas", "coord_administrativa@amehac.org");
define("sociedad_email_color", "9D00FE");
define("sociedad_email_password", ",f%L%_@Lv=w.");
define("sociedad_email_usuario", "notificaciones@jc-innovation.live"); //ammtac@gmail.com

define("redes_fc", "https://www.facebook.com/AMEHdelDR.LuisSanchezMedal/");
define("redes_tw", "https://twitter.com/ContactoAmeh");
define("redes_ig", "");
define("redes_yt", "");
define("redes_web", "https://www.amehac.org/");

define("paypal_email", "coord_administrativa@amehac.org");

define('STRIPE_API_KEY', 'sk_test_51MmJTOGuTfIl032Majf4NM807znGxSAzFysiDxy7ke9HDgtha6enG8jYzQU4lobgTE3x4OpWkXBWsEmqT0YZSk2m007pZd6sF2'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51MmJTOGuTfIl032MCUof5RcMfmNgKRVGS3NMWUQOd7TAjJfJupvI2cNBgynNNAsQQnsdTRGppzS9itlVfLR45D4a00GxaW2FWq'); 
define('STRIPE_SUCCESS_URL', 'https://curso-ameh.com/'); //Payment success URL 
define('STRIPE_CANCEL_URL', 'https://curso-ameh.com/?seccion=check'); //Payment cancel URL 

// cofiguracion de base de datos
define("host", "curso-ameh.com");
define("usuario", "cursoameh_elearning");
define("password", "TlIDgfpfMLCQ");
define("db", "cursoameh_elearning");

define("hostSesion", "localhost");
define("usuarioSesion", "sesionesameh_live");
define("passwordSesion", "ZgQd6oze=z8q");
define("dbSesion", "sesionesameh_live_ameh");


define("DIRECTORIO", dirname(__FILE__));
// configuracion de sistema
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, "es_MX");

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
?>