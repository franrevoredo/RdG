<?php

set_error_handler("on_error");


function toDateTime($unix) {
    $q = date("Y-m-d", $unix);
    return $q;
}

function handle_error($msg, $timestamp, $line, $code) {

    $file = 'errorlog.txt';
    $data = "$timestamp // Error Message: $msg | Error Code: $code | Error Line: $line \n";
    file_put_contents($file, $data, FILE_APPEND);

    return;
}

function on_error($num, $str, $file, $line) {
    $timestamp = date("Y-m-d H:i:s");
    $filen = 'errorlog_php.txt';
    $data = "$timestamp // Error File: $file | Error Code: $num | Error Line: $line - $str \n";
    file_put_contents($filen, $data, FILE_APPEND);
}

function mes_atexto($mes) {
    
    switch ($mes) {
	case 01:
	    $texto = "Enero";
	    break;

	case 02:
	    $texto = "Febrero";
	    break;
	
	case 03:
	    $texto = "Marzo";
	    break;
	
	case 04:
	    $texto = "Abril";
	    break;
	
	case 05:
	    $texto = "Mayo";
	    break;
	
	case 06:
	    $texto = "Junio";
	    break;
	
	case 07:
	    $texto = "Julio";
	    break;
	
	case 08:
	    $texto = "Agosto";
	    break;
	
	case 09:
	    $texto = "Septiembre";
	    break;
	
	case 10:
	    $texto = "Octubre";
	    break;
	
	case 11:
	    $texto = "Noviembre";
	    break;
	
	case 12:
	    $texto = "Diciembre";
	    break;
	
	default:
	    break;
    }
    return $texto;
}