<?php

session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

require_once('incluidos/funciones.php');

$monto = filter_input(INPUT_POST, 'monto');

$fecha = filter_input(INPUT_POST, 'fecha');

$grupo = filter_input(INPUT_POST, 'grupo');

$cat = filter_input(INPUT_POST, 'cat');

$det = filter_input(INPUT_POST, 'det');

$obs = filter_input(INPUT_POST, 'obs');

$user = $_SESSION['userid'];

$timestamp = date("Y-m-d H:i:s");  

if ((filter_input(INPUT_POST, 'monto') == '') || (filter_input(INPUT_POST, 'fecha') == '') || (filter_input(INPUT_POST, 'grupo') == '') || (filter_input(INPUT_POST, 'cat') == '') || (filter_input(INPUT_POST, 'det') == '')) {
    echo "<script>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
} else {

    if($obs == '') {
	$obs = NULL;
    }
    
    
    try {
	require_once('incluidos/connectdb.php');

	$db = connect_db();

	$q = "SELECT `estado` FROM `usuarios` WHERE `id_user` = ?";

	$stm = $db->prepare($q);

	$stm->bindParam(1, $user);

	$status = $stm->execute();

	$rowuser = $stm->fetch();

	$estado_user = $rowuser['estado'];

	if ($estado_user == 1) {

	    $q = "INSERT INTO `rdg`.`gastos` (`id_gasto`, `monto`, `fk_grupo`, `fk_cat`, `fk_user`, `timestamp`, `fecha_gasto`, `detalle`, `obs`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";

	    $stm = $db->prepare($q);

	    $stm->bindParam(1, $monto);

	    $stm->bindParam(2, $grupo);

	    $stm->bindParam(3, $cat);

	    $stm->bindParam(4, $user);
	    
	    $stm->bindParam(5, $timestamp);
	    
	    $stm->bindParam(6, $fecha);
	    
	    $stm->bindParam(7, $det);
	    
	    $stm->bindParam(8, $obs);

	    $status = $stm->execute();

	    if ($status) {
		echo "<script>alert('Se ha registrado exitosamente el nuevo gasto de $$monto.');window.location.assign('admin.php');</script>";
	    } else {
		echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('gasto.php');</script>";
		die();
	    }
	    
	} else {
	    echo "<script>alert('Un Usuario Inactivo no puede realizar operaciones.'); history.back();</script>";
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