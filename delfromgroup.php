<?php
require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

$id = filter_input(INPUT_GET, 'id');

$iduser = $_SESSION['userid'];


try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "DELETE FROM `usuario_grupo` WHERE (fk_id_user = ? AND fk_id_grupo = ?);";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $iduser);

    $stm->bindParam(2, $id);

    $status = $stm->execute();

    if ($status) {
	echo "<script>window.location.assign('perfil.php');</script>";
    } else {
	echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('perfil.php');</script>";
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