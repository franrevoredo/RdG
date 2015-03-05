<?php

session_start();
if (isset($_SESSION['userid'])) {
    echo "<script>window.location.assign('admin.php');</script>";
}

$pass = filter_input(INPUT_POST, 'pass');

$pass2 = filter_input(INPUT_POST, 'pass2');

$user = filter_input(INPUT_POST, 'user');

require_once('incluidos/funciones.php');

if($pass == $pass2) {

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "SELECT `id_user`, `salt` FROM `usuarios` WHERE `user` = ? AND `com_code` = '' AND `estado` = 0 AND `password` = ''";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $user);

    $status = $stm->execute();

    if ($stm->rowCount() == 1) {

	$row = $stm->fetch();

	$salt = $row['salt'];

	$Blowfish_Pre = '$2a$05$';
	$Blowfish_End = '$';

	$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
	$Chars_Len = 63;


	$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;

	$hashed_password = crypt($pass, $bcrypt_salt);




	try {

	    $q2 = "UPDATE usuarios SET password=?, estado=1 WHERE user=?";

	    $stm2 = $db->prepare($q2);

	    $stm2->bindParam(1, $hashed_password);

	    $stm2->bindParam(2, $user);

	    $status2 = $stm2->execute();

	    if ($status2) {
		echo "<div>Haz definido una nueva contraseña. Ahora puedes <a href='login.php'>Logear</a>.</div>";
	    } else {
		echo "<script type='text/javascript'>alert('ERROR!'); history.back();</script>";
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
    } else {
	echo "<script type='text/javascript'>alert('Datos incorrectos!'); history.back();</script>";
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

} else {
	echo "<script type='text/javascript'>alert('Las Contraseñas no coinciden!'); history.back();</script>";
	die();
    }
?>

