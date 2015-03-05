<?php

require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}


$iduser = $_SESSION['userid'];

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "UPDATE `rdg`.`usuarios` SET `estado` = 0 WHERE `usuarios`.`id_user` = ?;";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $iduser);

    $status = $stm->execute();


    if ($status) {
	if (isset($_SESSION['userid'])) {
	    session_destroy();
	    setcookie(session_name(), "", time() - 3600, "/");
	    echo '<script>alert("Su cuenta ha sido desactivada. Para volver a activarla contactese con el administrador.");window.location.assign("index.php");</script>';
	} else {
	    echo "<script type='text/javascript'>alert('No hay ninguna sesión abierta!'); history.back();</script>";
	    die();
	}
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
	
    
