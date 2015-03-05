<?php

require_once('incluidos/funciones.php');

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "SELECT `id_grupo` FROM `grupos` WHERE `nombre` = ?";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $nombre);

    $status = $stm->execute();

    if ($stm->rowCount() == 0) {
	
    } else {
	echo "<script>alert('Ese nombre de grupo ya existe.'); history.back();</script>";
	die();
    }
} catch (Exception $e) {
    // Proccess error
    $msg = $e->getMessage();
    $timestamp = date("Y-m-d H:i:s");
    $line = $e->getLine();
    $code = $e->getCode();

    handle_error($msg, $timestamp, $line, $code);
    die("oops! Parece que tenemos un error! Intente nuevamente!");
}
