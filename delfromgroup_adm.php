<?php

require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

$id = filter_input(INPUT_GET, 'id');

$id_owner = $_SESSION['userid'];

$user = filter_input(INPUT_GET, 'user');


try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "SELECT * FROM `grupos` WHERE (`owner` = ? AND `id_grupo` = ?);";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $id_owner);

    $stm->bindParam(2, $id);

    $status = $stm->execute();

    if ($stm->rowCount() == 1) {

	$q = "DELETE FROM `usuario_grupo` WHERE (fk_id_user = ? AND fk_id_grupo = ?);";

	$stm = $db->prepare($q);

	$stm->bindParam(1, $user);

	$stm->bindParam(2, $id);

	$status = $stm->execute();

	if ($status) {
	    echo "<script>window.location.assign('groupdetail.php?id=$id');</script>";
	} else {
	    echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('groupdetail.php?id=$id');</script>";
	    die();
	}
    } else {
	echo "<script>alert('Usted no es el dueño de ese grupo, no puede borrar usuarios.');window.location.assign('groupdetail.php?id=$id');</script>";
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