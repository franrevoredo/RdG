<?php

session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

require_once('incluidos/funciones.php');

$nombre = filter_input(INPUT_POST, 'ngru');

$desc = filter_input(INPUT_POST, 'desc');

$activo = filter_input(INPUT_POST, 'activo');

$def = filter_input(INPUT_POST, 'def');

$user = $_SESSION['userid'];

if ((filter_input(INPUT_POST, 'ngru') == '') || (filter_input(INPUT_POST, 'desc') == '') || (filter_input(INPUT_POST, 'activo') == '') || (filter_input(INPUT_POST, 'def') == '')) {
    echo "<script>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
} else {

    try {
	require_once('incluidos/connectdb.php');

	$db = connect_db();

	$q = "SELECT `id_grupo` FROM `grupos` WHERE `nombre` = ? AND `owner` = ?";

	$stm = $db->prepare($q);

	$stm->bindParam(1, $nombre);
	
	$stm->bindParam(2, $user);

	$status = $stm->execute();

	if ($stm->rowCount() == 0) {

	    if ($def == 0) {

		$q = "INSERT INTO `rdg`.`grupos` (`id_grupo`, `nombre`, `descripcion`, `estado`, `owner`) VALUES (NULL, ?, ?, ?, ?);";

		$stm = $db->prepare($q);

		$stm->bindParam(1, $nombre);

		$stm->bindParam(2, $desc);

		$stm->bindParam(3, $activo);

		$stm->bindParam(4, $user);

		$status = $stm->execute();

		if ($status) {
		    echo "<script>alert('Se ha creado exitosamente el grupo `$nombre`.');window.location.assign('gtrabajo.php');</script>";
		} else {
		    echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('ngrupo.php');</script>";
		    die();
		}
	    } else {
		$q = "SELECT COUNT(*) FROM `rdg`.`grupos` JOIN `rdg`.`usuarios` ON (grupos.owner=usuarios.id_user AND usuarios.id_user=? AND grupos.isdefault=1);";

		$stm = $db->prepare($q);

		$stm->bindParam(1, $user);

		$status = $stm->execute();

		if ($stm->fetchColumn() == 0) {

		    $isdef = 1;

		    $q = "INSERT INTO `rdg`.`grupos` (`id_grupo`, `nombre`, `descripcion`, `estado`, `owner`, `isdefault`) VALUES (NULL, ?, ?, ?, ?, ?);";

		    $stm = $db->prepare($q);

		    $stm->bindParam(1, $nombre);

		    $stm->bindParam(2, $desc);

		    $stm->bindParam(3, $activo);

		    $stm->bindParam(4, $user);

		    $stm->bindParam(5, $isdef);

		    $status = $stm->execute();

		    if ($status) {
			echo "<script>alert('Se ha creado exitosamente el grupo `$nombre`. Ahora es su nuevo grupo por defecto.');window.location.assign('admin.php');</script>";
		    } else {
			echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('admin.php');</script>";
			die();
		    }
		} else {
		    echo "<script>alert('No se puede tener mas de un grupo por defecto al mismo tiempo.');window.location.assign('ngrupo.php');</script>";
		}
	    }
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
}