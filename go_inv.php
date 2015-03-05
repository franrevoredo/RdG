<?php

require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

require_once('incluidos/connectdb.php');

$id_grupo = filter_input(INPUT_POST, 'idgrupo');

$id_inv = filter_input(INPUT_POST, 'usuario');

$userid = $_SESSION['userid'];

$timest = date("Y-m-d H:i:s");

if ((filter_input(INPUT_POST, 'idgrupo') == '') || (filter_input(INPUT_POST, 'usuario') == '')) {
    echo "<script>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
} else {
    try {
	
	$db = connect_db();
	
	$q = "SELECT `nombre` FROM `rdg`.`grupos` WHERE (`id_grupo` = ? AND `owner` = ?);";

	$stm = $db->prepare($q);

	$stm->bindParam(1, $id_grupo);

	$stm->bindParam(2, $userid);

	$status = $stm->execute();

	if ($stm->rowCount() == 1) {
	    
	    $row = $stm->fetch();
	    
	    $nom_grupo = $row['nombre'];

	    $q = "INSERT INTO `rdg`.`invitaciones` (`id_inv`, `fk_sender`, `fk_receiver`, `fk_grupo`, `estado`, `timestamp`) VALUES (NULL, ?, ?, ?, 0, ?)";

	    $stm = $db->prepare($q);

	    $stm->bindParam(1, $userid);

	    $stm->bindParam(2, $id_inv);

	    $stm->bindParam(3, $id_grupo);
	    
	    $stm->bindParam(4, $timest);

	    $status = $stm->execute();

	    if ($status) {
		echo "<script>alert('Se ha enviado la solicitud para unirse al grupo $nom_grupo satisfactoriamente.');window.location.assign('groupdetail.php?id=$id_grupo');</script>";
	    } else {
		echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('groupdetail.php?id=$id_grupo');</script>";
		die();
	    }
	} else {
	    echo "<script>alert('Usted no es dueño del grupo, no puede realizar invitaciones.');window.location.assign('groupdetail.php?id=$id_grupo');</script>";
	    die();
	}
	echo "<br><a href='groupdetail.php?id=$id_grupo'>Volver</a>";
    } catch (Exception $e) {
	// Proccess error
	$msg = $e->getMessage();
	$timestamp = date("Y-m-d H:i:s");
	$line = $e->getLine();
	$code = $e->getCode();

	handle_error($msg, $timestamp, $line, $code);
	die("oops! Parece que tenemos un error! Intente nuevamente!");
    }
}