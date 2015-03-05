<?php

require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

$id = filter_input(INPUT_GET, 'id');

$estado = filter_input(INPUT_GET, 'est');

if ($estado == 1) {
    $estado = 0;
} else {
    if ($estado == 0) {
	$estado = 1;
    }
}

try {
    require_once('incluidos/connectdb.php');

    $userid = $_SESSION['userid'];

    $db = connect_db();

    $q = "UPDATE `rdg`.`categorias` SET `estado`= ? WHERE `id_cat`= ? AND `owner`=?;";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $estado);

    $stm->bindParam(2, $id);
    
    $stm->bindParam(3, $userid);

    $status = $stm->execute();

    if ($status) {
	echo "<script>window.location.assign('categorias.php');</script>";
    } else {
	echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('gtrabajo.php');</script>";
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
?>