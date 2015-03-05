<?php

require_once('incluidos/funciones.php');

$user = filter_input(INPUT_POST, 'user');

$pass_deluser = filter_input(INPUT_POST, 'pass');

if (empty($user) or empty($pass_deluser)) {
    echo "<script type='text/javascript'>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
}

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "SELECT `id_user`, `password`, `salt`, `nombre`, `apellido`  FROM `usuarios` WHERE `user` = ? AND `com_code` = '' AND `estado` = 1";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $user);

    $status = $stm->execute();

    if ($stm->rowCount() > 0) {

	$row = $stm->fetch();

	$password = $row['password'];
	$salt = $row['salt'];


	CRYPT_BLOWFISH or die('No Blowfish found.');

	//This string tells crypt to use blowfish for 5 rounds.
	$Blowfish_Pre = '$2a$05$';
	$Blowfish_End = '$';

	$hashed_pass = crypt($pass_deluser, $Blowfish_Pre . $row['salt'] . $Blowfish_End);

	if ($hashed_pass == $password) {
	    $nombre = $row['nombre'];
	    $apellido = $row['apellido'];
	    $userid = $row['id_user'];

	    if (session_start()) {
		session_regenerate_id(true); //without this the session ID will always be the same
		$_SESSION['user'] = $user;
		$_SESSION['userid'] = $userid;
		$_SESSION['nombre'] = $nombre;
		$_SESSION['apellido'] = $apellido;
		
		echo "<script type='text/javascript'>alert('Bienvenido, $nombre $apellido. Login correcto.');window.location.assign('admin.php');</script>";
	    } else
		echo "<script type='text/javascript'>alert('Error en el inicio de sesión, intente nuevamente!!'); history.back();</script>";
		die();
	} else {
	    echo "<script type='text/javascript'>alert('Error en el usuario o la contraseña!!'); history.back();</script>";
	    die();
	}
    } else {
	echo "<script type='text/javascript'>alert('Error!! Datos incorrectos o su cuenta se encuentra desactivada.'); history.back();</script>";
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