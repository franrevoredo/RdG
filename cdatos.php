
<?php
require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
?>


<html>
    <head>
        <meta charset="UTF-8">
	<link href="css/normalize.css" rel="stylesheet" type="text/css" />
	<link href="css/indice.css" rel="stylesheet" type="text/css" />
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
	<link href="css/perfil.css" rel="stylesheet" type="text/css" />
	<link href="css/cdatos.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/jmenu.css" media="screen" />
	<title>Cambiar Datos</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jMenu.jquery.min.js"></script>
	<script type="text/javascript" src="js/linksmenu.js"></script>


    </head>
    <body>	    <div class="body_container"><div class="logos"><img src="img/logo.png"  width="311" height="47"></div>

	    <div id="wrapper2">
		<div id="content2"></div>
		<div id="sidebar2">
		    <ul id="jMenu">
			<li><a id="gasto">+Gasto</a></li>
			<li ><a id="inicio">Inicio</a></li>
			<li>
			    <a id="admin">Administrar</a>
			    <ul>
				<li><a id="gtrabajo">Grupos de Trabajo</a></li>
				<li><a id="ngrupo">+Grupo</a></li>
				<li><a id="categorias">Categorías</a></li>
				<li><a id="ncategoria">+Categoría</a></li>
				<li><a id="reg">Registros</a></li>
				<li><a id="nrep">Generar Reportes</a></li>
			    </ul>
			</li>
			<li><a id="perfil">Perfil</a>
			    <ul>
				<li><a id="cpass">Cambiar Clave</a></li>
				<li><a id="invit">Ver Invitaciones</a></li>
				<li><a id="dcuenta">Desactivar Cuenta</a></li>
				<li><a id="cdatos">Cambiar Datos</a></li>

			    </ul>
			</li>
			<li><a id="ayuda">Ayuda</a></li>
			<li><a id="logout">Salir</a></li>

		    </ul>
		</div>
		<div id="cleared2"></div>
	    </div>
	    <div id="wrapper">
		<div id="content"><div id='formulario' class='formulario'><form action="go_cdatos.php" method="post">


			    <?php
			    try {
				require_once('incluidos/connectdb.php');

				$user = $_SESSION['userid'];

				$db = connect_db();

				$q = "SELECT `user`, `nombre`, `apellido`, `sexo`, `mail`, `regdate` FROM `usuarios` WHERE `id_user` = ?";

				$stm = $db->prepare($q);

				$stm->bindParam(1, $user);

				$status = $stm->execute();

				if ($stm->rowCount() > 0) {

				    $row = $stm->fetch();
				    echo "<table><tbody>";
				    echo "<tr><td><div class='tituloperfil'>Cambiar Datos</div></td></tr>";
				    echo "<tr><td class='lineatitulo'><hr></td></tr>";
				    echo "<tr><td><span class='textoperfil'>Nombre de Usuario:</span><span><input type='text' name='user' value='" . $row['user'] . "'></span>";
				    echo "</td></tr>";
				    echo "<tr><td><span class='textoperfil'>Nombre: </span><span><input type='text' name='nombre' value='" . $row['nombre'] . "'></span>";
				    echo "</td></tr>";
				    echo "<tr><td><span class='textoperfil'>Apellido: </span><span><input type='text' name='apellido' value='" . $row['apellido'] . "'></span>";
				    echo "</td></tr>";
				    echo "<tr><td><span class='textoperfil'>Mail: </span><span><input type='text' name='mail' value='" . $row['mail'] . "'></span>";
				    echo "</td></tr>";

				    if ($row['sexo'] == "m") {
					echo "<tr><td><label for='reason'><span class='textoperfil'>Sexo: </span></label>";
					echo "<tr><td><input type='radio' name='sexo' value='m' checked>Masculino<br>";
					echo "<input type='radio' name='sexo' value='f'>Femenino<br></td></tr>";
				    } else {
					echo "<tr><td><label for='reason'><span class='textoperfil'>Sexo: </span></label>";
					echo "<tr><td><input type='radio' name='sexo' value='m'>Masculino<br>";
					echo "<input type='radio' name='sexo' value='f' checked>Femenino<br></td></tr>";
				    }
				    echo "</td></tr><tr><td><input id='gobutton' type='submit' value='Cambiar Datos'> </td></tr></form></table>";
				} else {
				    echo "<script type='text/javascript'>alert('Error!!'); history.back();</script>";
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
			    ?>

		    </div></div>
		<div id="sidebar"></div>
		<div id="cleared"></div>
	    </div>
	    <script type="text/javascript">
                $(document).ready(function () {


                    // simple jMenu plugin called
                    $("#jMenu").jMenu();

                    // more complex jMenu plugin called
                    $("#jMenu").jMenu({
                        ulWidth: 'auto',
                        effects: {
                            effectSpeedOpen: 300,
                            effectTypeClose: 'slide'
                        },
                        animatedText: true
                    });
                });
	    </script>
	    
	    <footer>
		<hr class="style-three">
		<div class="footerad"><p>RdG Inc. © 2015 Por Francisco Revoredo.</p></div>
	    </footer>
	</div>
    </body>
</html>
