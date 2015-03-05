
<?php
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
	<link rel="stylesheet" type="text/css" href="css/jmenu.css" media="screen" />
	<title>Nuevo Grupo</title>
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
		<div id="content"><div id='formulario' class='formulario'><form accept-charset="UTF-8" id="form" action="go_ngrupo.php" method="post" >
			    <ul>
				<li>
				    <div class="titulo-form">Nuevo Grupo</div>
				</li>

				<li>
				    <label for="ngru">Nombre:</label>
				    <input name="ngru" id="ngru"placeholder="Nombre del Grupo"  size="33" required/>
				</li>				           
				<li>
				    <label for="desc">Descripción:</label>
				    <input name="desc" id="desc" placeholder="Descripción del Grupo" size="50" required/>
				</li>
				<li>
				    <label for="activo">Activo?:</label>
				    <select name="activo" required>
					<option value="1">Si</option>
					<option value="0">No</option>
				    </select>
				</li>
				<li>
				    <label for="def">Es Grupo por Defecto?:</label>
				    <select name="def" required>
					<option value="0">No</option>
					<option value="1">Si</option>
				    </select>
				</li>
				<li><br></li>
				<li>
				    <input id="gobutton" type="submit" value="Go!"> 
				</li>
			    </ul>
		    </div></form></div>
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
