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
	<link href="css/categorias.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/jmenu.css" media="screen" />
	<title>Categorías</title>
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
		<div id="content"><div id='formulario' class='formulario'>
			<?php
			echo "<div class='titulogtrabajo'>Categorías</div><br>";
			echo "<table>";
			echo "<col width='150'><col width='200'><col width='100'><col width='220'><tr>";
			echo "<td><div class='headertabla'>Nombre</div></td><td><div class='headertabla'>Descripción</div></td><td><div class='headertabla'>Estado</div></td><td><div class='headertabla'>Acción</div></td>";
			echo "</tr>";


			try {

			    require_once('incluidos/connectdb.php');

			    $userid = $_SESSION['userid'];

			    $db = connect_db();


			    $q = "SELECT `id_cat`, `nombre`, `estado`, `descripcion` FROM `categorias` WHERE `owner` = ? ORDER BY `nombre` DESC";

			    $stm = $db->prepare($q);

			    $stm->bindParam(1, $userid);

			    $status = $stm->execute();

			    if ($stm->rowCount() > 0) {

				while ($row = $stm->fetch()) {

				    $nom_cat = $row['nombre'];

				    $estado_cat = $row['estado'];

				    if (strlen($row['descripcion']) < 18) {
					$desc = $row['descripcion'];
				    } else {

					$desc = substr($row['descripcion'], 0, 18) . "...";
				    }
				    
				    if ($estado_cat == 1) {
					$estado = "<img src='img/y.png'>";
				    } else {
					if ($estado_cat == 0) {
					    $estado = "<img src='img/n.png'>";
					}
				    }

				    $id_cat = $row['id_cat'];


				    echo "<tr>";
				    echo "<td>$nom_cat</td>";
				    echo "<td>$desc</td>";
				    echo "<td>$estado</td>";
				    echo "<td><a href='cam_est_cat.php?id=$id_cat&est=$estado_cat'>Cambiar Estado</a> - <a href='renom_cat.php?id=$id_cat'>Renombrar</a></td>";
				    echo "</tr>";
				}
				echo "</table>";
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

		    </div>
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
