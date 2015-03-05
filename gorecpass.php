<?php

require_once('incluidos/funciones.php');

$user = filter_input(INPUT_POST, 'user');

$email = filter_input(INPUT_POST, 'mail');

if ((filter_input(INPUT_POST, 'user') == '') || (filter_input(INPUT_POST, 'mail') == '')) {
    echo "<script type='text/javascript'>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
} else {
    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email)) {
	try {
	    require_once('incluidos/connectdb.php');

	    $db = connect_db();

	    $q = "SELECT `user`, `mail` FROM `usuarios` WHERE `user` = ? AND `mail` = ? AND `estado` = 1";

	    $stm = $db->prepare($q);

	    $stm->bindParam(1, $user);

	    $stm->bindParam(2, $email);

	    $status = $stm->execute();

	    if ($stm->rowCount() > 0) {

		$com_code = md5(uniqid(rand()));

		$q2 = "UPDATE `rdg`.`usuarios` SET `com_code` = ? WHERE `usuarios`.`user` = ?;";

		$stm2 = $db->prepare($q2);

		$stm2->bindParam(1, $com_code);
		
		$stm2->bindParam(2, $user);

		$status2 = $stm2->execute();


		require 'PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();   // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;   // Enable SMTP authentication
		$mail->Username = 'francisco.r.89@gmail.com';   // SMTP username
		$mail->Password = 'bigpoppa';      // SMTP password
		$mail->SMTPSecure = 'tls';       // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587; // TCP port to connect to
		$mail->CharSet = 'UTF-8';
		$mail->From = 'francisco.r.89@gmail.com';
		$mail->FromName = 'Recuperar Contraseña';
		$mail->addAddress($email);     // Add a recipient
		$mail->isHTML(true);      // Set email format to HTML
		$mail->Subject = "RdG - Recuperar Contraseña - $user";
		$mail->Body = "<h2><b>Rendición de Gastos</b></h2><hr><br>Para resetear su contraseña haga clic en el siguiente link:<br><br> http://localhost/RdG/reset.php?resetid=$com_code&user=$user<br><br><br> Gracias.";
		if (!$mail->send()) {
		    echo 'Message could not be sent. <br>';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo '<script>alert("El mensaje ha sido enviado, revise su mail para resetear la contraseña.");window.location.assign("index.php");</script>';
		}
	    } else {
		echo "<script>alert('Datos incorrectos!'); history.back();</script>";
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
}

