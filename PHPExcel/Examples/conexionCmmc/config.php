<?php
//Variables de sistema
define("sistema", "Sistema de Certificación");
define("sistema_url", "https://cmmcritica.com");
define("sociedad", "Consejo Mexicano de Medicina Crítica, A. C.");
define("sociedad_web", "https://cmmcritica.org.mx/");
define("sociedad_prefijo", "CMMC");
define("sociedad_logo", "https://cmmcritica.com/assets/images/logo500.png");
define("sociedad_dominio", "cmmcritica.com");
define("sociedad_direccion", "Ignacio Vallarta No. 1 piso 3 oficina A - 334, Colonia Tabacalera, Alcaldía Cuauhtémoc, C.P. 06030 Ciudad de México");
define("sociedad_telefono", "88 52 90 45 ext. 5005 | 55 80 61 88 69");
define("sociedad_email_contacto", "cmmc1986@gmail.com");
define("sociedad_nombre_envio", "Consejo Mexicano de Medicina Crítica A. C.");
define("sociedad_email_envio", "administracion@cmmcritica.com");
define("sociedad_email_copia", "registrobrb@gmail.com");
define("sociedad_email_administracion", "administracion@cmmcritica.com"); //cambiar
define("sociedad_email_solicitudes", "solicitudes@cmmcritica.com"); //cambiar
define("sociedad_email_respuesta", "respuestas@cmmcritica.com");
define("sociedad_email_institucional", "cmmc1986@gmail.com");
define("sociedad_email_password", "Administracion2019");
define("sociedad_email_color", "1898F9");
define("sociedad_email_usuario", "administracion@cmmcritica.com");
define("PASS_FACTURACION", "perm1224");
define("PASS_CANCELACION", "perm7623");
define("FACTURACION_SERIE", "A");
define("FACTURACION_IVA", 1.16);

define("ARCHIVO_KEY", "00001000000512462080");
define("ARCHIVO_CER", "00001000000512462080");
define("NUM_CERTIFICADO", "00001000000512462080");
define("PASS_KEY", "Con88mdcr");
define("facturacion_regimen_descripcion", "603 Personas Morales con Fines no Lucrativos");

define("facturacion_razon", "CONSEJO MEXICANO DE MEDICINA CRITICA");
define("facturacion_regimen", "603");
define("facturacion_rfc", "CMM880517DQ7");
define("facturacion_calle", "IGNACIO L VALLARTA");
define("facturacion_numext", "1");
define("facturacion_numint", "PISO 3");
define("facturacion_colonia", "TABACALERA");
define("facturacion_delomun", "CUAUHTEMOC");
define("facturacion_cp", "06030");
define("facturacion_estado", "CIUDAD DE MEXICO");
define("facturacion_direccion", "Ignacio L Vallarta No. 1 piso 3, Col. Tabacalera, Cuauhtémoc, 06030, Ciudad de México");
define("facturacion_email", "cmmc1986@gmail.com");
define("facturacion_telefono", "88 52 90 45 ext. 5005");
define("facturacion_logo", "assets/images/logo_facturacion.png");

define("USUARIO_FM", "TIE190507G17");
define("PASSWORD_FM", "da56597873bb23201cae260541369263148448c9");

define("USUARIO_FD", "CMM880517DQ7");
define("PASSWORD_FD", "zmfZO9J@");
//password antes pbIMNBLQBWV}
//
// cofiguracion de base de datos
define("host", "70.32.23.51");
define("usuario", "cmmcritica_sistema");
define("password", "6enwrg)*XeWA");
define("db", "cmmcritica_sistema");
define("DIRECTORIO", dirname(__FILE__));
// configuracion de sistema
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Mexico_City');

function money_format($format, $number) {
    $regex = array( '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?(?:#([0-9]+))?',
        '(?:\.([0-9]+))?([in%])/'
        );
    $regex = implode('', $regex);
    if (setlocale(LC_MONETARY, null) == '') {
        setlocale(LC_MONETARY, '');
    }
    $locale = localeconv();
    $number = floatval($number);
    if (!preg_match($regex, $format, $fmatch)) {
        trigger_error("No format specified or invalid format", E_USER_WARNING);
        return $number;
    }
    $flags = array( 'fillchar'	=> preg_match('/\=(.)/', $fmatch[1], $match) ? $match[1] : ' ',
        'nogroup'	=> preg_match('/\^/', $fmatch[1]) > 0,
        'usesignal'	=> preg_match('/\+|\(/', $fmatch[1], $match) ? $match[0] : '+',
        'nosimbol'	=> preg_match('/\!/', $fmatch[1]) > 0,
        'isleft'	=> preg_match('/\-/', $fmatch[1]) > 0
        );
    $width	= trim($fmatch[2]) ? (int)$fmatch[2] : 0;
    $left	= trim($fmatch[3]) ? (int)$fmatch[3] : 0;
    $right	= trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
    $conversion = $fmatch[5];
    $positive = true;
    if ($number < 0) {
        $positive = false;
        $number *= -1;
    }
    $letter = $positive ? 'p' : 'n';
    $prefix = $suffix = $cprefix = $csuffix = $signal = '';
    if (!$positive) {
        $signal = $locale['negative_sign'];
        switch (true) {
            case $locale['n_sign_posn'] == 0 || $flags['usesignal'] == '(':
            $prefix = '(';
            $suffix = ')';
            break;
            case $locale['n_sign_posn'] == 1:
            $prefix = $signal;
            break;
            case $locale['n_sign_posn'] == 2:
            $suffix = $signal;
            break;
            case $locale['n_sign_posn'] == 3:
            $cprefix = $signal;
            break;
            case $locale['n_sign_posn'] == 4:
            $csuffix = $signal;
            break;
        }
    }
    if (!$flags['nosimbol']) {
        $currency = $cprefix;
        $currency .= ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']);
        $currency .= $csuffix;
        $currency = iconv('ISO-8859-1','UTF-8',$currency);
    } else {
        $currency = '';
    }
    $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

    if (!isset($locale['mon_decimal_point']) || empty($locale['mon_decimal_point'])) {
        $locale['mon_decimal_point'] = (!isset($locale['decimal_point']) || empty($locale['decimal_point'])) ?
        $locale['decimal_point'] :
        '.';
    }

    $number = number_format($number, $right, $locale['mon_decimal_point'], $flags['nogroup'] ? '' : $locale['mon_thousands_sep'] );
    $number = explode($locale['mon_decimal_point'], $number);

    $n = strlen($prefix) + strlen($currency);
    if ($left > 0 && $left > $n) {
        if ($flags['isleft']) {
            $number[0] .= str_repeat($flags['fillchar'], $left - $n);
        } else {
            $number[0] = str_repeat($flags['fillchar'], $left - $n) . $number[0];
        }
    }
    $number = implode($locale['mon_decimal_point'], $number);
    if ($locale["{$letter}_cs_precedes"]) {
        $number = $prefix . $currency . $space . $number . $suffix;
    } else {
        $number = $prefix . $number . $space . $currency . $suffix;
    }
    if ($width > 0) {
        $number = str_pad($number, $width, $flags['fillchar'], $flags['isleft'] ? STR_PAD_RIGHT : STR_PAD_LEFT);
    }
    $format = str_replace($fmatch[0], $number, $format);
    return $format;
}
?>