<?php

session_name("COMEXANE_SESSION");

ini_set('session.cookie_path', '/'); 
ini_set('session.cookie_domain', 'comexane.com');

session_start();

define("AMBIENTE", "COMEXANE");
define("sistema_nombre", "PLATAFORMA VIRTUAL COMEXANE A.C");
define("sistema_leyenda", "CURSO COMEXANE A.C.");
define("sistema_url", "https://comexane.com/");
define("sociedad_nombre", "Colegio Mexicano de Anestesiología, A.C.");
define("sociedad_web", "https://comexane.com/");
define("sociedad_prefijo", "COMEXANE A.C");
define("sociedad_logo", "");
define("sociedad_dominio", "jc-innovation.live");

define("sociedad_direccion", "San Francisco # 1626-Desp 406, Del Valle Del. B. Juárez, Benito Juárez, 03100 Ciudad de México, CDMX");
define("sociedad_telefono", "+52 1 55 1731 4401");
define("sociedad_email_contacto", "hola@amehac.org"); //mmtac@gmail.com
define("sociedad_email_envio", "hola@amehac.org"); //ammtac@gmail.com
define("sociedad_email_copia", "jcinnovation2019@gmail.com"); //registrobrb@gmail.com
define("sociedad_email_administracion", "hola@amehac.org"); //ammtac@gmail.com
define("sociedad_email_respuesta", "hola@amehac.org"); //ammtac@gmail.com
define("sociedad_email_institucional", "hola@amehac.org"); //ammtac@gmail.com
define("sociedad_email_facturas", "hola@amehac.org");
define("sociedad_email_color", "4c5270");
define("sociedad_email_password", ",f%L%_@Lv=w.");
define("sociedad_email_usuario", "notificaciones@jc-innovation.live"); //ammtac@gmail.com

//PROVICIONAL, PORQUE EL CORREO DE LA SOCIEDAD NO ESTA VERIFICADO

define("emailRemitente", "avisos@jc-innovation.com");

//PRODUCCION 
define('key_stripe_public','pk_live_51LGlgnIHum4WRUlhJzhsff89G6JJ9rJsdh2I3iN7Ol6ynuvaIh6EXn2zn0tepKNVVfhZaa5jMkTN1e3S7KKFDQc600UXd006Rg');
define('key_stripe_secret','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');

//PRUEBAS (las keys son personales no de jc, si no funcionan posiblemente me dieron de baja la cuenta )

// define('key_stripe_public', 'pk_test_51RJJPoBX1iu9YPVaDPZzCe2NWGAz0TiDFE8SsJPeSgYBKX1ih8srrNAuagE5XIaNF4Yg88ONpUS37BggK8DHRauR00gRshOqQu');

// define('key_stripe_secret', 'sk_test_51RJJPoBX1iu9YPVaXNwh4EVeRss7AFsQ2HbqzTU4r5zguK8bEXfawED7rSKU1mOwa6LJWimkkLfwMGGPyjGr6tr3008Tkgo3IE');

define("lang", "es");
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$basePath = dirname(dirname($_SERVER['SCRIPT_NAME']));


define('BASE_URL', $scheme . "://" . $host . $basePath);

define("DIRECTORIOPLANTILLA", BASE_URL.'view/template_correos.tpl'); //PRODUCCION


define('MODULO_URL', dirname($_SERVER['SCRIPT_NAME']) . '/');
define('LAST_URL', dirname($_SERVER['REQUEST_URI']) . '/');

// produccion
// define("host", "curso-ameh.com");
// define("usuario", "cursoameh_dev26");
// define("password", "zKY^Ee-Y19J2]p_a");
// define("db", "cursoameh_curso_dev2026");

// define("DB_HOST", "localhost");
// define("DB_USER", "root");
// define("DB_PASS", "");

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "comexane_socios2026_dev");

/*define("DB_HOST", "curso-ameh.com");
define("DB_USER", "cursoameh_dev26");
define("DB_PASS", "zKY^Ee-Y19J2]p_a");
define("DB_NAME", "cursoameh_elearning2026");*/



define("DIRECTORIO", __DIR__);

// define("DIRECTORIO", dirname(__FILE__));

define("DIRECTORIO_ROOT", dirname(dirname(__FILE__)));



error_reporting(E_ALL);

ini_set('display_errors', '1');

date_default_timezone_set('America/Mexico_City');

setlocale(LC_ALL, "es_MX");



// variables globales

define("TEXT_SELECT", "Seleccione una opción");


// REDYPAY VARIABLES
define("SecretKeyRed", "8B416CAA-1110-418F-9288-311F2923EF6A");//no recuerdo si esto sirve
//MODO PRUEBAS---------------------------------------------------------------------------------------------------------------------
define("UserId", "39e80adc-736b-4fd0-bd45-51a104ec61b2");// En la Pagina aparece como API KEY
define("Password", "JDWTHu'8cR");
define("urlPay", "https://appredpayapiclientmxdev.azurewebsites.net/");

