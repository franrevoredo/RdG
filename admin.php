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
	<link href="css/tabladmin.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/jmenu.css" media="screen" />
	<title>Administración</title>
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
			echo "<div class='titulodiezult'>Últimos diez Gastos Cargados</div><br>";
			echo "<table>";
			echo "<col width='180'><col width='100'><col width='120'><col width='120'><col width='220'><tr>";
			echo "<td><div class='headertabla'>Timestamp del registro</div></td><td><div class='headertabla'>Monto</div></td><td><div class='headertabla'>Grupo</div></td><td><div class='headertabla'>Categoria</div></td><td><div class='headertabla'>Fecha del gasto</div></td>";
			echo "</tr>";


			try {

			    require_once('incluidos/connectdb.php');

			    $userid = $_SESSION['userid'];

			    $db = connect_db();


			    $q = "SELECT `monto`, `fk_grupo`, `fk_cat`, `timestamp`, `fecha_gasto` FROM `gastos` WHERE `fk_user` = ? ORDER BY `timestamp` DESC LIMIT 10";

			    $stm = $db->prepare($q);

			    $stm->bindParam(1, $userid);

			    $status = $stm->execute();

			    while ($row = $stm->fetch()) {

				$monto = $row['monto'];

				$fk_grupo = $row['fk_grupo'];

				$fk_cat = $row['fk_cat'];

				$timestamp = $row['timestamp'];

				$fechagasto = $row['fecha_gasto'];



				$q1 = "SELECT `nombre` FROM `categorias` WHERE `id_cat` = ?";

				$stm1 = $db->prepare($q1);

				$stm1->bindParam(1, $fk_cat);

				$status1 = $stm1->execute();

				$rowcat = $stm1->fetch();

				$cat = $rowcat['nombre'];




				$q2 = "SELECT `nombre` FROM `grupos` WHERE `id_grupo` = ?";

				$stm2 = $db->prepare($q2);

				$stm2->bindParam(1, $fk_grupo);

				$status2 = $stm2->execute();

				$rowgru = $stm2->fetch();

				$gru = $rowgru['nombre'];

				echo "<tr>";
				echo "<td>$timestamp</td>";
				echo "<td>$$monto</td>";
				echo "<td>$gru</td>";
				echo "<td>$cat</td>";
				echo "<td>$fechagasto</td>";
				echo "</tr>";
			    }
			    echo "</table><br><br>";
			} catch (Exception $e) {
			    // Proccess error
			    $msg = $e->getMessage();
			    $timestamp = date("Y-m-d H:i:s");
			    $line = $e->getLine();
			    $code = $e->getCode();

			    handle_error($msg, $timestamp, $line, $code);
			    die("oops! Parece que tenemos un error! Intente nuevamente!");
			}

			if ((filter_input(INPUT_GET, 'mes') == '') || (filter_input(INPUT_GET, 'anio') == '')) {
			    $mes = date("m");

			    $mest = mes_atexto($mes);

			    $año = date("Y");
			} else {
			    $mes = filter_input(INPUT_GET, 'mes');

			    $mest = mes_atexto($mes);

			    $año = filter_input(INPUT_GET, 'anio');
			}
			?>

			<form action="admin.php" method="GET">
			    <span><input name="mes" value="<?php echo $mes ?>"></span>
			    <span><input name="anio" value="<?php echo $año ?>"></span>
			    <span><input id='gobutton' type='submit' value='Cambiar Período'></span>
			</form>
			<br>

<?php
echo "<div class='titulodiezult'>Gastos por Categoría en $mest de $año </div><br>";


echo "<ul>";
try {

    require_once('incluidos/connectdb.php');


    $q = "SELECT `id_cat`, `nombre` FROM `categorias` WHERE `owner` = ? AND `estado` = 1";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $userid);

    $status = $stm->execute();

    while ($row = $stm->fetch()) {

	$id_cat = $row['id_cat'];

	$nom_cat = $row['nombre'];


	$q1 = "SELECT `monto` FROM `gastos` WHERE `fk_cat` = ? AND month(fecha_gasto) = ? AND year(fecha_gasto) = ?";

	$stm1 = $db->prepare($q1);

	$stm1->bindParam(1, $id_cat);

	$stm1->bindParam(2, $mes);

	$stm1->bindParam(3, $año);

	$status1 = $stm1->execute();

	$montocat = 0;

	while ($rowcat = $stm1->fetch()) {

	    $montocat = $montocat + $rowcat['monto'];
	}

	echo "<li><span class='nomcat'>$nom_cat: </span><span>$$montocat</span></li>";
    }
    echo "</ul><br><br>";
} catch (Exception $e) {
    // Proccess error
    $msg = $e->getMessage();
    $timestamp = date("Y-m-d H:i:s");
    $line = $e->getLine();
    $code = $e->getCode();

    handle_error($msg, $timestamp, $line, $code);
    die("oops! Parece que tenemos un error! Intente nuevamente!");
}


echo "<div class='titulodiezult'>Gastos por Grupo en $mest de $año </div><br>";
echo "<ul>";
try {

    require_once('incluidos/connectdb.php');


    $q = "SELECT `id_grupo`, `nombre` FROM `grupos` WHERE `owner` = ? AND `estado` = 1";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $userid);

    $status = $stm->execute();

    while ($row = $stm->fetch()) {

	$id_grupo = $row['id_grupo'];

	$nom_grupo = $row['nombre'];


	$q1 = "SELECT `monto` FROM `gastos` WHERE `fk_grupo` = ? AND month(fecha_gasto) = ? AND year(fecha_gasto) = ?";

	$stm1 = $db->prepare($q1);

	$stm1->bindParam(1, $id_grupo);

	$stm1->bindParam(2, $mes);

	$stm1->bindParam(3, $año);

	$status1 = $stm1->execute();

	$montogrupo = 0;

	while ($rowgru = $stm1->fetch()) {

	    $montogrupo = $montogrupo + $rowgru['monto'];
	}

	echo "<li><span class='nomcat'>$nom_grupo: </span><span>$$montogrupo</span></li>";
    }
    echo "</ul><br><br>";
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
