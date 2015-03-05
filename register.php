<html>
    <head>
        <meta charset="UTF-8">
	<link href="css/normalize.css" rel="stylesheet" type="text/css" />
	<link href="css/indice.css" rel="stylesheet" type="text/css" />
	<link href="css/register.css" rel="stylesheet" type="text/css" />
	<title>Registro</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    </head>
    <body>	    <div class="logos"><img src="img/logo.png"  width="311" height="47"></div>

	<div id="wrapper2">
	    <div id="content2"></div>
	    <div id="sidebar2">
		
	    </div>
	    <div id="cleared2"></div>
	</div>
	<div id="wrapper">
	    <div id="content"><form accept-charset="UTF-8" id="form" action="goregister.php" method="post" ><div id='formulario' class='formulario'>
		    <ul>
		    <li>
			<div class="titulo-form">Registro</div>
		    </li>

		    <li>
			<label for="user">Nombre de Usuario:</label>
			<input name="user" placeholder="Nombre de Usuario" id="user" size="33" required/>
		    </li>				           
		    <li>
			<label for="pass">Password:</label>
			<input type="password" name="pass" placeholder="Contraseña" id="pass" size="33" required/>
		    </li>
		    <li>
			<label for="pass2">Repetir Password:</label>
			<input type="password" name="pass2" placeholder="Repetir Contraseña" id="pass2" size="33" required/>
		    </li>
		    <li>
			<label for="nomb">Nombre:</label>
			<input name="nomb" placeholder="Nombre" id="nomb" size="33" required/>
		    </li>
		    <li>
			<label for="apell">Apellido:</label>
			<input name="apell" id="apell" placeholder="Apellido" size="33" required />
		    </li>
		    <li>
			<label for="mail">Mail:</label>
			<input type="email" name="mail" id="mail" placeholder="Correo Electrónico" size="33" required />
		    </li>
		    <li>
			<label for="mail2">Repetir Mail:</label>
			<input type="email" name="mail2" id="mail2" placeholder="Repetir Correo Electrónico" size="33" required />
		    </li>
		    <li>
			<label for="reason">Sexo:</label>
			    <select name="sexo" required>
				<option value="m">Masculino</option>
				<option value="f">Femenino</option>
			    </select>
		    </li>
		    <li><br></li>
		    <li>
			<input id="gobutton" type="submit" value="Registrarse!"> 
		    </li>
		</ul>
		    </div></form></div>
	    <div id="sidebar"></div>
	    <div id="cleared"></div>
	</div>
		<footer>
	    <hr class="style-three">
	    <div class="footerad"><p>RdG Inc. © 2015 Por Francisco Revoredo.</p></div>
	</footer>
    </body>
</html>
