<?php
require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

$id = filter_input(INPUT_GET, 'id');

$newid = filter_input(INPUT_POST, 'id');

$iduser = $_SESSION['userid'];

$nombre = filter_input(INPUT_POST, 'nombre');

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "SELECT `nombre` FROM `rdg`.`categorias` WHERE `id_cat`= ? AND `owner`=?;";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $id);

    $stm->bindParam(2, $iduser);

    $status = $stm->execute();

    if ($status) {
	$row = $stm->fetch();
	$valor = $row['nombre'];
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




if (filter_input(INPUT_POST, 'nombre')) {
    try {

	$q = "UPDATE `rdg`.`categorias` SET `nombre`= ? WHERE `id_cat`= ? AND `owner`=?;";

	$stm = $db->prepare($q);

	$stm->bindParam(1, $nombre);

	$stm->bindParam(2, $newid);

	$stm->bindParam(3, $iduser);

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
}
?>

<form action="renom_cat.php" method="post"><input type="text" name="nombre" value="<?php echo $valor ?>"><input type="hidden" name="id" value="<?php echo $id ?>"><input id="gobutton" type="submit" value="Cambiar Nombre"> </form>