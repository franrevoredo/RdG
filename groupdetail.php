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
	<link href="css/detallegrupo.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/jmenu.css" media="screen" />
	<title>Detalle Grupo</title>
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
			$id = filter_input(INPUT_GET, 'id');

			try {
			    require_once('incluidos/connectdb.php');

			    $userid = $_SESSION['userid'];

			    $db = connect_db();

			    $q = "SELECT `nombre` FROM `grupos` WHERE (`owner` = ? AND `id_grupo` = ? AND `estado` = 1);";

			    $stm = $db->prepare($q);

			    $stm->bindParam(1, $userid);

			    $stm->bindParam(2, $id);

			    $status = $stm->execute();

			    if ($stm->rowCount() == 1) {

				$row = $stm->fetch();

				$nom_grupo = $row['nombre'];

				echo "<div class='titulogtrabajo'>Detalle del grupo $nom_grupo</div><br>";
				echo "<table>";
				echo "<col width='250'><col width='250'><col width='50'><tr>";
				echo "<td><div class='headertabla'>Usuario</div></td><td><div class='headertabla'>Mail</div></td><td><div class='headertabla'>Acción</div></td>";
				echo "</tr>";

				$q2 = "SELECT `id_user`, `user`, `mail` FROM `usuarios` JOIN `usuario_grupo` ON (usuario_grupo.fk_id_grupo = ? AND usuarios.id_user = usuario_grupo.fk_id_user);";

				$stm2 = $db->prepare($q2);

				$stm2->bindParam(1, $id);

				$status2 = $stm2->execute();

				while ($row2 = $stm2->fetch()) {

				    $user = $row2['user'];
				    $id_user = $row2['id_user'];
				    $mail = $row2['mail'];


				    echo "<tr>";
				    echo "<td>$user</td>";
				    echo "<td>$mail</td>";
				    echo "<td>(<a href='delfromgroup_adm.php?id=$id&user=$id_user'>X</a>)</td>";
				    echo "</tr>";
				}
				echo "</table>";

				$total = $stm2->rowCount();

				echo "<br><b>Total de Usuarios: </b>$total";

				echo "<br><br><input type='button' name='invuser' value='Invitar Usuario' id='invuser'>";
				
				echo "<br><br><a href='gtrabajo.php'>Volver</a>";
				
			    } else {
				echo "<script>alert('No eres dueño de ese grupo o está desactivado, no puedes acceder a los detalles.');window.location.assign('gtrabajo.php');</script>";
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

		    </div>
		    <div id="sidebar"></div>
		    <div id="cleared"></div>
		</div>
		<script>
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


                        $("#invuser").on("click", function () {
			    var url = "<?php echo "invuser.php?id=$id"; ?>";
			    
                            window.location.href = url;
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
