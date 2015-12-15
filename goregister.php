<?php

require_once('incluidos/funciones.php');

$user = filter_input(INPUT_POST, 'user');

$pass_deluser = filter_input(INPUT_POST, 'pass');

$nombre = filter_input(INPUT_POST, 'nomb');

$apellido = filter_input(INPUT_POST, 'apell');

$email = filter_input(INPUT_POST, 'mail');

$sexo = filter_input(INPUT_POST, 'sexo');


if ((filter_input(INPUT_POST, 'user') == '') || (filter_input(INPUT_POST, 'pass') == '') || (filter_input(INPUT_POST, 'nomb') == '') || (filter_input(INPUT_POST, 'apell') == '') || (filter_input(INPUT_POST, 'mail') == '') || (filter_input(INPUT_POST, 'sexo') == '')) {
    echo "<script type='text/javascript'>alert('No puede haber campos vacíos!'); history.back();</script>";
    die();
} else {

    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email)) {
	try {
	    require_once('incluidos/connectdb.php');

	    $db = connect_db();

	    $q = "SELECT `user` FROM `usuarios` WHERE `mail` = ? OR `user` = ?";

	    $stm = $db->prepare($q);

	    $stm->bindParam(1, $email);
	    
	    $stm->bindParam(2, $user);

	    $status = $stm->execute();

	    if ($stm->rowCount() == 0) {




		$com_code = md5(uniqid(rand()));


		//Encriptación

		$Blowfish_Pre = '$2a$05$';
		$Blowfish_End = '$';

		$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		$Chars_Len = 63;

		// 18 would be secure as well.
		$Salt_Length = 22;

		$mysql_date = date('Y-m-d');

		$salt = "";

		for ($i = 0; $i < $Salt_Length; $i++) {
		    $salt .= $Allowed_Chars[mt_rand(0, $Chars_Len)];
		}
		$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;

		$hashed_password = crypt($pass_deluser, $bcrypt_salt);




		try {

		    $q2 = "INSERT INTO `rdg`.`usuarios` (`id_user`, `user`, `password`, `salt`, `nombre`, `apellido`, `sexo`, `mail`, `com_code`, `regdate`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		    $stm2 = $db->prepare($q2);

		    $stm2->bindParam(1, $user);

		    $stm2->bindParam(2, $hashed_password);

		    $stm2->bindParam(3, $salt);

		    $stm2->bindParam(4, $nombre);

		    $stm2->bindParam(5, $apellido);

		    $stm2->bindParam(6, $sexo);

		    $stm2->bindParam(7, $email);

		    $stm2->bindParam(8, $com_code);

		    $stm2->bindParam(9, $mysql_date);

		    $status2 = $stm2->execute();
		} catch (Exception $e) {
		    // Proccess error
		    $msg = $e->getMessage();
		    $timestamp = date("Y-m-d H:i:s");
		    $line = $e->getLine();
		    $code = $e->getCode();

		    handle_error($msg, $timestamp, $line, $code);
		    die("oops! Parece que tenemos un error! Intente nuevamente!");
		}

		$nombrecompleto = $nombre . "" . $apellido;

		require 'PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();	  // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;	  // Enable SMTP authentication
		$mail->Username = 'francisco.r.89@gmail.com';   // SMTP username
		$mail->Password = '';      // SMTP password
		$mail->SMTPSecure = 'tls';       // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;	// TCP port to connect to
		$mail->From = 'francisco.r.89@gmail.com';
		$mail->FromName = 'Gastos';
		$mail->addAddress($email, $nombrecompleto);     // Add a recipient
		$mail->isHTML(true);      // Set email format to HTML
		$mail->Subject = "RdG - Activar Cuenta $user";
		$mail->Body = "RdG<br><br>Para activar su cuenta haga clic en el siguiente link:<br><br> http://localhost/RdG/confirm.php?passkey=$com_code  ";
		if (!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    print '<script>';
		    print 'alert("Se ha enviado un link a su cuenta de email para la activación. Gracias.");window.location.assign("index.php");';
		    print '</script>';
		}
	    } else {
		echo "<script type='text/javascript'>alert('Esa dirección de Mail o Nombre de Usuario ya están en uso! Si no puedes acceder recupera la contraseña'); history.back();</script>";
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
	echo "<script type='text/javascript'>alert('Eso no es un mail válido!, intente nuevamente.'); history.back();</script>";
	die();
    }
}
