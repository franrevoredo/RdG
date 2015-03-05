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
	<link href="css/gasto.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/jmenu.css" media="screen" />
	<title>Nuevo Gasto</title>
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
		<div id="content"><div id='formulario' class='formulario'><form accept-charset="UTF-8" id="form" action="go_gasto.php" method="post" >
			    <ul>
				<li>
				    <div class="titulo-form">Nuevo Gasto</div>
				</li>

				<li>
				    <label for="monto">Monto:</label>
				    <input name="monto" placeholder="Monto del Gasto" id="monto" size="50" required/>
				</li>	
				<li>
				    <label for="fecha">Fecha del Gasto:</label>
				    <input type="date" name="fecha" id="fecha"  required/>
				</li>	
				<li>
				    <label for="grupo">Grupo:</label>
				    <select name="grupo" required>
					<?php
					try {

					    require_once('incluidos/connectdb.php');

					    $userid = $_SESSION['userid'];

					    $db = connect_db();


					    $q = "SELECT * FROM `rdg`.`grupos` JOIN `rdg`.`usuario_grupo` ON (usuario_grupo.fk_id_user=? AND grupos.id_grupo=usuario_grupo.fk_id_grupo);";

					    $stm = $db->prepare($q);

					    $stm->bindParam(1, $userid);

					    $status = $stm->execute();

					    if ($stm->rowCount() > 0) {

						while ($row = $stm->fetch()) {

						    $idgru = $row['id_grupo'];
						    $nomgru = $row['nombre'];
						    echo "<option value='$idgru'>$nomgru</option>";
						}
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

				    </select>
				</li>
				<li>
				    <label for="cat">Categoría:</label>
				    <select name="cat" required>
					<?php
					try {



					    $q = "SELECT `id_cat`, `nombre` FROM `categorias` WHERE `owner` = ? AND `estado` = 1 ORDER BY `nombre` DESC";

					    $stm = $db->prepare($q);

					    $stm->bindParam(1, $userid);

					    $status = $stm->execute();

					    if ($stm->rowCount() > 0) {

						while ($row = $stm->fetch()) {

						    $idcat = $row['id_cat'];
						    $nomcat = $row['nombre'];
						    echo "<option value='$idcat'>$nomcat</option>";
						}
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
				    </select>
				</li>
				<li>
				    <label for="det">Detalle:</label>
				    <textarea name="det" placeholder="Detalle del Gasto" id="det"  cols="52" rows="6" required></textarea>
				</li>
				<li>
				    <label for="obs">Observaciones:</label>
				    <textarea name="obs" placeholder="Observaciones extra del gasto" id="obs"  cols="52" rows="6"></textarea>
				</li>
				<li>
				    <br>
				</li>
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
