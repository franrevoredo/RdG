<html>
    <head>
        <meta charset="UTF-8">
	<link href="css/normalize.css" rel="stylesheet" type="text/css" />
	<link href="css/indice.css" rel="stylesheet" type="text/css" />
	<link href="css/recform.css" rel="stylesheet" type="text/css" />
	<title>Recuperar Password</title>
	
    </head>
    <body>
	<div class="logo centrar-imagen"><img src="img/logo.png" width="611" height="87"></div>
	<form accept-charset="UTF-8" id="form" action="gorecpass.php" method="post" >
	    <div id='formulario' class='formulario'>
		<ul>
		    <li>
			<div class="titulo-form">Recuperar Password</div>
		    </li>

		    <li>
			<label for="user">Usuario:</label>
			<input name="user" placeholder="Nombre de Usuario" id="user" size="33" required/>
		    </li>				           
		    <li>
			<label for="mail">Mail:</label>
			<input type="email" name="mail" id="mail" placeholder="Correo Electrónico" size="33" required />
		    </li>
		    <li><a href="login.php">Volver</a></li>
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
