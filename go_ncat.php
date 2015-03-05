<?php

session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

require_once('incluidos/funciones.php');

$nombre = filter_input(INPUT_POST, 'ncat');

$desc = filter_input(INPUT_POST, 'desc');

$activo = filter_input(INPUT_POST, 'activo');

$userid = $_SESSION['userid'];


if ((filter_input(INPUT_POST, 'ncat') == '') || (filter_input(INPUT_POST, 'desc') == '') || (filter_input(INPUT_POST, 'activo') == '')) {
    echo "<script type='text/javascript'>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
} else {
    
    try {
	    require_once('incluidos/connectdb.php');

	    $db = connect_db();

	    $q = "SELECT `nombre` FROM `categorias` WHERE `nombre` = ? AND `owner` = ?";

	    $stm = $db->prepare($q);

	    $stm->bindParam(1, $nombre);
	    
	    $stm->bindParam(2, $userid);

	    $status = $stm->execute();

	    if ($stm->rowCount() == 0) {
		
		$q = "INSERT INTO `rdg`.`categorias` (`id_cat`, `nombre`, `descripcion`, `estado`, `owner`) VALUES (NULL, ?, ?, ?, ?);";

		$stm = $db->prepare($q);

		$stm->bindParam(1, $nombre);

		$stm->bindParam(2, $desc);

		$stm->bindParam(3, $activo);

		$stm->bindParam(4, $userid);

		$status = $stm->execute();

		if ($status) {
		    echo "<script>alert('Se ha creado exitosamente la categoría `$nombre`.');window.location.assign('categorias.php');</script>";
		} else {
		    echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('ncategoria.php');</script>";
		    die();
		}
		
		
		
	    } else {
		echo "<script type='text/javascript'>alert('Ese nombre de categoría ya existe.'); history.back();</script>";
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
    
    
}