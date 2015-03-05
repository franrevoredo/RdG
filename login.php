<?php
session_start();
if(isset($_SESSION['userid'])){
    echo "<script>window.location.assign('admin.php');</script>";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
	<link href="css/normalize.css" rel="stylesheet" type="text/css" />
	<link href="css/indice.css" rel="stylesheet" type="text/css" />
	<link href="css/form.css" rel="stylesheet" type="text/css" />
	<title>Login</title>
	
    </head>
    <body>
	<div class="logo centrar-imagen"><img src="img/logo.png" width="611" height="87"></div>
	<form accept-charset="UTF-8" id="form" action="gologin.php" method="post" >
	    <div id='formulario' class='formulario'>
		<ul>
		    <li>
			<div class="titulo-form">Login</div>
		    </li>

		    <li>
			<label for="user">Usuario:</label>
			<input name="user" placeholder="Nombre de Usuario" id="user" size="33" />
		    </li>				           
		    <li>
			<label for="pass">Password:</label>
			<input type="password" name="pass" placeholder="Contraseña" id="pass" size="33" />
		    </li><li><br></li>
		    <li><a href="recpass.php">Recuperar Password</a></li>
		    <li><a href="register.php">Registrarse</a></li>
		    <li>
			<input id="gobutton" type="submit" value="Go!"> 
		    </li>
		</ul>
	    </div>
	</form>
	<footer>
	    <hr class="style-two">
	    <div class="footer"><p>RdG Inc. © 2015 Por Francisco Revoredo.</p></div>
	</footer>
    </body>
</html>
